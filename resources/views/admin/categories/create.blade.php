@extends('layouts.admin')

@section('title', 'Create Category')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-white">Categories</a>
    <span class="text-gray-400">/</span>
    <span class="text-white">Create</span>
@endsection

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Create Category</h1>
        <p class="text-gray-400">Add a new product category</p>
    </div>

    <!-- Form -->
    <div class="max-w-2xl">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="glass-card p-6 space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Name
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="glass-input w-full px-4 py-3"
                           required
                           autofocus>
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="glass-textarea w-full px-4 py-3">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_active" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active') ? 'checked' : '' }}
                           class="w-4 h-4 text-cyan-600 bg-gray-100 border-gray-300 rounded focus:ring-cyan-500">
                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-300">
                        Active
                    </label>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-4">
                <button type="submit" class="glass-button btn-primary px-6 py-3">
                    Create Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="glass-button px-6 py-3">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection