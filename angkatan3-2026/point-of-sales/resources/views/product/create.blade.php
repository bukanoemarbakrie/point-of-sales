@extends('app')
@section('content')
<!-- START: Page Header Banner -->
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Create New Product' }}</h1>
        <p class="page-subtitle">Add a new product to inventory</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none text-muted-green">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}" class="text-decoration-none text-muted-green">Product</a></li>
            <li class="breadcrumb-item active text-main" aria-current="page">Create</li>
        </ol>
    </nav>
</div>
<!-- END: Page Header Banner -->

<div class="card border-light shadow-sm p-4">
    <h5 class="card-title mb-4">Product Information</h5>

    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <!-- Category Selection -->
        <div class="mb-3">
            <label for="category_id" class="form-label fw-bold">Category <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
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
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Enter product name"
                value="{{ old('name') }}"
                required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label fw-bold">Price <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number"
                    name="price"
                    id="price"
                    class="form-control @error('price') is-invalid @enderror"
                    placeholder="0"
                    value="{{ old('price') }}"
                    step="1000"
                    min="0"
                    required>
            </div>
            @error('price')
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
                value="{{ old('qty', 0) }}"
                min="0"
                required>
            @error('qty')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Photo -->
        <div class="mb-3">
            <label for="photo" class="form-label fw-bold">Photo</label>
            <input type="file"
                name="photo"
                id="photo"
                class="form-control @error('photo') is-invalid @enderror"
                accept="image/*">
            <small class="text-muted">Allowed formats: JPG, PNG, JPEG, GIF. Max size: 2MB</small>
            @error('photo')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea name="description"
                id="description"
                class="form-control @error('description') is-invalid @enderror"
                rows="4"
                placeholder="Enter product description">{{ old('description') }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Save Product
            </button>
            <a href="{{ route('product.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
