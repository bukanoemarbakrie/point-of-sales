@extends('app')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title }}</h1>
        <p class="page-subtitle">Laporan penjualan harian</p>
    </div>
</div>

<!-- Filter Tanggal -->
<div class="card border-0 shadow-sm p-3 mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-bold">Pilih Tanggal</label>
            <input type="date" name="date" class="form-control" value="{{ $date }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Tampilkan
            </button>
        </div>
    </form>
</div>

<!-- Summary -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <small class="text-muted">Total Transaksi</small>
            <h4 class="fw-bold">{{ $summary['total_orders'] }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <small class="text-muted">Total Penjualan</small>
            <h4 class="fw-bold">Rp {{ number_format($summary['total_sales'], 0, ',', '.') }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <small class="text-muted">Total Item Terjual</small>
            <h4 class="fw-bold">{{ $summary['total_items'] }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <small class="text-muted">Rata-rata per Transaksi</small>
            <h4 class="fw-bold">Rp {{ number_format($summary['average_sales'], 0, ',', '.') }}</h4>
        </div>
    </div>
</div>

<!-- Tabel Transaksi -->
<div class="card border-0 shadow-sm p-3">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Order Code</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $order->order_code }}</strong></td>
                    <td>{{ $order->customer_name }}</td>
                    <td>
                        @foreach($order->orderDetails as $detail)
                        <small>{{ $detail->product?->product_name }} (x{{ $detail->order_qty }})</small><br>
                        @endforeach
                    </td>
                    <td>Rp {{ number_format($order->order_amount, 0, ',', '.') }}</td>
                    <td>{{ $order->created_at->format('H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Tidak ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
