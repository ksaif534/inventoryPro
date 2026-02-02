@extends('layouts.admin')

@section('title', 'Stock Movements')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <span class="text-white">Stock Movements</span>
@endsection

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Stock Movements</h1>
            <p class="text-gray-400">Track inventory movement history</p>
        </div>
        <a href="{{ route('admin.stock-movements.create') }}" class="glass-button btn-primary px-6 py-3 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Record Movement
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="glass-card p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search products or references..." 
                   class="glass-input px-4 py-2 flex-1 min-w-[200px]">
            
            <select name="type" class="glass-select px-4 py-2 min-w-[150px]">
                <option value="">All Types</option>
                <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Stock In</option>
                <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Stock Out</option>
                <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
            </select>
            
            <input type="date" 
                   name="date_from" 
                   value="{{ request('date_from') }}"
                   placeholder="From date" 
                   class="glass-input px-4 py-2 min-w-[150px]">
            
            <input type="date" 
                   name="date_to" 
                   value="{{ request('date_to') }}"
                   placeholder="To date" 
                   class="glass-input px-4 py-2 min-w-[150px]">
            
            <button type="submit" class="glass-button px-4 py-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </form>
    </div>

    <!-- Stock Movements Table -->
    <div class="glass-table overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="glass-table-head">
                    <tr>
                        <th class="px-6 py-4 text-left">Date</th>
                        <th class="px-6 py-4 text-left">Product</th>
                        <th class="px-6 py-4 text-left">Type</th>
                        <th class="px-6 py-4 text-left">Quantity</th>
                        <th class="px-6 py-4 text-left">Reference</th>
                        <th class="px-6 py-4 text-left">Notes</th>
                        <th class="px-6 py-4 text-left">User</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($movements as $movement)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-white font-medium">{{ $movement->created_at->format('M d, Y') }}</p>
                                    <p class="text-gray-400 text-sm">{{ $movement->created_at->format('H:i') }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($movement->product->image)
                                        <img src="{{ Storage::url($movement->product->image) }}" alt="{{ $movement->product->name }}" class="w-8 h-8 rounded mr-3 object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded bg-gradient-to-r from-cyan-500/20 to-purple-500/20 flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-white font-medium">{{ $movement->product->name }}</p>
                                        <p class="text-gray-400 text-sm">{{ $movement->product->sku }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @switch($movement->type)
                                    @case('in')
                                        <span class="glass-badge badge-success">Stock In</span>
                                        @break
                                    @case('out')
                                        <span class="glass-badge badge-error">Stock Out</span>
                                        @break
                                    @case('adjustment')
                                        <span class="glass-badge badge-warning">Adjustment</span>
                                        @break
                                    @default
                                        <span class="glass-badge">{{ $movement->type }}</span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($movement->type === 'out')
                                        <span class="text-red-400 font-medium">-{{ $movement->quantity }}</span>
                                    @elseif($movement->type === 'adjustment')
                                        <span class="text-yellow-400 font-medium">{{ $movement->quantity >= 0 ? '+' : '' }}{{ $movement->quantity }}</span>
                                    @else
                                        <span class="text-green-400 font-medium">+{{ $movement->quantity }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($movement->reference_type && $movement->reference_id)
                                    <span class="glass-badge">{{ $movement->reference_type }} #{{ $movement->reference_id }}</span>
                                @else
                                    <span class="text-gray-400">Manual</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($movement->notes)
                                    <p class="text-gray-300">{{ Str::limit($movement->notes, 30) }}</p>
                                @else
                                    <span class="text-gray-400">No notes</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-300">
                                {{ $movement->user->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.stock-movements.show', $movement) }}" 
                                       class="p-2 text-blue-400 hover:bg-blue-400/10 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p>No stock movements found</p>
                                    <p class="text-sm mt-1">Stock movements will appear here once recorded</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($movements->hasPages())
        <div class="mt-6 flex items-center justify-between">
            <div class="text-gray-400 text-sm">
                Showing {{ $movements->firstItem() }} to {{ $movements->lastItem() }} of {{ $movements->total() }} results
            </div>
            <div class="flex space-x-2">
                @if($movements->onFirstPage())
                    <button disabled class="glass-button px-4 py-2 opacity-50">Previous</button>
                @else
                    <a href="{{ $movements->previousPageUrl() }}" class="glass-button px-4 py-2">Previous</a>
                @endif

                @if($movements->hasMorePages())
                    <a href="{{ $movements->nextPageUrl() }}" class="glass-button px-4 py-2">Next</a>
                @else
                    <button disabled class="glass-button px-4 py-2 opacity-50">Next</button>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection