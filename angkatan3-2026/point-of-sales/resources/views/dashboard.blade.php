@extends('app')
@section('content')

<!-- START: Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">
            Selamat datang, <strong>{{ $user->name ?? 'User' }}</strong>
            ({{ $user->role->name ?? 'No Role' }})
        </p>
    </div>
</div>
<!-- END: Page Header -->

@if($user->isAdmin() || $user->isLeader())

{{-- ROW 1: Statistik --}}
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm p-3 h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-cash-stack text-success fs-3"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Penjualan Hari Ini</small>
                    <h5 class="fw-bold mb-0">Rp {{ number_format($todaySales ?? 0, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm p-3 h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-cart-check text-primary fs-3"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Transaksi Hari Ini</small>
                    <h5 class="fw-bold mb-0">{{ $todayOrders ?? 0 }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm p-3 h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-calendar-week text-warning fs-3"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Penjualan Minggu Ini</small>
                    <h5 class="fw-bold mb-0">Rp {{ number_format($weekSales ?? 0, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm p-3 h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-info bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-calendar-month text-info fs-3"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Penjualan Bulan Ini</small>
                    <h5 class="fw-bold mb-0">Rp {{ number_format($monthSales ?? 0, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ROW 2: Chart & Stok Rendah --}}
<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-3 h-100">
            <h5 class="fw-bold mb-3">Penjualan 7 Hari Terakhir</h5>
            <canvas id="salesChart"
                height="100"
                data-labels="{{ ($salesChart ?? collect())->pluck('date')->toJson() }}"
                data-values="{{ ($salesChart ?? collect())->pluck('total')->toJson() }}">
            </canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100">
            <h5 class="fw-bold mb-3">⚠️ Stok Rendah</h5>
            @forelse($lowStockProducts ?? [] as $product)
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <span>{{ $product->product_name }}</span>
                <span class="badge bg-danger">{{ $product->qty }}</span>
            </div>
            @empty
            <p class="text-muted">Semua produk stoknya aman</p>
            @endforelse
        </div>
    </div>
</div>

{{-- ROW 3: Transaksi Terbaru --}}
<div class="card border-0 shadow-sm p-3">
    <h5 class="fw-bold mb-3">Transaksi Terbaru</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order Code</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders ?? [] as $order)
                <tr>
                    <td><strong>{{ $order->order_code }}</strong></td>
                    <td>{{ $order->customer_name }}</td>
                    <td>Rp {{ number_format($order->order_amount, 0, ',', '.') }}</td>
                    <td>{{ $order->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endif
{{-- END: Administrator & Pimpinan --}}

@if($user->isCashier())

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-4 h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-cash-stack text-success fs-2"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Penjualan Saya Hari Ini</small>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($myTodaySales ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-4 h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-cart-check text-primary fs-2"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Transaksi Saya Hari Ini</small>
                    <h3 class="fw-bold mb-0">{{ $myTodayOrders ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm p-5 text-center">
    <h5 class="fw-bold mb-3">Mulai Transaksi</h5>
    <p class="text-muted mb-4">Klik tombol di bawah untuk memulai transaksi penjualan</p>
    <div class="d-flex justify-content-center gap-2 flex-wrap">
        <a href="{{ route('order.create') }}" class="btn btn-primary btn-lg px-4">
            <i class="bi bi-cart-plus"></i> Transaksi Baru
        </a>
        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary btn-lg px-4">
            <i class="bi bi-box-seam"></i> Lihat Stok
        </a>
    </div>
</div>

@endif
{{-- END: Kasir --}}

{{-- Chart.js --}}
@if($user->isAdmin() || $user->isLeader())
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/assets/js/dashboard-chart.js') }}"></script>
@endif

@endsection
