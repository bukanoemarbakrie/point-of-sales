@extends('app')
@section('content')

<!-- START: Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Laporan Penjualan Mingguan' }}</h1>
        <p class="page-subtitle">Laporan penjualan per minggu</p>
    </div>
</div>
<!-- END: Page Header -->

<!-- Filter Tanggal -->
<div class="card border-0 shadow-sm p-3 mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-bold">Dari Tanggal</label>
            <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold">Sampai Tanggal</label>
            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Tampilkan
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('report.weekly') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
        </div>
    </form>
</div>

<!-- Summary -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <small class="text-muted d-block">Total Transaksi</small>
            <h4 class="fw-bold mb-0">{{ $summary['total_orders'] ?? 0 }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <small class="text-muted d-block">Total Penjualan</small>
            <h4 class="fw-bold mb-0">Rp {{ number_format($summary['total_sales'] ?? 0, 0, ',', '.') }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <small class="text-muted d-block">Total Item</small>
            <h4 class="fw-bold mb-0">{{ $summary['total_items'] ?? 0 }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <small class="text-muted d-block">Rata-rata</small>
            <h4 class="fw-bold mb-0">Rp {{ number_format($summary['average_sales'] ?? 0, 0, ',', '.') }}</h4>
        </div>
    </div>
</div>

<!-- Data Harian -->
<div class="card border-0 shadow-sm p-3 mb-4">
    <h5 class="fw-bold mb-3">Data Harian</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Total Transaksi</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dailyData ?? [] as $data)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($data->date)->format('d M Y') }}</td>
                    <td>{{ $data->total_orders }}</td>
                    <td>Rp {{ number_format($data->total_sales, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-muted">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Detail Transaksi -->
<div class="card border-0 shadow-sm p-3">
    <h5 class="fw-bold mb-3">Detail Transaksi</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
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
                @forelse($orders ?? [] as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $order->order_code }}</strong></td>
                    <td>{{ $order->customer_name }}</td>
                    <td>
                        @foreach($order->orderDetails as $detail)
                        <small class="d-block">
                            {{ $detail->product?->product_name ?? 'Produk Tidak Ditemukan' }}
                            (x{{ $detail->order_qty }})
                        </small>
                        @endforeach
                    </td>
                    <td>Rp {{ number_format($order->order_amount, 0, ',', '.') }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
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
