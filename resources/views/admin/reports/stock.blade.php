@extends('layouts.admin')

@section('title', 'Stock Report')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <span class="text-white">Reports</span>
    <span class="text-gray-400">/</span>
    <span class="text-white">Stock</span>
@stop

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white mb-2">Stock Report</h1>
        <p class="text-gray-300">Inventory overview and statistics</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Total Products</p>
                    <p class="text-2xl font-bold text-white">{{ $totalProducts }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Active Products</p>
                    <p class="text-2xl font-bold text-green-400">{{ $activeProducts }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Low Stock</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ $lowStockProducts }}</p>
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
                    <p class="text-sm text-gray-300 mb-1">Total Value</p>
                    <p class="text-2xl font-bold text-cyan-400">${{ number_format($totalValue, 2) }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-cyan-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Statistics -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-white mb-3">Category Statistics</h2>
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-white/20">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Products</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Quantity</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($categoryStats as $stat)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-white">{{ $stat['name'] }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">{{ $stat['product_count'] }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">{{ $stat['total_quantity'] }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">${{ number_format($stat['total_value'], 2) }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Products Overview -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-white mb-3">Products Overview</h2>
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-white/20">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">SKU</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Quantity</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Cost Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Value</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($products as $product)
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
                                <div class="text-sm text-gray-300">{{ $product->quantity }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">${{ number_format($product->cost_price, 2) }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">${{ number_format($product->quantity * $product->cost_price, 2) }}</div>
                            </td>
                            <td class="px-4 py-3">
                                @if($product->isLowStock())
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                        Low Stock
                                    </span>
                                @elseif($product->is_active)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop