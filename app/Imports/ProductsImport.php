<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Import;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\{
    OnEachRow,
    WithHeadingRow,
    WithChunkReading,
    WithValidation,
    WithEvents
};
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Events\{BeforeImport, AfterImport};

class ProductsImport implements
    OnEachRow,
    WithHeadingRow,
    WithChunkReading,
    WithValidation,
    WithEvents,
    ShouldQueue
{
    protected int $importId;
    protected array $buffer = [];
    protected int $bufferSize = 5000; 

    public function __construct(int $importId)
    {
        $this->importId = $importId;
    }

    public function onRow(Row $row)
    {
        $row = $row->toArray();
        if (empty($row['sku']) || empty($row['name'])) return;
        $now = now();
        $this->buffer[] = [
            'sku'         => $row['sku'],
            'name'        => $row['name'],
            'description' => $row['description'] ?? null,
            'price'       => $row['price'],
            'category_id' => $row['category_id'],
            'stock'       => $row['stock'] ?? 0,
            'created_at'  => $now,
            'updated_at'  => $now,
        ];
        if (count($this->buffer) >= $this->bufferSize) {
            $this->flushBuffer();
        }
    }

    protected function flushBuffer()
    {
        if (empty($this->buffer)) return;
        DB::transaction(function () {
            Product::upsert(
                $this->buffer,
                ['sku'],
                ['name', 'description', 'price', 'category_id', 'stock', 'updated_at']
            );
            Import::where('id', $this->importId)
                ->increment('processed_rows', count($this->buffer));
        });
        $this->buffer = [];
    }

    public function chunkSize(): int
    {
        return 10000; 
    }

    public function rules(): array
    {
        return [
            '*.sku'         => 'required|string|max:100',
            '*.name'        => 'required|string|max:255',
            '*.price'       => 'required|numeric|min:0',
            '*.category_id' => 'required|exists:categories,id',
            '*.stock'       => 'nullable|integer|min:0',
        ];
    }
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function ($event) {
                $rows = $event->getReader()->getTotalRows();
                $totalRows = is_array($rows) ? array_sum($rows) : (int)$rows;

                Import::where('id', $this->importId)->update([
                    'status' => 'running',
                    'total_rows' => max(0, $totalRows - 1),
                    'started_at' => now()
                ]);
            },

            AfterImport::class => function () {
                $this->flushBuffer();
                $import = Import::find($this->importId);
                if (!$import) {
                    return;
                }
                $endedAt = now();
                $startedAt = $import->started_at instanceof \Illuminate\Support\Carbon
                    ? $import->started_at
                    : \Illuminate\Support\Carbon::parse($import->started_at);
                $duration = $startedAt ? $startedAt->diffInSeconds($endedAt) : null;

                $import->update([
                    'status' => 'completed',
                    'ended_at' => $endedAt,
                    'duration_seconds' => $duration,
                ]);
            },
        ];
    }
}
