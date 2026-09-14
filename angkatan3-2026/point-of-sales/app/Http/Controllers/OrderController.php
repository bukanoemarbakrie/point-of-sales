<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index()
    {
        $title = "Transaction Order";
        $orders = Order::with('orderDetails.product')->latest()->get();
        return view('order.index', compact('title', 'orders'));
    }

    public function create()
    {
        $title = "Point of Sales";

        // Filter data
        $categories = Category::where('is_active', 1)->get();
        $products = Product::with('category')
            ->where('is_active', 1)
            ->where('qty', '>', 0)
            ->orderBy('id')
            ->get();

        // STATISTIK HARI INI (REAL DATA)
        $today = \Carbon\Carbon::today();

        $todayTransactions = Order::whereDate('created_at', $today)
            ->where('order_status', 'completed')
            ->count();

        $todaySales = Order::whereDate('created_at', $today)
            ->where('order_status', 'completed')
            ->sum('order_amount');

        $productSold = OrderDetail::whereHas('order', function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->where('order_status', 'completed');
        })
            ->sum('order_qty');

        return view('order.create', compact(
            'title',
            'categories',
            'products',
            'todayTransactions',
            'todaySales',
            'productSold'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'payment_method' => 'nullable|string|in:cash,midtrans',
            'customer_name' => 'nullable|string',
            'order_change' => 'nullable|numeric',
        ]);

        $paymentMethod = $request->payment_method ?? 'cash';
        $items = is_array($request->items) ? array_values($request->items) : [];

        try {
            $order = DB::transaction(function () use ($items, $request, $paymentMethod) {
                $subtotal = 0;
                $itemsData = [];

                foreach ($items as $item) {
                    $productId = $item['id'] ?? null;
                    $qty = $item['qty'] ?? 1;

                    if (!$productId) continue;

                    $product = Product::findOrFail($productId);

                    if ($product->qty < $qty) {
                        throw new Exception('Stok produk "' . $product->product_name . '" tidak cukup');
                    }

                    $itemSubtotal = $product->product_price * $qty;
                    $subtotal += $itemSubtotal;

                    $itemsData[] = [
                        'product_id' => $product->id,
                        'order_qty' => $qty,
                        'order_price' => $product->product_price,
                        'order_subtotal' => $itemSubtotal,
                    ];
                }

                $tax = $subtotal * 0.10;
                $totalAmount = $subtotal + $tax;

                $order = Order::create([
                    'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                    'customer_name' => $request->customer_name ?? 'Guest',
                    'payment_method' => $paymentMethod,
                    'order_amount' => $totalAmount,
                    'order_change' => $request->order_change ?? 0,
                    'order_status' => $paymentMethod === 'cash' ? 'completed' : 'pending',
                ]);

                foreach ($itemsData as $data) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $data['product_id'],
                        'order_qty' => $data['order_qty'],
                        'order_price' => $data['order_price'],
                        'order_subtotal' => $data['order_subtotal'],
                    ]);

                    Product::where('id', $data['product_id'])
                        ->decrement('qty', $data['order_qty']);
                }

                return $order;
            });

            $snapToken = null;

            // ============================================
            // MIDTRANS SNAP TOKEN
            // ============================================
            if ($paymentMethod === 'midtrans') {
                Config::$serverKey    = config('services.midtrans.server_key');
                Config::$isProduction = config('services.midtrans.is_production', false);
                Config::$isSanitized  = config('services.midtrans.is_sanitized', true);
                Config::$is3ds        = config('services.midtrans.is_3ds', true);

                $params = [
                    'transaction_details' => [
                        'order_id'     => $order->order_code,
                        'gross_amount' => (int) round($order->order_amount),
                    ],
                    'customer_details' => [
                        'first_name' => $request->customer_name ?? 'Customer',
                    ],
                    'enabled_payments' => ['gopay', 'qris', 'shopeepay', 'bank_transfer'],
                ];

                try {
                    $snapToken = Snap::getSnapToken($params);
                } catch (\Exception $e) {
                    Log::error('Midtrans Error: ' . $e->getMessage());   // ← Tanpa backslash
                    throw new Exception('Gagal mendapatkan Snap Token: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'payment_method' => $paymentMethod,
                'snap_token' => $snapToken,
                'order_id' => $order->id,
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => 'Gagal Menyimpan Transaksi: ' . $th->getMessage(),
            ], 500);
        }
    }

    public function printReceipt(string $id)
    {
        $order = Order::with('orderDetails.product')->findOrFail($id);
        return view('order.print', compact('order'));
    }

    public function show(string $id)
    {
        $title = "Order Detail";
        $order = Order::with('orderDetails.product')->findOrFail($id);
        return view('order.show', compact('title', 'order'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->to('order')->with('success', 'Order deleted successfully');
    }

    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $order = Order::where('order_code', $request->order_id)->first();

            if ($order) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $order->update(['order_status' => 'completed']);
                } elseif ($request->transaction_status == 'pending') {
                    $order->update(['order_status' => 'pending']);
                } elseif (in_array($request->transaction_status, ['deny', 'expire', 'cancel'])) {
                    $order->update(['order_status' => 'cancelled']);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
