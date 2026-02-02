<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_can_view_categories_index()
    {
        $categories = Category::factory()->count(3)->create();
        
        $response = $this->get(route('admin.categories.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Categories');
        $response->assertSee($categories->first()->name);
    }

    public function test_can_create_category()
    {
        $response = $this->post(route('admin.categories.store'), [
            'name' => 'Test Category',
            'description' => 'Test Description',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success', 'Category created successfully.');
        
        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);
    }

    public function test_can_edit_category()
    {
        $category = Category::factory()->create();
        
        $response = $this->get(route('admin.categories.edit', $category));
        
        $response->assertStatus(200);
        $response->assertSee($category->name);
        $response->assertSee('Edit Category');
    }

    public function test_can_update_category()
    {
        $category = Category::factory()->create();
        
        $response = $this->put(route('admin.categories.update', $category), [
            'name' => 'Updated Category',
            'description' => 'Updated Description',
            'is_active' => false,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success', 'Category updated successfully.');
        
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Category',
            'slug' => 'updated-category',
            'is_active' => false,
        ]);
    }

    public function test_can_delete_category()
    {
        $category = Category::factory()->create();
        
        $response = $this->delete(route('admin.categories.destroy', $category));
        
        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success', 'Category deleted successfully.');
        
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_cannot_delete_category_with_products()
    {
        $category = Category::factory()->hasProducts()->create();
        
        $response = $this->delete(route('admin.categories.destroy', $category));
        
        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('error', 'Cannot delete category with associated products.');
        
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_category_validation()
    {
        $response = $this->post(route('admin.categories.store'), [
            'name' => '',
            'description' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }
}