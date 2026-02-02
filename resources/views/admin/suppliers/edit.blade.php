@extends('layouts.admin')

@section('title', 'Edit Supplier')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.suppliers.index') }}" class="text-gray-300 hover:text-white transition-colors">Suppliers</a>
    <span class="text-gray-400">/</span>
    <span class="text-white">Edit {{ $supplier->name }}</span>
@stop

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white mb-2">Edit Supplier</h1>
        <p class="text-gray-300">Update supplier information</p>
    </div>

    <!-- Form -->
    <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-lg p-6">
        <form method="POST" action="{{ route('admin.suppliers.update', $supplier) }}">
            @csrf
            @method('PUT')
            
            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-white mb-2">Name *</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $supplier->name) }}"
                       required
                       class="w-full px-4 py-2 bg-white/5 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors"
                       placeholder="Enter supplier name">
                @error('name')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-white mb-2">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $supplier->email) }}"
                       class="w-full px-4 py-2 bg-white/5 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors"
                       placeholder="supplier@example.com">
                @error('email')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Field -->
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-white mb-2">Phone</label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       value="{{ old('phone', $supplier->phone) }}"
                       class="w-full px-4 py-2 bg-white/5 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors"
                       placeholder="+1 (555) 123-4567">
                @error('phone')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address Field -->
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-white mb-2">Address</label>
                <textarea id="address" 
                          name="address" 
                          rows="3"
                          class="w-full px-4 py-2 bg-white/5 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors resize-y"
                          placeholder="Enter supplier address">{{ old('address', $supplier->address) }}</textarea>
                @error('address')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_active" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 text-cyan-500 bg-white/5 border-white/20 rounded focus:ring-cyan-400 focus:ring-1">
                    <label for="is_active" class="ml-2 block text-sm text-white">
                        Active
                    </label>
                </div>
                <p class="mt-1 text-xs text-gray-400">Active suppliers can be selected for purchase orders</p>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.suppliers.index') }}" 
                   class="px-4 py-2 text-gray-300 hover:text-white border border-white/20 rounded-lg hover:bg-white/10 transition-all duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-purple-500 text-white font-medium rounded-lg hover:from-cyan-600 hover:to-purple-600 transition-all duration-200">
                    Update Supplier
                </button>
            </div>
        </form>
    </div>
</div>
@stop