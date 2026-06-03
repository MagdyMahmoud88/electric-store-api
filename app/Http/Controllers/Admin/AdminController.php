<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $totalOrders = Order::whereNotIn('status', ['pending', 'payment_failed'])->count();
        $totalUsers    = User::count();
        $newUsersToday = User::whereDate('created_at', today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalCoupons = Coupon::count();
        $pendingReviews = Review::where('is_approved', false)->count();
        // ── الإيرادات ──────────────────────────────────────────────
        $revenueToday = Order::where('payment_status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total');

        $revenueThisMonth = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $revenueTotal = Order::where('payment_status', 'paid')
            ->sum('total');

        $recentOrders = Order::with(['user', 'items'])
            ->latest()->limit(5)->get();
        $products = Product::with(['category', 'brand'])
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%')
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $outOfStock = Product::where('stock', 0)->count();
        $lowStock = Product::where('stock', '>', 0)
            ->where('stock', '<=', 10)
            ->count();
        $totalBrands = Brand::count();

        $lowStockProducts = Product::with(['category', 'brand'])
        -> where('stock', '>', 0)
            ->where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'products',
            'totalProducts',
            'totalCategories',
            'totalCoupons',
            'pendingReviews',
            'totalOrders',
            'pendingOrders',
            'recentOrders',
            'outOfStock',
            'categories',
            'lowStock',
            'totalBrands',
            'lowStockProducts',
            'newUsersToday',
            'totalUsers',
            'revenueToday',
            'revenueThisMonth',
            'revenueTotal',
        ));
    }
    public function notificationsCount()
    {
        return response()->json([
            'count' => auth()->user()->unreadNotifications()->count()
        ]);
    }

    public function fetchNotifications()
    {
        $notifications = auth()->user()->unreadNotifications()->latest()->take(10)->get();

        return response()->json([
            'count'         => $notifications->count(),
            'notifications' => $notifications->map(fn($n) => [
                'id'      => $n->id,
                'message' => $n->data['message'],
                'time'    => $n->created_at->diffForHumans(),
            ])
        ]);
    }

    public function markAsRead($id)
    {
        auth()->user()->notifications()->findOrFail($id)->markAsRead();
        return back();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}


