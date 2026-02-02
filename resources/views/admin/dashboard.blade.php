@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <span class="text-white">Dashboard</span>
@endsection

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8 fade-in-up">
        <h1 class="text-3xl font-bold text-white mb-2">Dashboard</h1>
        <p class="text-gray-400">Welcome back! Here's what's happening with your inventory.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-label">Total Products</p>
                    <p class="stat-value">{{ $stats['total_products'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-cyan-500 to-cyan-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-label">Categories</p>
                    <p class="stat-value">{{ $stats['total_categories'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-500 to-purple-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card fade-in-up" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-label">Suppliers</p>
                    <p class="stat-value">{{ $stats['total_suppliers'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card fade-in-up" style="animation-delay: 0.4s;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-label">Low Stock Alert</p>
                    <p class="stat-value text-yellow-400">{{ $stats['low_stock_products'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Low Stock Products -->
        <div class="lg:col-span-2 glass-card p-6 fade-in-up" style="animation-delay: 0.5s;">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-white">Low Stock Products</h2>
                <a href="{{ route('admin.reports.low-stock') }}" class="text-cyan-400 hover:text-cyan-300 text-sm">
                    View All
                </a>
            </div>
            
            @if($lowStockProducts->count() > 0)
                <div class="space-y-3">
                    @foreach($lowStockProducts as $product)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white/5 border border-white/10">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-red-500/20 to-yellow-500/20 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ $product->name }}</p>
                                    <p class="text-gray-400 text-sm">{{ $product->category->name ?? 'No Category' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-white font-semibold">{{ $product->quantity }}</p>
                                <p class="text-gray-400 text-xs">Threshold: {{ $product->low_stock_threshold }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-400">All products are well stocked!</p>
                </div>
            @endif
        </div>

        <!-- Recent Stock Movements -->
        <div class="glass-card p-6 fade-in-up" style="animation-delay: 0.6s;">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-white">Recent Movements</h2>
                <a href="{{ route('admin.stock-movements.index') }}" class="text-cyan-400 hover:text-cyan-300 text-sm">
                    View All
                </a>
            </div>
            
            @if($recentMovements->count() > 0)
                <div class="space-y-3">
                    @foreach($recentMovements as $movement)
                        <div class="p-3 rounded-lg bg-white/5 border border-white/10">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-white text-sm font-medium">{{ $movement->product->name }}</p>
                                <span class="glass-badge {{ 
                                    $movement->type === 'in' ? 'badge-success' : 
                                    ($movement->type === 'out' ? 'badge-error' : 'badge-info') 
                                }}">
                                    {{ ucfirst($movement->type) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-xs text-gray-400">
                                <span>{{ $movement->quantity }} units</span>
                                <span>{{ $movement->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                    <p class="text-gray-400">No recent movements</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Monthly Purchase Trends -->
    @if($monthlyPurchases->count() > 0)
        <div class="glass-card p-6 mt-6 fade-in-up" style="animation-delay: 0.7s;">
            <h2 class="text-xl font-semibold text-white mb-4">Monthly Purchase Trends</h2>
            <div class="h-64">
                <canvas x-data="chart('bar', {
                    labels: @json($monthlyPurchases->pluck('month')->map(function($month) {
                        return \Carbon\Carbon::create()->month($month)->format('M');
                    })),
                    values: @json($monthlyPurchases->pluck('total'))
                })"></canvas>
            </div>
        </div>
    @endif
</div>
@endsection