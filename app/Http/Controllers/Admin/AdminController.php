<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Brand;
class AdminController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
$totalOrders   = Order::count();
$pendingOrders = Order::where('status', 'pending')->count();
$recentOrders  = Order::with(['user', 'orderItems'])
                       ->latest()->limit(5)->get();
        $products = Product::with('category')
            ->when($request->search, fn($q) =>
                $q->where('name', 'like', '%' . $request->search . '%')
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $outOfStock      = Product::where('stock', 0)->count();
        $lowStock        = Product::where('stock', '>', 0)
                                  ->where('stock', '<=', 10)
                                  ->count();
$totalBrands = Brand::count();

        return view('admin.dashboard', compact(
            'products',
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'pendingOrders',
            'recentOrders',
            'outOfStock',
            'categories',
            'lowStock',
            'totalBrands'
        ));
    }

    public function create()
    {
        // ✅ الصح — ترجع صفحة الإضافة مع الكاتيجوري
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }
}
