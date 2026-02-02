@extends('layouts.admin')

@section('title', $supplier->name)

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.suppliers.index') }}" class="text-gray-300 hover:text-white transition-colors">Suppliers</a>
    <span class="text-gray-400">/</span>
    <span class="text-white">{{ $supplier->name }}</span>
@stop

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white mb-2">{{ $supplier->name }}</h1>
            <div class="flex items-center space-x-4 text-sm text-gray-300">
                @if($supplier->email)
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $supplier->email }}
                    </span>
                @endif
                @if($supplier->phone)
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{ $supplier->phone }}
                    </span>
                @endif
            </div>
            @if($supplier->address)
                <p class="text-sm text-gray-300 mt-2">{{ $supplier->address }}</p>
            @endif
        </div>
        <div class="flex items-center space-x-2">
            @if($supplier->is_active)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                    Active
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30">
                    Inactive
                </span>
            @endif
            <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-500 text-white font-medium rounded-lg hover:from-cyan-600 hover:to-purple-600 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Products</p>
                    <p class="text-2xl font-bold text-white">{{ $supplier->products->count() }}</p>
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
                    <p class="text-sm text-gray-300 mb-1">Purchase Orders</p>
                    <p class="text-2xl font-bold text-cyan-400">{{ $supplier->purchaseOrders->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-cyan-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Total Spent</p>
                    <p class="text-2xl font-bold text-green-400">${{ number_format($supplier->purchaseOrders->where('status', '!=', 'cancelled')->sum('total_amount'), 2) }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg overflow-hidden">
        <div class="border-b border-white/20">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button class="py-4 px-1 border-b-2 border-cyan-500 text-sm font-medium text-cyan-400" data-tab="products">
                    Products ({{ $supplier->products->count() }})
                </button>
                <button class="py-4 px-1 border-b-2 border-transparent text-sm font-medium text-gray-300 hover:text-white hover:border-white/20" data-tab="orders">
                    Purchase Orders ({{ $supplier->purchaseOrders->count() }})
                </button>
            </nav>
        </div>

        <!-- Products Tab -->
        <div id="products-tab" class="p-6 tab-content">
            @if($supplier->products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-white/20">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Product</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">SKU</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Quantity</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Cost Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach($supplier->products as $product)
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <p class="text-gray-400">No products associated with this supplier</p>
                </div>
            @endif
        </div>

        <!-- Purchase Orders Tab -->
        <div id="orders-tab" class="p-6 tab-content hidden">
            @if($supplier->purchaseOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-white/20">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order #</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach($supplier->purchaseOrders as $order)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.purchase-orders.show', $order) }}" class="text-sm font-medium text-cyan-400 hover:text-cyan-300">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-300">{{ $order->order_date->format('M d, Y') }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-300">${{ number_format($order->total_amount, 2) }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                Pending
                                            </span>
                                            @break
                                        @case('approved')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                                Approved
                                            </span>
                                            @break
                                        @case('received')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                                Received
                                            </span>
                                            @break
                                        @case('cancelled')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                                Cancelled
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                    @endswitch
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <p class="text-gray-400">No purchase orders from this supplier</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabs = document.querySelectorAll('[data-tab]');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Update tab styles
            tabs.forEach(t => {
                t.classList.remove('border-cyan-500', 'text-cyan-400');
                t.classList.add('border-transparent', 'text-gray-300');
            });
            this.classList.remove('border-transparent', 'text-gray-300');
            this.classList.add('border-cyan-500', 'text-cyan-400');
            
            // Show/hide tab content
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(targetTab + '-tab').classList.remove('hidden');
        });
    });
});
</script>
@endpush