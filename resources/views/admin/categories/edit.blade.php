@extends('layouts.admin')

@section('title', 'Edit Category')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-white">Categories</a>
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.categories.show', $category) }}" class="text-gray-400 hover:text-white">{{ $category->name }}</a>
    <span class="text-gray-400">/</span>
    <span class="text-white">Edit</span>
@endsection

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Edit Category</h1>
        <p class="text-gray-400">Update category information</p>
    </div>

    <!-- Form -->
    <div class="max-w-2xl">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="glass-card p-6 space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Name
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $category->name) }}"
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
                              class="glass-textarea w-full px-4 py-3">{{ old('description', $category->description) }}</textarea>
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
                           {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-cyan-600 bg-gray-100 border-gray-300 rounded focus:ring-cyan-500">
                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-300">
                        Active
                    </label>
                </div>

                <!-- Additional Info -->
                <div class="pt-4 border-t border-white/10">
                    <h3 class="text-sm font-medium text-gray-400 mb-3">Additional Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-400 mb-1">Slug</h4>
                            <span class="glass-badge">{{ $category->slug }}</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-400 mb-1">Products Count</h4>
                            <span class="text-gray-300">{{ $category->products()->count() }}</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-400 mb-1">Created</h4>
                            <span class="text-gray-300">{{ $category->created_at->format('M j, Y') }}</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-400 mb-1">Last Updated</h4>
                            <span class="text-gray-300">{{ $category->updated_at->format('M j, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-4">
                <button type="submit" class="glass-button btn-primary px-6 py-3">
                    Update Category
                </button>
                <a href="{{ route('admin.categories.show', $category) }}" class="glass-button px-6 py-3">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection