@extends('app')
@section('content')
<!-- START: Page Header Banner -->
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Edit User' }}</h1>
        <p class="page-subtitle">Update user information</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none text-muted-green">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-decoration-none text-muted-green">User</a></li>
            <li class="breadcrumb-item active text-main" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>
<!-- END: Page Header Banner -->

<div class="card border-light shadow-sm p-4">
    <h5 class="card-title mb-4">Edit User: <span class="text-primary">{{ $user->name }}</span></h5>

    @if(auth()->id() == $user->id)
    <div class="alert alert-info">
        <i class="bi bi-info-circle-fill me-2"></i>
        You are editing your own account. Be careful with the changes.
    </div>
    @endif

    <form action="{{ route('user.update', $user->id) }}" method="post">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
            <input type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Enter full name"
                value="{{ old('name', $user->name) }}"
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
                value="{{ old('email', $user->email) }}"
                required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password (Optional) -->
        <div class="mb-3">
            <label for="password" class="form-label fw-bold">New Password</label>
            <input type="password"
                name="password"
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Leave blank to keep current password">
            <small class="text-muted">Leave blank to keep current password. Min 6 characters if changed.</small>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
            <input type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="form-control"
                placeholder="Confirm new password">
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label for="role_id" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
            <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                <option value="">Select Role</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
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
                <i class="bi bi-save"></i> Update User
            </button>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
