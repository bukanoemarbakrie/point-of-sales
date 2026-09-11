@extends('app')
@section('content')

<!-- START: Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Detail Transaksi</h1>
        <p class="page-subtitle">Order Code: <strong>{{ $order->order_code }}</strong></p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}" class="text-decoration-none text-muted-green">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('order.index') }}" class="text-decoration-none text-muted-green">Transaction</a>
            </li>
            <li class="breadcrumb-item active text-main" aria-current="page">Detail</li>
        </ol>
    </nav>
</div>
<!-- END: Page Header -->

<div class="row g-4">
    <!-- Kolom Kiri: Info Order -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Informasi Transaksi</h5>
                @if($order->order_status === 'completed')
                <span class="badge bg-success fs-6">
                    <i class="bi bi-check-circle"></i> Completed
                </span>
                @elseif($order->order_status === 'pending')
                <span class="badge bg-warning text-dark fs-6">
                    <i class="bi bi-clock"></i> Pending
                </span>
                @else
                <span class="badge bg-danger fs-6">
                    <i class="bi bi-x-circle"></i> Cancelled
                </span>
                @endif
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <small class="text-muted d-block">Order Code</small>
                    <strong>{{ $order->order_code }}</strong>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Tanggal</small>
                    <strong>{{ $order->created_at->format('d M Y, H:i') }} WIB</strong>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Customer</small>
                    <strong>{{ $order->customer_name ?? 'Guest' }}</strong>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Metode Pembayaran</small>
                    <span class="badge bg-info text-dark">
                        {{ strtoupper($order->payment_method ?? 'cash') }}
                    </span>
                </div>
            </div>

            <hr>

            <h6 class="fw-bold mb-3">Daftar Produk</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Produk</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->orderDetails as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $detail->product?->product_name ?? 'Produk Tidak Ditemukan' }}</strong>
                                @if($detail->product?->product_description)
                                <br>
                                <small class="text-muted">{{ $detail->product->product_description }}</small>
                                @endif
                            </td>
                            <td class="text-end">Rp {{ number_format($detail->order_price, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $detail->order_qty }}</span>
                            </td>
                            <td class="text-end fw-bold">Rp {{ number_format($detail->order_subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                Tidak ada produk
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Ringkasan Pembayaran -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-3">Ringkasan Pembayaran</h5>

            @php
            $subtotal = 0;
            foreach($order->orderDetails as $detail) {
            $subtotal += $detail->order_subtotal;
            }
            $tax = $subtotal * 0.10;
            @endphp

            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Sub Total</span>
                <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Pajak (10%)</span>
                <strong>Rp {{ number_format($tax, 0, ',', '.') }}</strong>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <span class="fw-bold fs-5">Total</span>
                <span class="fw-bold fs-5 text-success">
                    Rp {{ number_format($order->order_amount, 0, ',', '.') }}
                </span>
            </div>

            @if($order->order_change > 0)
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Kembalian</span>
                <strong class="text-primary">
                    Rp {{ number_format($order->order_change, 0, ',', '.') }}
                </strong>
            </div>
            @endif
        </div>

        <!-- Tombol Aksi -->
        <div class="card border-0 shadow-sm p-4 mt-3">
            <h6 class="fw-bold mb-3">Aksi</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('order.print', $order->id) }}"
                    target="_blank"
                    class="btn btn-primary">
                    <i class="bi bi-printer"></i> Cetak Struk
                </a>
                <a href="{{ route('order.index') }}"
                    class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <form action="{{ route('order.destroy', $order->id) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash"></i> Hapus Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('app')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Detail Produk</h1>
    </div>
</div>

<div class="card border-0 shadow-sm p-4">
    <div class="row">
        <div class="col-md-4">
            @if($product->product_photo)
            <img src="{{ asset('storage/' . $product->product_photo) }}"
                class="img-fluid rounded"
                style="max-height: 300px; object-fit: cover;">
            @else
            <div class="bg-light d-flex align-items-center justify-content-center rounded"
                style="height: 300px;">
                <i class="bi bi-box-seam text-secondary" style="font-size: 5rem;"></i>
            </div>
            @endif
        </div>
        <div class="col-md-8">
            <h3>{{ $product->product_name }}</h3>
            <span class="badge bg-info">{{ $product->category->category_name ?? '-' }}</span>

            <hr>

            <p>{{ $product->product_description ?? 'Tidak ada deskripsi' }}</p>

            <div class="row mt-4">
                <div class="col-md-6">
                    <small class="text-muted">Harga</small>
                    <h4 class="text-success">Rp {{ number_format($product->product_price, 0, ',', '.') }}</h4>
                </div>
                <div class="col-md-6">
                    <small class="text-muted">Stok</small>
                    <h4>{{ $product->qty }} pcs</h4>
                </div>
            </div>

            <a href="{{ route('product.index') }}" class="btn btn-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
