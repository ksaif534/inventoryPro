@extends('layouts.admin')

@section('title', 'Purchase Orders')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <span class="text-white">Purchase Orders</span>
@stop

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white mb-2">Purchase Orders</h1>
            <p class="text-gray-300">Manage your purchase orders and supplier relationships</p>
        </div>
        <a href="{{ route('admin.purchase-orders.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-500 text-white font-medium rounded-lg hover:from-cyan-600 hover:to-purple-600 transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Order
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Total Orders</p>
                    <p class="text-2xl font-bold text-white">{{ $orders->total() }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Pending</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-yellow-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Approved</p>
                    <p class="text-2xl font-bold text-blue-400">{{ $stats['approved'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Received</p>
                    <p class="text-2xl font-bold text-green-400">{{ $stats['received'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase Orders Table -->
    <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-white/20">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order #</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Supplier</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Expected Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($orders as $order)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.purchase-orders.show', $order) }}" class="text-sm font-medium text-cyan-400 hover:text-cyan-300">
                                #{{ $order->order_number }}
                            </a>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-white">{{ $order->supplier->name }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-300">{{ $order->order_date->format('M d, Y') }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-300">
                                {{ $order->expected_date ? $order->expected_date->format('M d, Y') : 'N/A' }}
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-white">${{ number_format($order->total_amount, 2) }}</div>
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
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.purchase-orders.show', $order) }}" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">
                                    View
                                </a>
                                @if($order->status === 'pending')
                                    <a href="{{ route('admin.purchase-orders.edit', $order) }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.purchase-orders.destroy', $order) }}" class="inline" x-data="confirmDialog()">
                                        <button type="submit" class="text-red-400 hover:text-red-300 text-sm font-medium"
                                                @click="confirm('Are you sure you want to delete this purchase order?', () => $el.closest('form').submit())">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center">
                            <div class="text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                <p class="text-lg font-medium mb-2">No purchase orders found</p>
                                <p class="text-sm mb-4">Get started by creating your first purchase order.</p>
                                <a href="{{ route('admin.purchase-orders.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-500 text-white font-medium rounded-lg hover:from-cyan-600 hover:to-purple-600 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Order
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $orders->links('pagination::tailwind') }}
    </div>
    @endif
</div>
@stop