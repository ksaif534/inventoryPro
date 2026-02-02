@extends('layouts.admin')

@section('title', 'Create Stock Movement')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.stock-movements.index') }}" class="text-gray-300 hover:text-white transition-colors">Stock Movements</a>
    <span class="text-gray-400">/</span>
    <span class="text-white">Create</span>
@stop

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white mb-2">Create Stock Movement</h1>
        <p class="text-gray-300">Record a new stock movement for inventory tracking</p>
    </div>

    <!-- Form -->
    <div class="glass-card p-6">
        <form method="POST" action="{{ route('admin.stock-movements.store') }}">
            @csrf
            
            <!-- Product Field -->
            <div class="mb-4">
                <label for="product_id" class="block text-sm font-medium text-white mb-2">Product *</label>
                <select id="product_id" 
                        name="product_id" 
                        required
                        class="w-full glass-select">
                    <option value="">Select a product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} ({{ $product->sku }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Movement Type Field -->
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-white mb-2">Movement Type *</label>
                <select id="type" 
                        name="type" 
                        required
                        class="w-full glass-select">
                    <option value="">Select movement type</option>
                    @foreach($types as $value => $label)
                        <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quantity Field -->
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-white mb-2">Quantity *</label>
                <input type="number" 
                       id="quantity" 
                       name="quantity" 
                       value="{{ old('quantity') }}"
                       min="1"
                       required
                       class="w-full glass-input"
                       placeholder="Enter quantity">
                @error('quantity')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Reference Field -->
            <div class="mb-4">
                <label for="reference" class="block text-sm font-medium text-white mb-2">Reference</label>
                <input type="text" 
                       id="reference" 
                       name="reference" 
                       value="{{ old('reference') }}"
                       class="w-full glass-input"
                       placeholder="e.g., Purchase Order #123, Adjustment #456">
                @error('reference')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Optional reference number for tracking purposes</p>
            </div>

            <!-- Notes Field -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-white mb-2">Notes</label>
                <textarea id="notes" 
                          name="notes" 
                          rows="4"
                          class="w-full glass-input resize-y"
                          placeholder="Enter any additional notes about this stock movement">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Stock Display -->
            <div id="currentStock" class="mb-6 p-4 bg-white/5 border border-white/10 rounded-lg hidden">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-cyan-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-gray-300">Current Stock: <span id="stockQuantity" class="text-white font-medium">-</span> units</span>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.stock-movements.index') }}" 
                   class="glass-button px-4 py-2">
                    Cancel
                </a>
                <button type="submit" 
                        class="glass-button btn-primary px-6 py-3">
                    Record Movement
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const typeSelect = document.getElementById('type');
    const quantityInput = document.getElementById('quantity');
    const currentStockDiv = document.getElementById('currentStock');
    const stockQuantitySpan = document.getElementById('stockQuantity');
    
    const products = @json($products->map(function($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => $product->quantity
        ];
    }));
    
    function updateStockDisplay() {
        const selectedProductId = productSelect.value;
        const selectedProduct = products.find(p => p.id == selectedProductId);
        
        if (selectedProduct) {
            stockQuantitySpan.textContent = selectedProduct.quantity;
            currentStockDiv.classList.remove('hidden');
            
            // Update quantity input max based on movement type
            if (typeSelect.value === 'out') {
                quantityInput.max = selectedProduct.quantity;
                quantityInput.placeholder = `Max: ${selectedProduct.quantity} units`;
            } else {
                quantityInput.removeAttribute('max');
                quantityInput.placeholder = 'Enter quantity';
            }
        } else {
            currentStockDiv.classList.add('hidden');
        }
    }
    
    productSelect.addEventListener('change', updateStockDisplay);
    typeSelect.addEventListener('change', updateStockDisplay);
    
    // Validation for stock out
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const selectedProductId = productSelect.value;
        const selectedProduct = products.find(p => p.id == selectedProductId);
        
        if (typeSelect.value === 'out' && selectedProduct && parseInt(quantityInput.value) > selectedProduct.quantity) {
            e.preventDefault();
            alert(`Cannot remove more units than available. Current stock: ${selectedProduct.quantity} units`);
        }
    });
});
</script>
@stop