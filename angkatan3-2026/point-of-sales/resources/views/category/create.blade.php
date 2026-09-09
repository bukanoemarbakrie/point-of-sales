@extends('app')
@section('content')
<!-- START: Page Header Banner -->
<div class="page-header">
    <div>
        <h1 class="page-title">Create New Category</h1>
        <p class="page-subtitle">Add a new product category</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none text-muted-green">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}" class="text-decoration-none text-muted-green">Category</a></li>
            <li class="breadcrumb-item active text-main" aria-current="page">Create</li>
        </ol>
    </nav>
</div>
<!-- END: Page Header Banner -->

<div class="card border-light shadow-sm p-4">
    <h5 class="card-title mb-4">Category Information</h5>

    <form action="{{ route('category.store') }}" method="post">
        @csrf

        <!-- Name Input -->
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
            <input type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Enter category name (e.g., Coffee, Snack)"
                value="{{ old('name') }}"
                required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Status Radio -->
        <div class="mb-4">
            <label class="form-label fw-bold">Status</label>
            <div class="mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="active" value="1" checked>
                    <label class="form-check-label" for="active">
                        <span class="badge bg-success">Active</span>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0">
                    <label class="form-check-label" for="inactive">
                        <span class="badge bg-danger">In-Active</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Save Category
            </button>
            <a href="{{ route('category.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
