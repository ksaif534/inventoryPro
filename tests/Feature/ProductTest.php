<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_can_view_products_index()
    {
        $products = Product::factory()->count(3)->create();
        
        $response = $this->get(route('admin.products.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Products');
        $response->assertSee($products->first()->name);
    }

    public function test_can_create_product()
    {
        $category = Category::factory()->create();
        
        $response = $this->post(route('admin.products.store'), [
            'name' => 'Test Product',
            'category_id' => $category->id,
            'sku' => 'TEST-001',
            'description' => 'Test Description',
            'cost_price' => 10.50,
            'selling_price' => 15.99,
            'quantity' => 100,
            'low_stock_threshold' => 10,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success', 'Product created successfully.');
        
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'sku' => 'TEST-001',
            'category_id' => $category->id,
            'quantity' => 100,
            'is_active' => true,
        ]);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create();
        
        $response = $this->put(route('admin.products.update', $product), [
            'name' => 'Updated Product',
            'category_id' => $product->category_id,
            'cost_price' => 12.50,
            'selling_price' => 18.99,
            'low_stock_threshold' => 5,
            'is_active' => false,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success', 'Product updated successfully.');
        
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'low_stock_threshold' => 5,
            'is_active' => false,
        ]);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();
        
        $response = $this->delete(route('admin.products.destroy', $product));
        
        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success', 'Product deleted successfully.');
        
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_can_adjust_stock()
    {
        $product = Product::factory()->create(['quantity' => 50]);
        
        $response = $this->post(route('admin.products.adjust-stock', $product), [
            'type' => 'in',
            'quantity' => 25,
            'notes' => 'Stock adjustment test',
        ]);

        $response->assertRedirect(route('admin.products.show', $product));
        $response->assertSessionHas('success', 'Stock adjusted successfully.');
        
        $product->refresh();
        $this->assertEquals(75, $product->quantity);
        
        $this->assertDatabaseHas('stock_movements', [
            'product_id' => $product->id,
            'type' => 'in',
            'quantity' => 25,
            'before_quantity' => 50,
            'after_quantity' => 75,
        ]);
    }

    public function test_product_validation()
    {
        $response = $this->post(route('admin.products.store'), [
            'name' => '',
            'category_id' => '',
            'cost_price' => 'invalid',
            'selling_price' => 'invalid',
            'quantity' => 'invalid',
        ]);

        $response->assertSessionHasErrors([
            'name',
            'category_id',
            'cost_price',
            'selling_price',
            'quantity',
        ]);
    }

    public function test_low_stock_detection()
    {
        $product = Product::factory()->create([
            'quantity' => 5,
            'low_stock_threshold' => 10,
        ]);

        $this->assertTrue($product->isLowStock());
        
        $product->update(['quantity' => 15]);
        $this->assertFalse($product->isLowStock());
    }
}