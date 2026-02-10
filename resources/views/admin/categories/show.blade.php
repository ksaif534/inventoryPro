@extends('layouts.admin')

@section('title', $category->name)

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-white">Categories</a>
    <span class="text-gray-400">/</span>
    <span class="text-white">{{ $category->name }}</span>
@endsection

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">{{ $category->name }}</h1>
            <p class="text-gray-400">{{ $category->description ?: 'No description provided' }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.categories.edit', $category) }}" class="glass-button btn-primary px-6 py-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Category
            </a>
        </div>
    </div>

    <!-- Category Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Main Info -->
        <div class="lg:col-span-2 glass-card p-6">
            <h2 class="text-xl font-semibold text-white mb-4">Category Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-400 mb-1">Name</h3>
                    <p class="text-white">{{ $category->name }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-400 mb-1">Slug</h3>
                    <span class="glass-badge">{{ $category->slug }}</span>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-400 mb-1">Status</h3>
                    <span class="glass-badge {{ $category->is_active ? 'badge-success' : 'badge-error' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-400 mb-1">Products Count</h3>
                    <p class="text-white">{{ $category->products->count() }}</p>
                </div>
            </div>
            
            @if($category->description)
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-400 mb-2">Description</h3>
                    <p class="text-gray-300">{{ $category->description }}</p>
                </div>
            @endif
        </div>

        <!-- Stats Card -->
        <div class="glass-card p-6">
            <h2 class="text-xl font-semibold text-white mb-4">Statistics</h2>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Total Products</span>
                    <span class="text-2xl font-bold text-cyan-400">{{ $category->products->count() }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Created</span>
                    <span class="text-gray-300">{{ $category->created_at->format('M j, Y') }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Last Updated</span>
                    <span class="text-gray-300">{{ $category->updated_at->format('M j, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Products in this Category -->
    <div class="glass-card p-6">
        <h2 class="text-xl font-semibold text-white mb-4">Products in this Category</h2>
        
        @if($category->products->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-white/10">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-400">Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-400">SKU</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-400">Stock</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-400">Price</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($category->products as $product)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="text-white font-medium">{{ $product->name }}</p>
                                </td>
                                <td class="px-4 py-3 text-gray-300">
                                    <span class="glass-badge">{{ $product->sku }}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-300">
                                    {{ $product->stock_quantity }}
                                </td>
                                <td class="px-4 py-3 text-gray-300">
                                    ${{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                       class="p-2 text-cyan-400 hover:bg-cyan-400/10 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p>No products in this category</p>
                    <p class="text-sm mt-1">Products assigned to this category will appear here</p>
                    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center mt-4 text-cyan-400 hover:text-cyan-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Product
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection