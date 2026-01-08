<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\ProductImage;

class ProductController extends Controller
{
    protected $repo;

    public function __construct(ProductRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return view('admin.products.index');
    }

    public function datatable(Request $request)
    {
        return response()->json($this->repo->datatable($request));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = $this->repo->store(
            $validated,
            $request->file('image')
        );

        return response()->json([
            'status'  => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function edit($id)
    {
        $product = $this->repo->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {

        $data = $request->only(['name', 'price', 'stock']);
        $this->repo->update($id, $data);
        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return response()->json(['success' => true]);
    }
}
