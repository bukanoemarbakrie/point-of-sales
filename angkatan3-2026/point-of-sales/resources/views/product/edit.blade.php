@extends('app')
@section('content')
<!-- START: Page Header Banner -->
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Edit Product' }}</h1>
        <p class="page-subtitle">Update product information</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none text-muted-green">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}" class="text-decoration-none text-muted-green">Product</a></li>
            <li class="breadcrumb-item active text-main" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>
<!-- END: Page Header Banner -->

<div class="card border-light shadow-sm p-4">
    <h5 class="card-title mb-4">Edit Product: <span class="text-primary">{{ $product->product_name }}</span></h5>

    <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Category Selection -->
        <div class="mb-3">
            <label for="category_id" class="form-label fw-bold">Category <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Product Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
            <input type="text"
                name="product_name"
                id="product_name"
                class="form-control @error('product_name') is-invalid @enderror"
                placeholder="Enter product name"
                value="{{ old('product_name', $product->product_name) }}"
                required>
            @error('product_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label fw-bold">Price <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number"
                    name="product_price"
                    id="product_price"
                    class="form-control @error('product_price') is-invalid @enderror"
                    placeholder="0"
                    value="{{ old('product_price', $product->product_price) }}"
                    step="1000"
                    min="0"
                    required>
            </div>
            @error('product_price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Quantity -->
        <div class="mb-3">
            <label for="qty" class="form-label fw-bold">Quantity <span class="text-danger">*</span></label>
            <input type="number"
                name="qty"
                id="qty"
                class="form-control @error('qty') is-invalid @enderror"
                placeholder="Enter stock quantity"
                value="{{ old('qty', $product->qty) }}"
                min="0"
                required>
            @error('qty')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Current Photo -->
        @if($product->product_photo)
        <div class="mb-3">
            <label class="form-label fw-bold">Current Photo</label>
            <div>
                <img src="{{ asset('storage/' . $product->product_photo) }}"
                    alt="{{ $product->product_name }}"
                    width="150"
                    height="150"
                    style="object-fit: cover; border-radius: 8px; border: 2px solid #ddd;">
            </div>
        </div>
        @endif

        <!-- Photo -->
        <div class="mb-3">
            <label for="photo" class="form-label fw-bold">Change Photo</label>
            <input type="file"
                name="product_photo"
                id="product_photo"
                class="form-control @error('product_photo') is-invalid @enderror"
                accept="image/*">
            <small class="text-muted">Leave blank to keep current photo. Allowed formats: JPG, PNG, JPEG, GIF. Max size: 2MB</small>
            @error('product_photo')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea name="product_description"
                id="product_description"
                class="form-control @error('product_description') is-invalid @enderror"
                rows="4"
                placeholder="Enter product description">{{ old('product_description', $product->product_description) }}</textarea>
            @error('product_description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Product
            </button>
            <a href="{{ route('product.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection