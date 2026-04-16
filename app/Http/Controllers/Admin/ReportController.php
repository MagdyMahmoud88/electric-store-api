<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        // إجمالي المبيعات
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalOrders  = Order::count();
        $totalUsers   = User::count();

        // مبيعات آخر 7 أيام
        $weeklySales = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, SUM(total) as total, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // أكثر المنتجات مبيعاً
        $topProducts = OrderItem::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_sold, SUM(price * quantity) as revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // توزيع حالات الطلبات
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.reports.index', compact(
            'totalRevenue', 'totalOrders', 'totalUsers',
            'weeklySales', 'topProducts', 'ordersByStatus'
        ));
    }
}
