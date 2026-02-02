@extends('layouts.admin')

@section('title', 'Products')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <span class="text-white">Products</span>
@endsection

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Products</h1>
            <p class="text-gray-400">Manage inventory products</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="glass-button btn-primary px-6 py-3 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Product
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="glass-card p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search products..." 
                   class="glass-input px-4 py-2 flex-1 min-w-[200px]">
            
            <select name="category" class="glass-select px-4 py-2 min-w-[150px]">
                <option value="">All Categories</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}" {{ request('category') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="glass-button px-4 py-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </form>
    </div>

    <!-- Products Table -->
    <div class="glass-table overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="glass-table-head">
                    <tr>
                        <th class="px-6 py-4 text-left">Product</th>
                        <th class="px-6 py-4 text-left">SKU</th>
                        <th class="px-6 py-4 text-left">Category</th>
                        <th class="px-6 py-4 text-left">Stock</th>
                        <th class="px-6 py-4 text-left">Price</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($products as $product)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg mr-3 object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-cyan-500/20 to-purple-500/20 flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-white font-medium">{{ $product->name }}</p>
                                        <p class="text-gray-400 text-sm">{{ Str::limit($product->description, 50) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="glass-badge">{{ $product->sku }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-300">
                                {{ $product->category->name ?? 'No Category' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span class="text-white font-medium">{{ $product->quantity }}</span>
                                    @if($product->isLowStock())
                                        <svg class="w-4 h-4 text-yellow-400 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-300">
                                ${{ number_format($product->selling_price, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="glass-badge {{ $product->is_active ? 'badge-success' : 'badge-error' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                       class="p-2 text-blue-400 hover:bg-blue-400/10 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="p-2 text-cyan-400 hover:bg-cyan-400/10 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p>No products found</p>
                                    <p class="text-sm mt-1">Add your first product to get started</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="mt-6 flex items-center justify-between">
            <div class="text-gray-400 text-sm">
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
            </div>
            <div class="flex space-x-2">
                @if($products->onFirstPage())
                    <button disabled class="glass-button px-4 py-2 opacity-50">Previous</button>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="glass-button px-4 py-2">Previous</a>
                @endif

                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="glass-button px-4 py-2">Next</a>
                @else
                    <button disabled class="glass-button px-4 py-2 opacity-50">Next</button>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection