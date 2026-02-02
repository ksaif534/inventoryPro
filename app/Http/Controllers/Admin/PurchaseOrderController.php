<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $orders = PurchaseOrder::with(['supplier', 'items.product'])
            ->latest()
            ->paginate(15);

        $stats = [
            'pending' => PurchaseOrder::where('status', 'pending')->count(),
            'approved' => PurchaseOrder::where('status', 'approved')->count(),
            'received' => PurchaseOrder::where('status', 'received')->count(),
        ];

        return view('admin.purchase-orders.index', compact('orders', 'stats'));
    }

    public function create()
    {
        $suppliers = Supplier::active()->pluck('name', 'id');
        $products = Product::active()->get();

        return view('admin.purchase-orders.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'expected_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string',
        ]);

        $order = PurchaseOrder::create([
            'supplier_id' => $validated['supplier_id'],
            'total_amount' => collect($validated['items'])->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            }),
            'expected_date' => $validated['expected_date'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            \App\Models\PurchaseOrderItem::create([
                'purchase_order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);
        }

        return redirect()->route('admin.purchase-orders.show', $order)
            ->with('success', 'Purchase order created successfully.');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'items.product.category']);

        return view('admin.purchase-orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('error', 'Cannot edit purchase order that is not pending.');
        }

        $purchaseOrder->load(['supplier', 'items.product']);
        $suppliers = Supplier::active()->pluck('name', 'id');
        $products = Product::active()->get();

        return view('admin.purchase-orders.edit', compact('purchaseOrder', 'suppliers', 'products'));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('error', 'Cannot update purchase order that is not pending.');
        }

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'expected_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string',
        ]);

        $purchaseOrder->items()->delete();

        foreach ($validated['items'] as $item) {
            \App\Models\PurchaseOrderItem::create([
                'purchase_order_id' => $purchaseOrder->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);
        }

        $purchaseOrder->update([
            'supplier_id' => $validated['supplier_id'],
            'total_amount' => collect($validated['items'])->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            }),
            'expected_date' => $validated['expected_date'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
            ->with('success', 'Purchase order updated successfully.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('error', 'Cannot delete purchase order that is not pending.');
        }

        $purchaseOrder->delete();

        return redirect()->route('admin.purchase-orders.index')
            ->with('success', 'Purchase order deleted successfully.');
    }

    public function approve(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('error', 'Cannot approve purchase order that is not pending.');
        }

        $purchaseOrder->update(['status' => 'approved']);

        return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
            ->with('success', 'Purchase order approved successfully.');
    }

    public function receive(PurchaseOrder $purchaseOrder, Request $request)
    {
        if ($purchaseOrder->status !== 'approved') {
            return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('error', 'Cannot receive purchase order that is not approved.');
        }

        $validated = $request->validate([
            'received_items' => 'required|array',
            'received_items.*.item_id' => 'required|exists:purchase_order_items,id',
            'received_items.*.received_quantity' => 'required|integer|min:0',
        ]);

        foreach ($validated['received_items'] as $received) {
            $item = PurchaseOrderItem::find($received['item_id']);
            
            if ($received['received_quantity'] > 0) {
                StockMovement::createMovement(
                    $item->product_id,
                    'in',
                    $received['received_quantity'],
                    $purchaseOrder->order_number,
                    "Received from purchase order"
                );
            }
        }

        $purchaseOrder->update(['status' => 'received']);

        return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
            ->with('success', 'Purchase order received successfully.');
    }
}
