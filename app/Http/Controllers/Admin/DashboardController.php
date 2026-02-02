<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_suppliers' => Supplier::count(),
            'low_stock_products' => Product::lowStock()->count(),
            'pending_orders' => PurchaseOrder::where('status', 'pending')->count(),
        ];

        $lowStockProducts = Product::lowStock()
            ->with('category')
            ->limit(5)
            ->get();

        $recentMovements = StockMovement::with(['product', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        $monthlyPurchases = PurchaseOrder::selectRaw("strftime('%m', order_date) as month, SUM(total_amount) as total")
            ->whereRaw("strftime('%Y', order_date) = ?", [now()->year])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact('stats', 'lowStockProducts', 'recentMovements', 'monthlyPurchases'));
    }
}
