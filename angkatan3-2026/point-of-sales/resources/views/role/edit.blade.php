@extends('app')
@section('content')
<!-- START: Page Header Banner -->
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Edit Role' }}</h1>
        <p class="page-subtitle">Update role information</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none text-muted-green">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('role.index') }}" class="text-decoration-none text-muted-green">Role</a></li>
            <li class="breadcrumb-item active text-main" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>
<!-- END: Page Header Banner -->

<div class="card border-light shadow-sm p-4">
    <h5 class="card-title mb-4">Edit Role: <span class="text-primary">{{ $role->name }}</span></h5>

    @if($role->name == 'Administrator')
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Warning:</strong> The "Administrator" role is protected and cannot be deleted.
    </div>
    @endif

    <form action="{{ route('role.update', $role->id) }}" method="post">
        @csrf
        @method('PUT')

        <!-- Name Input -->
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Role Name <span class="text-danger">*</span></label>
            <input type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Enter role name"
                value="{{ old('name', $role->name) }}"
                required
                {{ $role->name == 'Administrator' ? 'readonly' : '' }}>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if($role->name == 'Administrator')
            <small class="text-muted">Administrator role name cannot be changed</small>
            @endif
        </div>

        <!-- Status Radio -->
        <div class="mb-4">
            <label class="form-label fw-bold">Status</label>
            <div class="mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="active" value="1" {{ $role->is_active == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">
                        <span class="badge bg-success">Active</span>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0" {{ $role->is_active == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="inactive">
                        <span class="badge bg-danger">In-Active</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Role
            </button>
            <a href="{{ route('role.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
