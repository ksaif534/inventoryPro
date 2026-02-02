<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function stock()
    {
        $categories = Category::withCount('products')->get();
        $products = Product::with('category')->get();
        
        $totalValue = $products->sum(function ($product) {
            return $product->quantity * $product->cost_price;
        });

        $totalProducts = $products->count();
        $activeProducts = $products->where('is_active', true)->count();
        $lowStockProducts = $products->filter(fn($product) => $product->isLowStock())->count();

        $categoryStats = $categories->map(function ($category) use ($products) {
            $categoryProducts = $products->where('category_id', $category->id);
            return [
                'name' => $category->name,
                'product_count' => $categoryProducts->count(),
                'total_quantity' => $categoryProducts->sum('quantity'),
                'total_value' => $categoryProducts->sum(function ($product) {
                    return $product->quantity * $product->cost_price;
                }),
            ];
        });

        return view('admin.reports.stock', compact(
            'totalValue', 
            'totalProducts', 
            'activeProducts', 
            'lowStockProducts',
            'categoryStats',
            'products'
        ));
    }

    public function lowStock()
    {
        $lowStockProducts = Product::lowStock()
            ->with(['category', 'supplier'])
            ->orderBy('quantity')
            ->get();

        $criticalStock = $lowStockProducts->filter(fn($product) => $product->quantity === 0);
        $warningStock = $lowStockProducts->filter(fn($product) => $product->quantity > 0 && $product->quantity <= $product->low_stock_threshold);

        return view('admin.reports.low-stock', compact(
            'lowStockProducts',
            'criticalStock',
            'warningStock'
        ));
    }

    public function purchases()
    {
        $monthlyOrders = PurchaseOrder::selectRaw('
                strftime("%Y", order_date) as year,
                strftime("%m", order_date) as month,
                COUNT(*) as order_count,
                SUM(total_amount) as total_amount
            ')
            ->whereRaw("strftime('%Y', order_date) >= ?", [now()->subYear()->year])
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $recentOrders = PurchaseOrder::with(['supplier'])
            ->latest()
            ->limit(10)
            ->get();

        $supplierStats = PurchaseOrder::with('supplier')
            ->selectRaw('supplier_id, COUNT(*) as order_count, SUM(total_amount) as total_spent')
            ->where('status', '!=', 'cancelled')
            ->groupBy('supplier_id')
            ->orderBy('total_spent', 'desc')
            ->get();

        return view('admin.reports.purchases', compact(
            'monthlyOrders',
            'recentOrders',
            'supplierStats'
        ));
    }
}
