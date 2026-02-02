@extends('layouts.admin')

@section('title', 'Purchase Order Details')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.purchase-orders.index') }}" class="text-gray-300 hover:text-white transition-colors">Purchase Orders</a>
    <span class="text-gray-400">/</span>
    <span class="text-white">{{ $purchaseOrder->order_number }}</span>
@endsection

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-white mb-2">Purchase Order {{ $purchaseOrder->order_number }}</h1>
                <p class="text-gray-300">Created on {{ $purchaseOrder->created_at->format('M d, Y') }}</p>
            </div>
            <div class="flex space-x-2">
                @if($purchaseOrder->status === 'pending')
                    <form method="POST" action="{{ route('admin.purchase-orders.approve', $purchaseOrder) }}" class="inline">
                        @csrf
                        <button type="submit" class="glass-button px-4 py-2 bg-green-500/20 hover:bg-green-500/30 text-green-400">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Approve
                        </button>
                    </form>
                @endif
                
                @if($purchaseOrder->status === 'approved')
                    <form method="POST" action="{{ route('admin.purchase-orders.receive', $purchaseOrder) }}" class="inline">
                        @csrf
                        <button type="submit" class="glass-button px-4 py-2 bg-blue-500/20 hover:bg-blue-500/30 text-blue-400">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Mark as Received
                        </button>
                    </form>
                @endif
                
                @if($purchaseOrder->status === 'pending')
                    <a href="{{ route('admin.purchase-orders.edit', $purchaseOrder) }}" class="glass-button px-4 py-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                @endif
                
                @if($purchaseOrder->status === 'pending')
                    <form method="POST" action="{{ route('admin.purchase-orders.destroy', $purchaseOrder) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this purchase order?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="glass-button px-4 py-2 text-red-400 hover:bg-red-400/10">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6">
        <span class="glass-badge px-3 py-1
            @if($purchaseOrder->status === 'pending') bg-yellow-500/20 text-yellow-400
            @elseif($purchaseOrder->status === 'approved') bg-blue-500/20 text-blue-400
            @elseif($purchaseOrder->status === 'received') bg-green-500/20 text-green-400
            @endif">
            {{ ucfirst($purchaseOrder->status) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Supplier Information -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Supplier Information</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-400 text-sm">Supplier</span>
                        <p class="text-white font-medium">{{ $purchaseOrder->supplier->name }}</p>
                    </div>
                    @if($purchaseOrder->supplier->email)
                    <div>
                        <span class="text-gray-400 text-sm">Email</span>
                        <p class="text-white">{{ $purchaseOrder->supplier->email }}</p>
                    </div>
                    @endif
                    @if($purchaseOrder->supplier->phone)
                    <div>
                        <span class="text-gray-400 text-sm">Phone</span>
                        <p class="text-white">{{ $purchaseOrder->supplier->phone }}</p>
                    </div>
                    @endif
                    @if($purchaseOrder->expected_date)
                    <div>
                        <span class="text-gray-400 text-sm">Expected Delivery Date</span>
                        <p class="text-white">{{ $purchaseOrder->expected_date->format('M d, Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Order Items</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="text-left text-sm font-medium text-gray-300 pb-3">Product</th>
                                <th class="text-left text-sm font-medium text-gray-300 pb-3">SKU</th>
                                <th class="text-center text-sm font-medium text-gray-300 pb-3">Quantity</th>
                                <th class="text-right text-sm font-medium text-gray-300 pb-3">Unit Price</th>
                                <th class="text-right text-sm font-medium text-gray-300 pb-3">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchaseOrder->items as $item)
                                <tr class="border-b border-white/5">
                                    <td class="py-3">
                                        <div>
                                            <p class="text-white font-medium">{{ $item->product->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $item->product->category->name ?? 'No Category' }}</p>
                                        </div>
                                    </td>
                                    <td class="py-3 text-gray-300">{{ $item->product->sku }}</td>
                                    <td class="py-3 text-center text-white">{{ $item->quantity }}</td>
                                    <td class="py-3 text-right text-white">${{ number_format($item->unit_price, 2) }}</td>
                                    <td class="py-3 text-right text-white font-medium">${{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-400">No items found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($purchaseOrder->items->count() > 0)
                            <tfoot>
                                <tr class="border-t border-white/10">
                                    <td colspan="4" class="pt-3 text-right font-medium text-white">Total:</td>
                                    <td class="pt-3 text-right text-lg font-bold text-white">${{ number_format($purchaseOrder->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Order Summary -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Order Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-300">Order Number:</span>
                        <span class="text-white font-medium">{{ $purchaseOrder->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Status:</span>
                        <span class="text-white font-medium">{{ ucfirst($purchaseOrder->status) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Items:</span>
                        <span class="text-white font-medium">{{ $purchaseOrder->items->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Total Amount:</span>
                        <span class="text-white font-bold text-lg">${{ number_format($purchaseOrder->total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Created:</span>
                        <span class="text-white">{{ $purchaseOrder->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($purchaseOrder->notes)
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Notes</h2>
                <p class="text-gray-300">{{ $purchaseOrder->notes }}</p>
            </div>
            @endif

            <!-- Actions -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.purchase-orders.index') }}" class="glass-button w-full px-4 py-3 text-center inline-flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Purchase Orders
                    </a>
                    
                    @if($purchaseOrder->status === 'pending')
                        <a href="{{ route('admin.purchase-orders.edit', $purchaseOrder) }}" class="glass-button w-full px-4 py-3 text-center inline-flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Order
                        </a>
                    @endif
                    
                    <a href="{{ route('admin.purchase-orders.create') }}" class="glass-button w-full px-4 py-3 text-center inline-flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create New Order
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection