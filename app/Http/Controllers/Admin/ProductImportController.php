<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Models\Import;

class ProductImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx'
        ]);

        $import = Import::create([
            'type' => 'products',
            'status' => 'queued',
            'processed_rows' => 0,
            'total_rows' => 0
        ]);

        // Use queueImport for large files
        Excel::queueImport(
            new ProductsImport($import->id),
            $request->file('file')
        );

        return response()->json([
            'success' => true,
            'import_id' => $import->id,
            'message' => 'Import started successfully'
        ]);
    }

    // public function status($id)
    // {
    //     $import = Import::find($id);

    //     if (!$import) {
    //         return response()->json([
    //             'error' => 'Import not found'
    //         ], 404);
    //     }

    //     $progress = $import->total_rows > 0 
    //         ? round(($import->processed_rows / $import->total_rows) * 100, 2) 
    //         : 0;

    //     return response()->json([
    //         'id' => $import->id,
    //         'status' => $import->status,
    //         'processed_rows' => $import->processed_rows,
    //         'total_rows' => $import->total_rows,
    //         'progress_percentage' => $progress
    //     ]);
    // }

    public function status($id)
{
    $import = Import::find($id);

    if (!$import) {
        return response()->json(['error' => 'Import not found'], 404);
    }

    $progress = $import->total_rows > 0 
        ? round(($import->processed_rows / $import->total_rows) * 100, 2) 
        : 0;

    return response()->json([
        'id' => $import->id,
        'status' => $import->status,
        'processed_rows' => $import->processed_rows,
        'total_rows' => $import->total_rows,
        'progress_percentage' => $progress,
        'duration_seconds' => $import->duration_seconds
    ]);
}

}