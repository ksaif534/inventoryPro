@extends('layouts.admin')

@section('title', 'Purchase Reports')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <span class="text-white">Reports</span>
    <span class="text-gray-400">/</span>
    <span class="text-white">Purchases</span>
@stop

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white mb-2">Purchase Reports</h1>
        <p class="text-gray-300">Purchase order analysis and trends</p>
    </div>

    <!-- Monthly Orders Chart -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-white mb-3">Monthly Purchase Trends</h2>
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div>
                    <canvas id="monthlyOrdersChart" width="400" height="200"></canvas>
                </div>
                <div>
                    <canvas id="monthlyAmountChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Orders Table -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-white mb-3">Monthly Order Summary</h2>
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-white/20">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Month</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order Count</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Average Order Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($monthlyOrders as $order)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-white">{{ date('F Y', mktime(0, 0, 0, $order->month, 1, $order->year)) }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">{{ $order->order_count }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">${{ number_format($order->total_amount, 2) }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">${{ number_format($order->total_amount / $order->order_count, 2) }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-white mb-3">Recent Purchase Orders</h2>
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-white/20">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Supplier</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($recentOrders as $order)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-white">#{{ $order->order_number }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">{{ $order->supplier->name ?? 'N/A' }}</div>
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
        </div>
    </div>

    <!-- Supplier Statistics -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-white mb-3">Supplier Performance</h2>
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-white/20">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Supplier</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order Count</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Spent</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Average Order</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($supplierStats as $stat)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-white">{{ $stat->supplier->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">{{ $stat->order_count }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">${{ number_format($stat->total_spent, 2) }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-300">${{ number_format($stat->total_spent / $stat->order_count, 2) }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

