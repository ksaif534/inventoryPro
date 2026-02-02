@extends('layouts.admin')

@section('title', 'Stock Movement Details')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.stock-movements.index') }}" class="text-gray-300 hover:text-white transition-colors">Stock Movements</a>
    <span class="text-gray-400">/</span>
    <span class="text-white">{{ $stockMovement->id }}</span>
@endsection

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-white mb-2">Stock Movement #{{ $stockMovement->id }}</h1>
                <p class="text-gray-300">Recorded on {{ $stockMovement->created_at->format('M d, Y H:i') }}</p>
            </div>
            <a href="{{ route('admin.stock-movements.index') }}" class="glass-button px-4 py-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Stock Movements
            </a>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6">
        <span class="glass-badge px-3 py-1
            @if($stockMovement->type === 'in') bg-green-500/20 text-green-400
            @elseif($stockMovement->type === 'out') bg-red-500/20 text-red-400
            @elseif($stockMovement->type === 'adjustment') bg-yellow-500/20 text-yellow-400
            @endif">
            {{ ucfirst($stockMovement->type) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Movement Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Product Information -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Product Information</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-400 text-sm">Product Name</span>
                        <p class="text-white font-medium">{{ $stockMovement->product->name }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400 text-sm">SKU</span>
                        <p class="text-white">{{ $stockMovement->product->sku }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400 text-sm">Category</span>
                        <p class="text-white">{{ $stockMovement->product->category->name ?? 'No Category' }}</p>
                    </div>
                    @if($stockMovement->product->current_stock !== null)
                    <div>
                        <span class="text-gray-400 text-sm">Current Stock</span>
                        <p class="text-white font-medium">{{ $stockMovement->product->current_stock }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Movement Details -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Movement Details</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-400 text-sm">Type</span>
                        <p class="text-white font-medium">
                            @if($stockMovement->type === 'in') Stock In
                            @elseif($stockMovement->type === 'out') Stock Out
                            @elseif($stockMovement->type === 'adjustment') Adjustment
                            @endif
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-400 text-sm">Quantity</span>
                        <p class="text-white font-medium text-lg">{{ $stockMovement->quantity }}</p>
                    </div>
                    @if($stockMovement->reference)
                    <div>
                        <span class="text-gray-400 text-sm">Reference</span>
                        <p class="text-white">{{ $stockMovement->reference }}</p>
                    </div>
                    @endif
                    @if($stockMovement->notes)
                    <div>
                        <span class="text-gray-400 text-sm">Notes</span>
                        <p class="text-white">{{ $stockMovement->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Movement Summary -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Movement Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-300">Movement ID:</span>
                        <span class="text-white font-medium">#{{ $stockMovement->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Type:</span>
                        <span class="text-white font-medium">
                            @if($stockMovement->type === 'in') Stock In
                            @elseif($stockMovement->type === 'out') Stock Out
                            @elseif($stockMovement->type === 'adjustment') Adjustment
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Quantity:</span>
                        <span class="text-white font-bold text-lg">{{ $stockMovement->quantity }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Recorded by:</span>
                        <span class="text-white">{{ $stockMovement->user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Date:</span>
                        <span class="text-white">{{ $stockMovement->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Time:</span>
                        <span class="text-white">{{ $stockMovement->created_at->format('H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.stock-movements.create') }}" class="glass-button w-full px-4 py-3 text-center inline-flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        New Stock Movement
                    </a>
                    
                    <a href="{{ route('admin.products.show', $stockMovement->product->id) }}" class="glass-button w-full px-4 py-3 text-center inline-flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        View Product
                    </a>
                    
                    <a href="{{ route('admin.stock-movements.index') }}" class="glass-button w-full px-4 py-3 text-center inline-flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection