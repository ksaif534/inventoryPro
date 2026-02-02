@extends('layouts.admin')

@section('title', $product->name)

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.products.index') }}" class="text-gray-300 hover:text-white transition-colors">Products</a>
    <span class="text-gray-400">/</span>
    <span class="text-white">{{ $product->name }}</span>
@stop

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-lg mr-4 object-cover">
            @else
                <div class="w-16 h-16 rounded-lg bg-gradient-to-r from-cyan-500/20 to-purple-500/20 flex items-center justify-center mr-4">
                    <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            @endif
            <div>
                <h1 class="text-2xl font-bold text-white mb-1">{{ $product->name }}</h1>
                <p class="text-gray-400">SKU: {{ $product->sku }}</p>
            </div>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.products.edit', $product) }}" 
               class="glass-button px-4 py-2">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Product Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info Card -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Product Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-400">Category</p>
                        <p class="text-white">{{ $product->category->name ?? 'No Category' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Supplier</p>
                        <p class="text-white">{{ $product->supplier->name ?? 'No Supplier' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Cost Price</p>
                        <p class="text-white">${{ number_format($product->cost_price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Selling Price</p>
                        <p class="text-white">${{ number_format($product->selling_price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Status</p>
                        <span class="glass-badge {{ $product->is_active ? 'badge-success' : 'badge-error' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Profit Margin</p>
                        <p class="text-white">
                            @if($product->cost_price > 0)
                                {{ number_format((($product->selling_price - $product->cost_price) / $product->selling_price) * 100, 1) }}%
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>

                @if($product->description)
                    <div class="mt-4 pt-4 border-t border-white/10">
                        <p class="text-sm text-gray-400 mb-2">Description</p>
                        <p class="text-gray-300">{{ $product->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Stock Movements History -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Recent Stock Movements</h2>
                @if($product->stockMovements->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="text-left text-xs text-gray-400 uppercase tracking-wider">
                                <tr>
                                    <th class="pb-3">Date</th>
                                    <th class="pb-3">Type</th>
                                    <th class="pb-3">Quantity</th>
                                    <th class="pb-3">User</th>
                                    <th class="pb-3">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach($product->stockMovements as $movement)
                                    <tr class="border-t border-white/5">
                                        <td class="py-3">
                                            <div>
                                                <p class="text-white">{{ $movement->created_at->format('M d, Y') }}</p>
                                                <p class="text-gray-400">{{ $movement->created_at->format('H:i') }}</p>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            @switch($movement->type)
                                                @case('in')
                                                    <span class="glass-badge badge-success text-xs">Stock In</span>
                                                    @break
                                                @case('out')
                                                    <span class="glass-badge badge-error text-xs">Stock Out</span>
                                                    @break
                                                @case('adjustment')
                                                    <span class="glass-badge badge-warning text-xs">Adjustment</span>
                                                    @break
                                                @default
                                                    <span class="glass-badge text-xs">{{ $movement->type }}</span>
                                            @endswitch
                                        </td>
                                        <td class="py-3">
                                            @if($movement->type === 'out')
                                                <span class="text-red-400">-{{ $movement->quantity }}</span>
                                            @elseif($movement->type === 'adjustment')
                                                <span class="text-yellow-400">{{ $movement->quantity >= 0 ? '+' : '' }}{{ $movement->quantity }}</span>
                                            @else
                                                <span class="text-green-400">+{{ $movement->quantity }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 text-gray-300">{{ $movement->user->name ?? 'System' }}</td>
                                        <td class="py-3 text-gray-300">{{ Str::limit($movement->notes, 30) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($product->stockMovements->count() >= 20)
                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.stock-movements.index', ['search' => $product->name]) }}" 
                               class="text-cyan-400 hover:text-cyan-300 text-sm">
                                View all movements →
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-gray-400">No stock movements recorded yet</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stock Status Sidebar -->
        <div class="space-y-6">
            <!-- Stock Status Card -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Stock Status</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-400">Current Stock</p>
                        <p class="text-2xl font-bold text-white">{{ $product->quantity }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-400">Low Stock Alert</p>
                        <p class="text-white">{{ $product->low_stock_threshold }}</p>
                    </div>

                    <div>
                        @if($product->isLowStock())
                            <div class="p-3 bg-yellow-500/20 border border-yellow-500/30 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <p class="text-yellow-400 font-medium">Low Stock Alert</p>
                                        <p class="text-yellow-300 text-sm">Stock below threshold</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="p-3 bg-green-500/20 border border-green-500/30 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <p class="text-green-400 font-medium">Adequate Stock</p>
                                        <p class="text-green-300 text-sm">Above minimum threshold</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.stock-movements.create', ['product_id' => $product->id]) }}" 
                       class="block w-full text-center glass-button btn-primary">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Record Stock Movement
                    </a>
                    
                    @if($product->isLowStock())
                        <a href="{{ route('admin.purchase-orders.create') }}" 
                           class="block w-full text-center glass-button px-4 py-2">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Create Purchase Order
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop