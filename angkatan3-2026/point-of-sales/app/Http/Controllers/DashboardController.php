<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ============================================
        // DATA UMUM (semua role)
        // ============================================
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $lowStockProducts = Product::where('qty', '<', 10)->where('is_active', 1)->get();

        // ============================================
        // DATA PENJUALAN (Administrator & Pimpinan)
        // ============================================
        $todaySales = 0;
        $todayOrders = 0;
        $weekSales = 0;
        $monthSales = 0;
        $recentOrders = collect();
        $salesChart = collect();

        if ($user && ($user->isAdmin() || $user->isLeader())) {
            // Penjualan hari ini
            $todaySales = Order::whereDate('created_at', Carbon::today())
                ->where('order_status', 'completed')
                ->sum('order_amount');

            $todayOrders = Order::whereDate('created_at', Carbon::today())
                ->where('order_status', 'completed')
                ->count();

            // Penjualan minggu ini
            $weekSales = Order::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
                ->where('order_status', 'completed')
                ->sum('order_amount');

            // Penjualan bulan ini
            $monthSales = Order::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->where('order_status', 'completed')
                ->sum('order_amount');

            // 5 order terakhir
            $recentOrders = Order::with('orderDetails.product')
                ->where('order_status', 'completed')
                ->latest()
                ->limit(5)
                ->get();

            // Data chart 7 hari terakhir
            $salesChart = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(order_amount) as total')
            )
                ->whereBetween('created_at', [
                    Carbon::now()->subDays(6)->startOfDay(),
                    Carbon::now()->endOfDay()
                ])
                ->where('order_status', 'completed')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        // ============================================
        // DATA KASIR
        // ============================================
        $myTodayOrders = 0;
        $myTodaySales = 0;

        if ($user && $user->isCashier()) {
            $myTodayOrders = Order::whereDate('created_at', Carbon::today())
                ->where('order_status', 'completed')
                ->count();

            $myTodaySales = Order::whereDate('created_at', Carbon::today())
                ->where('order_status', 'completed')
                ->sum('order_amount');
        }

        return view('dashboard', compact(
            'title',
            'user',
            'totalProducts',
            'totalCategories',
            'lowStockProducts',
            'todaySales',
            'todayOrders',
            'weekSales',
            'monthSales',
            'recentOrders',
            'salesChart',
            'myTodayOrders',
            'myTodaySales'
        ));
    }
}
