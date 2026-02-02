@extends('layouts.admin')

@section('title', 'Low Stock Report')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <span class="text-white">Reports</span>
    <span class="text-gray-400">/</span>
    <span class="text-white">Low Stock</span>
@stop

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white mb-2">Low Stock Report</h1>
        <p class="text-gray-300">Products that need restocking</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Total Low Stock</p>
                    <p class="text-2xl font-bold text-white">{{ $lowStockProducts->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-yellow-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Critical (Out of Stock)</p>
                    <p class="text-2xl font-bold text-red-400">{{ $criticalStock->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Warning (Low Stock)</p>
                    <p class="text-2xl font-bold text-orange-400">{{ $warningStock->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-orange-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Critical Stock Section -->
    @if($criticalStock->count() > 0)
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-white mb-3 flex items-center">
            <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Critical Stock (Out of Stock)
        </h2>
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-white/20">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">SKU</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Current Stock</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Min. Level</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Cost Price</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($criticalStock as $product)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-white">{{ $product->name }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">{{ $product->sku }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">{{ $product->category->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                    {{ $product->quantity }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">{{ $product->low_stock_threshold }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">${{ number_format($product->cost_price, 2) }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Warning Stock Section -->
    @if($warningStock->count() > 0)
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-white mb-3 flex items-center">
            <svg class="w-5 h-5 text-orange-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
            Warning Stock (Below Minimum)
        </h2>
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-white/20">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">SKU</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Current Stock</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Min. Level</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Cost Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($warningStock as $product)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-white">{{ $product->name }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">{{ $product->sku }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">{{ $product->category->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-500/20 text-orange-400 border border-orange-500/30">
                                    {{ $product->quantity }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">{{ $product->low_stock_threshold }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">${{ number_format($product->cost_price, 2) }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">
                                    Manage
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Empty State -->
    @if($lowStockProducts->count() === 0)
    <div class="text-center py-12">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-green-500/20 flex items-center justify-center">
            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="text-lg font-medium text-white mb-2">All Stock Levels Good</h3>
        <p class="text-gray-400">No products are currently below their minimum stock levels.</p>
    </div>
    @endif
</div>
@stop