@extends('layouts.admin')

@section('title', 'Suppliers')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <span class="text-white">Suppliers</span>
@stop

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white mb-2">Suppliers</h1>
            <p class="text-gray-300">Manage your supplier relationships</p>
        </div>
        <a href="{{ route('admin.suppliers.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-500 text-white font-medium rounded-lg hover:from-cyan-600 hover:to-purple-600 transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Supplier
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Total Suppliers</p>
                    <p class="text-2xl font-bold text-white">{{ $suppliers->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-300 mb-1">Active Suppliers</p>
                    <p class="text-2xl font-bold text-green-400">{{ $suppliers->where('is_active', true)->count() }}</p>
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
                    <p class="text-sm text-gray-300 mb-1">Total Purchase Orders</p>
                    <p class="text-2xl font-bold text-cyan-400">{{ $suppliers->sum('purchase_orders_count') }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-cyan-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Suppliers Table -->
    <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-white/20">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Products</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Purchase Orders</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($suppliers as $supplier)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-white">{{ $supplier->name }}</div>
                            @if($supplier->address)
                                <div class="text-xs text-gray-400 mt-1">{{ Str::limit($supplier->address, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-300">{{ $supplier->email ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-300">{{ $supplier->phone ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-300">{{ $supplier->products_count }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-300">{{ $supplier->purchase_orders_count }}</div>
                        </td>
                        <td class="px-4 py-3">
                            @if($supplier->is_active)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.suppliers.show', $supplier) }}" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">
                                    View
                                </a>
                                <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier) }}" class="inline" x-data="confirmDialog()">
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-sm font-medium"
                                            @click="confirm('Are you sure you want to delete this supplier?', () => $el.closest('form').submit())">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center">
                            <div class="text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="text-lg font-medium mb-2">No suppliers found</p>
                                <p class="text-sm mb-4">Get started by adding your first supplier.</p>
                                <a href="{{ route('admin.suppliers.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-500 text-white font-medium rounded-lg hover:from-cyan-600 hover:to-purple-600 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Supplier
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop