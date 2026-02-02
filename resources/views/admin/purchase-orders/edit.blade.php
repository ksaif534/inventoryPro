@extends('layouts.admin')

@section('title', 'Edit Purchase Order')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.purchase-orders.index') }}" class="text-gray-300 hover:text-white transition-colors">Purchase Orders</a>
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.purchase-orders.show', $purchaseOrder) }}" class="text-gray-300 hover:text-white transition-colors">{{ $purchaseOrder->order_number }}</a>
    <span class="text-gray-400">/</span>
    <span class="text-white">Edit</span>
@endsection

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white mb-2">Edit Purchase Order</h1>
        <p class="text-gray-300">Update purchase order {{ $purchaseOrder->order_number }}</p>
    </div>

    <!-- Form -->
    <div class="glass-card p-6">
        <form method="POST" action="{{ route('admin.purchase-orders.update', $purchaseOrder) }}" id="purchase-order-form">
            @csrf
            @method('PUT')
            
            <!-- Supplier Selection -->
            <div class="mb-6">
                <label for="supplier_id" class="block text-sm font-medium text-white mb-2">Supplier *</label>
                <select id="supplier_id" 
                        name="supplier_id" 
                        required
                        class="w-full glass-select">
                    <option value="">Select a supplier</option>
                    @foreach($suppliers as $id => $name)
                        <option value="{{ $id }}" {{ old('supplier_id', $purchaseOrder->supplier_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Items Section -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <label class="block text-sm font-medium text-white">Order Items *</label>
                    <div class="flex space-x-2">
                        <button type="button" onclick="console.log('Test clicked'); alert('JavaScript working!')" class="glass-button px-3 py-1 text-sm bg-red-500/20">
                            Test JS
                        </button>
                        <button type="button" onclick="addItem()" class="glass-button px-3 py-1 text-sm">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Item
                        </button>
                    </div>
                </div>

                <!-- Items Container -->
                <div id="items-container" class="space-y-4">
                    <!-- Existing items will be loaded here -->
                    @foreach($purchaseOrder->items as $index => $item)
                    <div class="glass-card p-4" id="item-{{ $index + 1 }}">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-medium text-white">Item {{ $index + 1 }}</span>
                            <button type="button" onclick="removeItem('item-{{ $index + 1 }}')" class="p-2 text-red-400 hover:bg-red-400/10 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs text-gray-300 mb-1">Product *</label>
                                <select name="items[{{ $index + 1 }}][product_id]" required onchange="updateItemTotal({{ $index + 1 }})" class="w-full glass-select text-sm">
                                    <option value="">Select product</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->sku }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-300 mb-1">Quantity *</label>
                                <input type="number" name="items[{{ $index + 1 }}][quantity]" required min="1" value="{{ old('items.' . ($index + 1) . '.quantity', $item->quantity) }}" onchange="updateItemTotal({{ $index + 1 }})" class="w-full glass-input text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-300 mb-1">Unit Price *</label>
                                <input type="number" name="items[{{ $index + 1 }}][unit_price]" required min="0" step="0.01" value="{{ old('items.' . ($index + 1) . '.unit_price', $item->unit_price) }}" onchange="updateItemTotal({{ $index + 1 }})" class="w-full glass-input text-sm">
                            </div>
                        </div>
                        <div class="mt-2 text-right">
                            <span class="glass-badge">Total: $<span id="total-{{ $index + 1 }}">{{ number_format($item->quantity * $item->unit_price, 2) }}</span></span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="mt-4 p-4 bg-white/5 rounded-lg border border-white/10">
                    <div class="flex justify-between items-center">
                        <span class="text-white font-medium">Order Total:</span>
                        <span class="glass-badge text-lg">$<span id="order-total">{{ number_format($purchaseOrder->total_amount, 2) }}</span></span>
                    </div>
                </div>

                @error('items')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Expected Date -->
            <div class="mb-6">
                <label for="expected_date" class="block text-sm font-medium text-white mb-2">Expected Delivery Date</label>
                <input type="date" 
                       id="expected_date" 
                       name="expected_date" 
                       value="{{ old('expected_date', $purchaseOrder->expected_date ? $purchaseOrder->expected_date->format('Y-m-d') : '') }}"
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       class="w-full glass-input">
                @error('expected_date')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-white mb-2">Notes</label>
                <textarea id="notes" 
                          name="notes" 
                          rows="3"
                          class="w-full glass-input resize-y"
                          placeholder="Add any notes or special instructions">{{ old('notes', $purchaseOrder->notes) }}</textarea>
                @error('notes')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.purchase-orders.show', $purchaseOrder) }}" 
                   class="glass-button px-4 py-2">
                    Cancel
                </a>
                <button type="submit" 
                        class="glass-button btn-primary px-6 py-3">
                    Update Purchase Order
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let itemCount = {{ $purchaseOrder->items->count() }};

function addItem() {
    console.log('AddItem called');
    itemCount++;
    const container = document.getElementById('items-container');
    
    if (!container) {
        console.error('Container not found!');
        return;
    }
    
    const itemDiv = document.createElement('div');
    itemDiv.className = 'glass-card p-4';
    itemDiv.id = 'item-' + itemCount;
    
    itemDiv.innerHTML = 
        '<div class="flex justify-between items-center mb-3">' +
            '<span class="text-sm font-medium text-white">Item ' + itemCount + '</span>' +
            '<button type="button" onclick="removeItem(\'item-' + itemCount + '\')" class="p-2 text-red-400 hover:bg-red-400/10 rounded-lg transition-colors">' +
                '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />' +
                '</svg>' +
            '</button>' +
        '</div>' +
        '<div class="grid grid-cols-1 md:grid-cols-3 gap-4">' +
            '<div>' +
                '<label class="block text-xs text-gray-300 mb-1">Product *</label>' +
                '<select name="items[' + itemCount + '][product_id]" required onchange="updateItemTotal(' + itemCount + ')" class="w-full glass-select text-sm">' +
                    '<option value="">Select product</option>' +
                    '@foreach($products as $product)' +
                    '<option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>' +
                    '@endforeach' +
                '</select>' +
            '</div>' +
            '<div>' +
                '<label class="block text-xs text-gray-300 mb-1">Quantity *</label>' +
                '<input type="number" name="items[' + itemCount + '][quantity]" required min="1" value="1" onchange="updateItemTotal(' + itemCount + ')" class="w-full glass-input text-sm">' +
            '</div>' +
            '<div>' +
                '<label class="block text-xs text-gray-300 mb-1">Unit Price *</label>' +
                '<input type="number" name="items[' + itemCount + '][unit_price]" required min="0" step="0.01" onchange="updateItemTotal(' + itemCount + ')" class="w-full glass-input text-sm">' +
            '</div>' +
        '</div>' +
        '<div class="mt-2 text-right">' +
            '<span class="glass-badge">Total: $<span id="total-' + itemCount + '">0.00</span></span>' +
        '</div>';
    
    container.appendChild(itemDiv);
    updateOrderTotal();
}

function removeItem(itemId) {
    const element = document.getElementById(itemId);
    if (element) {
        element.remove();
        updateOrderTotal();
    }
}

function updateItemTotal(itemId) {
    const quantity = document.querySelector('input[name="items[' + itemId + '][quantity]"]')?.value || 0;
    const price = document.querySelector('input[name="items[' + itemId + '][unit_price]"]')?.value || 0;
    const total = (parseFloat(quantity) * parseFloat(price)).toFixed(2);
    const totalElement = document.getElementById('total-' + itemId);
    if (totalElement) {
        totalElement.textContent = total;
    }
    updateOrderTotal();
}

function updateOrderTotal() {
    const items = document.querySelectorAll('#items-container .glass-card');
    let orderTotal = 0;
    
    items.forEach((item) => {
        const quantityInput = item.querySelector('input[name*="[quantity]"]');
        const priceInput = item.querySelector('input[name*="[unit_price]"]');
        
        if (quantityInput && priceInput) {
            const quantity = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            orderTotal += quantity * price;
        }
    });
    
    const orderTotalElement = document.getElementById('order-total');
    if (orderTotalElement) {
        orderTotalElement.textContent = orderTotal.toFixed(2);
    }
}

// Make functions global
window.addItem = addItem;
window.removeItem = removeItem;
window.updateItemTotal = updateItemTotal;
window.updateOrderTotal = updateOrderTotal;

// Initialize totals on page load
setTimeout(function() {
    updateOrderTotal();
}, 100);
</script>
@endsection