@extends('app')
@section('content')

<!-- START: Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Data Product' }}</h1>
        <p class="page-subtitle">
            @if(Auth::user()->isAdmin())
            Kelola data produk
            @else
            Lihat stok produk
            @endif
        </p>
    </div>
</div>
<!-- END: Page Header -->

<div class="card border-light shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">List Products</h5>

        {{-- Tombol Add HANYA untuk Administrator --}}
        @if(Auth::user()->isAdmin())
        <a href="{{ route('product.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Product
        </a>
        @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">#</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Status</th>

                    {{-- Kolom Action HANYA untuk Administrator --}}
                    @if(Auth::user()->isAdmin())
                    <th width="15%">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($product->product_photo)
                            <img src="{{ asset('storage/' . $product->product_photo) }}"
                                width="50" height="50"
                                style="object-fit: cover; border-radius: 8px;">
                            @else
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px; border-radius: 8px;">
                                <i class="bi bi-box-seam text-secondary"></i>
                            </div>
                            @endif
                            <div>
                                <strong>{{ $product->product_name }}</strong>
                                @if($product->product_description)
                                <br>
                                <small class="text-muted">{{ Str::limit($product->product_description, 40) }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $product->category->category_name ?? '-' }}
                        </span>
                    </td>
                    <td class="fw-bold text-success">
                        Rp {{ number_format($product->product_price, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($product->qty > 10)
                        <span class="badge bg-success">{{ $product->qty }}</span>
                        @elseif($product->qty > 0)
                        <span class="badge bg-warning text-dark">{{ $product->qty }}</span>
                        @else
                        <span class="badge bg-danger">Habis</span>
                        @endif
                    </td>
                    <td>
                        @if($product->is_active == 1)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-danger">In-Active</span>
                        @endif
                    </td>

                    {{-- Tombol Edit & Delete HANYA untuk Administrator --}}
                    @if(Auth::user()->isAdmin())
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('product.edit', $product->id) }}"
                                class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('product.destroy', $product->id) }}"
                                method="post"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::user()->isAdmin() ? 7 : 6 }}" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox display-4 d-block mb-2"></i>
                        Tidak ada produk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3 text-muted">
        <small>Total: {{ $products->count() }} produk</small>
    </div>
</div>

@endsection
