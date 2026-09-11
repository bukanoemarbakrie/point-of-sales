<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Laporan Harian
     */
    public function daily(Request $request)
    {
        $title = 'Laporan Penjualan Harian';
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        $orders = Order::with('orderDetails.product')
            ->whereDate('created_at', $date)
            ->where('order_status', 'completed')
            ->orderBy('created_at', 'DESC')
            ->get();

        $summary = $this->getSummary($orders);

        return view('report.daily', compact('title', 'orders', 'summary', 'date'));
    }

    /**
     * Laporan Mingguan
     */
    public function weekly(Request $request)
    {
        $title = 'Laporan Penjualan Mingguan';
        $startDate = $request->input('start_date', Carbon::now()->startOfWeek()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfWeek()->format('Y-m-d'));

        $orders = Order::with('orderDetails.product')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('order_status', 'completed')
            ->orderBy('created_at', 'DESC')
            ->get();

        // Data per hari
        $dailyData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(order_amount) as total_sales')
        )
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('order_status', 'completed')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $summary = $this->getSummary($orders);

        return view('report.weekly', compact('title', 'orders', 'summary', 'startDate', 'endDate', 'dailyData'));
    }

    /**
     * Laporan Bulanan
     */
    public function monthly(Request $request)
    {
        $title = 'Laporan Penjualan Bulanan';
        $month = $request->input('month', Carbon::now()->format('m'));
        $year = $request->input('year', Carbon::now()->format('Y'));

        $orders = Order::with('orderDetails.product')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('order_status', 'completed')
            ->orderBy('created_at', 'DESC')
            ->get();

        // Data per hari dalam bulan
        $dailyData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(order_amount) as total_sales')
        )
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('order_status', 'completed')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Data produk terlaris
        $topProducts = OrderDetail::select(
            'product_id',
            DB::raw('SUM(order_qty) as total_qty'),
            DB::raw('SUM(order_subtotal) as total_sales')
        )
            ->whereHas('order', function ($q) use ($month, $year) {
                $q->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->where('order_status', 'completed');
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_qty', 'DESC')
            ->limit(10)
            ->get();

        $summary = $this->getSummary($orders);

        return view('report.monthly', compact('title', 'orders', 'summary', 'month', 'year', 'dailyData', 'topProducts'));
    }

    /**
     * Helper: Hitung summary
     */
    private function getSummary($orders)
    {
        return [
            'total_orders' => $orders->count(),
            'total_sales' => $orders->sum('order_amount'),
            'total_items' => $orders->sum(function ($order) {
                return $order->orderDetails->sum('order_qty');
            }),
            'average_sales' => $orders->count() > 0 ? $orders->sum('order_amount') / $orders->count() : 0,
        ];
    }
}
