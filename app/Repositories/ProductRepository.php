<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;

class ProductRepository implements ProductRepositoryInterface
{
    public function datatable(Request $request)
    {
        $query = Product::with('category');

        if ($search = $request->search['value'] ?? null) {
            $query->where('name', 'like', "%$search%");
        }

        return [
            'draw' => intval($request->draw),
            'recordsTotal' => Product::count(),
            'recordsFiltered' => $query->count(),
            'data' => $query
                ->offset($request->start)
                ->limit($request->length)
                ->latest()
                ->get()
                ->map(function ($product) {
                    $product->category_name = $product->category?->name ?? '-';
                    return $product;
                })
        ];
    }


    public function store(array $data, ?UploadedFile $image = null)
    {
        $lastProduct = Product::orderBy('id', 'desc')->first();
        if ($lastProduct && preg_match('/PROD-(\d{6})/', $lastProduct->sku, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        } else {
            $nextNumber = 1;
        }

        $sku = 'PROD-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        $product = Product::create([
            'sku' => $sku,
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'category_id' => $data['category_id'],
            'description' => $data['description'] ?? null,
        ]);


        if ($image) {
            $imagePath = $image->store('products', 'public');
            ProductImage::create([

                'product_id' => $product->id,
                'image_path' => $imagePath,
                'is_default' => true
            ]);
        } else {
            // Default image
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/default.jpg',
                'is_default' => true
            ]);
        }

        return $product->load('images');
    }

    public function find($id)
    {

        return Product::findOrFail($id);
    }

    public function update($id, array $data)
    {
        return Product::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Product::where('id', $id)->delete();
    }
}
