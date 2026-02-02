<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $movements = StockMovement::with(['product.category', 'user'])
            ->when($request->product_id, function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->date_from, function ($query, $dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($request->date_to, function ($query, $dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->latest()
            ->paginate(20);

        $products = Product::active()->pluck('name', 'id');
        $types = ['in' => 'Stock In', 'out' => 'Stock Out', 'adjustment' => 'Adjustment'];

        return view('admin.stock-movements.index', compact('movements', 'products', 'types'));
    }

    public function create()
    {
        $products = Product::active()->get();
        $types = ['in' => 'Stock In', 'out' => 'Stock Out', 'adjustment' => 'Adjustment'];

        return view('admin.stock-movements.create', compact('products', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        StockMovement::createMovement(
            $validated['product_id'],
            $validated['type'],
            $validated['quantity'],
            $validated['reference'],
            $validated['notes']
        );

        return redirect()->route('admin.stock-movements.index')
            ->with('success', 'Stock movement created successfully.');
    }

    public function show(StockMovement $stockMovement)
    {
        $stockMovement->load(['product.category', 'user']);

        return view('admin.stock-movements.show', compact('stockMovement'));
    }
}
