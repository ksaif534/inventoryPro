<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'supplier'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->latest()
            ->paginate(15);

        $categories = Category::active()->pluck('name', 'id');

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->pluck('name', 'id');
        $suppliers = Supplier::active()->pluck('name', 'id');

        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Debug information
            \Log::info('Image upload attempt:', [
                'original_name' => $image->getClientOriginalName(),
                'size' => $image->getSize(),
                'mime_type' => $image->getMimeType(),
                'extension' => $image->getClientOriginalExtension(),
                'is_valid' => $image->isValid(),
                'error' => $image->getError(),
            ]);
            
            if ($image->isValid()) {
                try {
                    $validated['image'] = $image->store('products', 'public');
                    \Log::info('Image uploaded successfully:', ['path' => $validated['image']]);
                } catch (\Exception $e) {
                    \Log::error('Image storage failed:', ['error' => $e->getMessage()]);
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['image' => 'Failed to store image: ' . $e->getMessage()]);
                }
            } else {
                \Log::error('Invalid image:', ['error' => $image->getError()]);
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['image' => 'Invalid image file: ' . $image->getErrorMessage()]);
            }
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'supplier', 'stockMovements' => function ($query) {
            $query->with('user')->latest()->limit(20);
        }]);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->pluck('name', 'id');
        $suppliers = Supplier::active()->pluck('name', 'id');

        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function adjustStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        StockMovement::createMovement(
            $product->id,
            $validated['type'],
            $validated['quantity'],
            null,
            $validated['notes']
        );

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Stock adjusted successfully.');
    }
}
