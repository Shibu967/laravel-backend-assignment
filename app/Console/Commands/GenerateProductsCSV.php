<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateProductsCSV extends Command
{
    protected $signature = 'generate:products-csv';
    protected $description = 'Generate sample products CSV for bulk import';

    public function handle()
    {
        $file = storage_path('app/products_sample_import.csv');
        $handle = fopen($file, 'w');

        // CSV Header (must match import)
        fputcsv($handle, [
            'sku',
            'name',
            'description',
            'price',
            'stock',
            'category_id',
            'image'
        ]);

        for ($i = 1; $i <= 100000; $i++) {
             $sku = 'PROD-' . str_pad($i, 6, '0', STR_PAD_LEFT);
            fputcsv($handle, [
                  $sku,  
                "Demo Product {$i}",
                "Description for product {$i}",
                rand(500, 100000),
                rand(1, 500),
                rand(1, 4), 
                '' 
            ]);
        }

        fclose($handle);

        $this->info('CSV generated successfully: ' . $file);
    }
}
