@extends('app')
@section('content')
<!-- START: Page Header Banner -->
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Create New User' }}</h1>
        <p class="page-subtitle">Add a new user to the system</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none text-muted-green">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-decoration-none text-muted-green">User</a></li>
            <li class="breadcrumb-item active text-main" aria-current="page">Create</li>
        </ol>
    </nav>
</div>
<!-- END: Page Header Banner -->

<div class="card border-light shadow-sm p-4">
    <h5 class="card-title mb-4">User Information</h5>

    <form action="{{ route('user.store') }}" method="post">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
            <input type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Enter full name"
                value="{{ old('name') }}"
                required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
            <input type="email"
                name="email"
                id="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Enter email address"
                value="{{ old('email') }}"
                required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
            <input type="password"
                name="password"
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Enter password (min 6 characters)"
                required>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-bold">Confirm Password <span class="text-danger">*</span></label>
            <input type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="form-control"
                placeholder="Confirm password"
                required>
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label for="role_id" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
            <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                <option value="">Select Role</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
                @endforeach
            </select>
            @error('role_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Save User
            </button>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
