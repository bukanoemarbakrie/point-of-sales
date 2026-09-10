@extends('app')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Data Product' }}</h1>
        <p class="page-subtitle">Manage your product inventory</p>
    </div>
</div>

<div class="card border-light shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">List Products</h5>
        <a href="{{ route('product.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Product
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                    <th>Status</th>
                    <th width="15%">Action</th>
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
                                width="50" height="50" style="object-fit: cover; border-radius: 8px;">
                            @else
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px; border-radius: 8px;">
                                <i class="bi bi-box-seam text-secondary"></i>
                            </div>
                            @endif
                            <strong>{{ $product->product_name }}</strong>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $product->category->category_name ?? '-' }}</span>
                    </td>
                    <td class="fw-bold text-success">
                        Rp {{ number_format($product->product_price, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($product->qty > 0)
                        <span class="badge bg-primary">{{ $product->qty }}</span>
                        @else
                        <span class="badge bg-danger">0</span>
                        @endif
                    </td>
                    <td>
                        @if($product->is_active == 1)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-danger">In-Active</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('product.destroy', $product->id) }}" method="post"
                                onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
