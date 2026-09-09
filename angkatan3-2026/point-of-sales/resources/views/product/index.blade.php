@extends('app')
@section('content')
<!-- START: Page Header Banner -->
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Data Product' }}</h1>
        <p class="page-subtitle">Manage your product inventory</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none text-muted-green">Home</a></li>
            <li class="breadcrumb-item active text-main" aria-current="page">Product</li>
        </ol>
    </nav>
</div>
<!-- END: Page Header Banner -->

<div class="card border-light shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">List Products</h5>
        <a href="{{ route('product.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Product
        </a>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th width="5%">#</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Description</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($product->photo)
                            <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}"
                                width="50" height="50" style="object-fit: cover; border-radius: 8px;">
                            @else
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px; border-radius: 8px;">
                                <i class="bi bi-box-seam text-secondary" style="font-size: 24px;"></i>
                            </div>
                            @endif
                            <div>
                                <strong>{{ $product->name }}</strong>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            <i class="bi bi-tag"></i> {{ $product->category->name ?? 'No Category' }}
                        </span>
                    </td>
                    <td class="fw-bold text-success">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($product->qty > 0)
                        <span class="badge bg-primary">{{ $product->qty }}</span>
                        @else
                        <span class="badge bg-danger">0 (Out of Stock)</span>
                        @endif
                    </td>
                    <td>{{ Str::limit($product->description, 50) }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('product.destroy', $product->id) }}" method="post" class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox display-4 d-block mb-2"></i>
                        No products found. Click "Add Product" to create one.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Total products -->
    <div class="mt-3 text-muted">
        <small>Total: {{ $products->count() }} products</small>
    </div>
</div>
@endsection
