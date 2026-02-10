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
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white mb-2">{{ $supplier->name }}</h1>
                <div class="flex items-center space-x-4 text-sm text-gray-300">
                    @if ($supplier->email)
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $supplier->email }}
                        </span>
                    @endif
                    @if ($supplier->phone)
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $supplier->phone }}
                        </span>
                    @endif
                </div>
                @if ($supplier->address)
                    <p class="text-sm text-gray-300 mt-2">{{ $supplier->address }}</p>
                @endif
            </div>
            <div class="flex items-center space-x-3">
                @if ($supplier->is_active)
                    <span class="glass-badge badge-success">
                        Active
                    </span>
                @else
                    <span class="glass-badge badge-error">
                        Inactive
                    </span>
                @endif
                <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="glass-button btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Supplier Information -->
                <div class="glass-card p-6">
                    <h2 class="text-lg font-semibold text-white mb-4">Supplier Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-400">Email</p>
                            <p class="text-white">{{ $supplier->email ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Phone</p>
                            <p class="text-white">{{ $supplier->phone ?? 'Not provided' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-400">Address</p>
                            <p class="text-white">{{ $supplier->address ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Stats Overview -->
                <div class="glass-card p-6">
                    <h2 class="text-lg font-semibold text-white mb-4">Overview</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-400">Products</p>
                            <p class="text-2xl font-bold text-white">{{ $supplier->products->count() }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-400">Purchase Orders</p>
                            <p class="text-2xl font-bold text-cyan-400">{{ $supplier->purchaseOrders->count() }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-400">Total Spent</p>
                            <p class="text-2xl font-bold text-green-400">
                                ${{ number_format($supplier->purchaseOrders->where('status', '!=', 'cancelled')->sum('total_amount'), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
