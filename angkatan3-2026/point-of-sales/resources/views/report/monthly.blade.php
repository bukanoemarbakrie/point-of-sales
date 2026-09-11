@extends('app')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title }}</h1>
        <p class="page-subtitle">Laporan penjualan bulanan</p>
    </div>
</div>

<div class="card border-0 shadow-sm p-3 mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-bold">Bulan</label>
            <select name="month" class="form-select">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                    @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold">Tahun</label>
            <select name="year" class="form-select">
                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Tampilkan
            </button>
        </div>
    </form>
</div>

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
            <small class="text-muted">Total Item</small>
            <h4 class="fw-bold">{{ $summary['total_items'] }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <small class="text-muted">Rata-rata</small>
            <h4 class="fw-bold">Rp {{ number_format($summary['average_sales'], 0, ',', '.') }}</h4>
        </div>
    </div>
</div>

<!-- Produk Terlaris -->
<div class="card border-0 shadow-sm p-3 mb-4">
    <h5 class="fw-bold mb-3">🏆 Top 10 Produk Terlaris</h5>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Produk</th>
                    <th>Total Terjual</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topProducts as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product?->product_name ?? '-' }}</td>
                    <td>{{ $item->total_qty }}</td>
                    <td>Rp {{ number_format($item->total_sales, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Data Harian -->
<div class="card border-0 shadow-sm p-3">
    <h5 class="fw-bold mb-3">Data Harian</h5>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Total Transaksi</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dailyData as $data)
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
@endsection
