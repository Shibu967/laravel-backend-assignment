<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Admin;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function product_can_be_created_successfully()
    {

        $admin = Admin::factory()->create();


        $category = Category::factory()->create();


        Storage::fake('public');


        $response = $this->actingAs($admin, 'admin')->postJson('/admin/products', [
            'name' => 'Test Product',
            'price' => 499.99,
            'stock' => 10,
            'category_id' => $category->id,
            'description' => 'This is a test product',
            'image' => UploadedFile::fake()->image('product.jpg'),
        ]);


        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
                'message' => 'Product created successfully',
            ]);


        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 499.99,
            'stock' => 10,
            'category_id' => $category->id,
        ]);


        $product = Product::first();
        $this->assertDatabaseHas('product_images', [
            'product_id' => $product->id,
            'is_default' => true,
        ]);

        Storage::disk('public')->assertExists($product->images->first()->image_path);
    }

    #[\PHPUnit\Framework\Attributes\Test]

    public function product_creation_fails_with_invalid_data()
    {

        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->postJson('/admin/products', [
            'name' => '',
            'price' => -10,
            'stock' => -5,
            'category_id' => 999,
        ]);


        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'price', 'stock', 'category_id']);
    }
}
