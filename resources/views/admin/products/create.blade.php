@extends('layouts.admin')

@section('title', 'Create Product')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.products.index') }}" class="text-gray-300 hover:text-white transition-colors">Products</a>
    <span class="text-gray-400">/</span>
    <span class="text-white">Create</span>
@stop

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white mb-2">Create Product</h1>
        <p class="text-gray-300">Add a new product to your inventory</p>
    </div>

    <!-- Form -->
    <div class="glass-card p-6">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Name Field -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-white mb-2">Product Name *</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           required
                           class="w-full glass-input"
                           placeholder="Enter product name">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU Field -->
                <div>
                    <label for="sku" class="block text-sm font-medium text-white mb-2">SKU *</label>
                    <input type="text" 
                           id="sku" 
                           name="sku" 
                           value="{{ old('sku') }}"
                           required
                           class="w-full glass-input"
                           placeholder="Enter SKU">
                    @error('sku')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Field -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-white mb-2">Category *</label>
                    <select id="category_id" 
                            name="category_id" 
                            required
                            class="w-full glass-select">
                        <option value="">Select category</option>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cost Price Field -->
                <div>
                    <label for="cost_price" class="block text-sm font-medium text-white mb-2">Cost Price *</label>
                    <input type="number" 
                           id="cost_price" 
                           name="cost_price" 
                           value="{{ old('cost_price') }}"
                           required
                           min="0"
                           step="0.01"
                           class="w-full glass-input"
                           placeholder="0.00">
                    @error('cost_price')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Selling Price Field -->
                <div>
                    <label for="selling_price" class="block text-sm font-medium text-white mb-2">Selling Price *</label>
                    <input type="number" 
                           id="selling_price" 
                           name="selling_price" 
                           value="{{ old('selling_price') }}"
                           required
                           min="0"
                           step="0.01"
                           class="w-full glass-input"
                           placeholder="0.00">
                    @error('selling_price')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Stock Field -->
                <div>
                    <label for="quantity" class="block text-sm font-medium text-white mb-2">Current Stock *</label>
                    <input type="number" 
                           id="quantity" 
                           name="quantity" 
                           value="{{ old('quantity', 0) }}"
                           required
                           min="0"
                           class="w-full glass-input"
                           placeholder="0">
                    @error('quantity')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Low Stock Threshold Field -->
                <div>
                    <label for="low_stock_threshold" class="block text-sm font-medium text-white mb-2">Low Stock Alert</label>
                    <input type="number" 
                           id="low_stock_threshold" 
                           name="low_stock_threshold" 
                           value="{{ old('low_stock_threshold', 10) }}"
                           min="0"
                           class="w-full glass-input"
                           placeholder="10">
                    <p class="mt-1 text-xs text-gray-400">Alert when stock drops below this amount</p>
                    @error('low_stock_threshold')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Product Image -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-white mb-2">Product Image</label>
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-lg bg-white/5 border border-white/20 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <input type="file" 
                               id="image" 
                               name="image" 
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               class="w-full px-4 py-2 bg-white/5 border border-white/20 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-cyan-500/20 file:text-cyan-400 hover:file:bg-cyan-500/30">
                        <p class="mt-1 text-xs text-gray-400">Upload a product image (JPG, PNG, max 1MB)</p>
                    </div>
                </div>
                @error('image')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-white mb-2">Description</label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full glass-input resize-y"
                          placeholder="Enter product description...">{{ old('description') }}</textarea>
                @error('description')
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
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-cyan-500 bg-white/5 border-white/20 rounded focus:ring-cyan-400 focus:ring-1">
                    <label for="is_active" class="ml-2 block text-sm text-white">
                        Active
                    </label>
                </div>
                <p class="mt-1 text-xs text-gray-400">Active products can be purchased orders and sold</p>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.products.index') }}" 
                   class="glass-button px-4 py-2">
                    Cancel
                </a>
                <button type="submit" 
                        class="glass-button btn-primary px-6 py-3">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate SKU from product name if SKU is empty
    const nameInput = document.getElementById('name');
    const skuInput = document.getElementById('sku');
    
    nameInput.addEventListener('input', function() {
        if (!skuInput.value) {
            // Simple SKU generation: first 3 letters + random number
            const name = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            const prefix = name.substring(0, 3);
            const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            skuInput.value = prefix + random;
        }
    });
    
    // Image preview
    const imageInput = document.getElementById('image');
    const previewContainer = imageInput.parentElement.parentElement.querySelector('.w-20.h-20');
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover rounded-lg">`;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@stop