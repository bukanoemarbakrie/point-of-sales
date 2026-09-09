@extends('app')
@section('content')
<!-- START: Page Header Banner -->
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Management User' }}</h1>
        <p class="page-subtitle">Manage system users and their roles</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none text-muted-green">Home</a></li>
            <li class="breadcrumb-item active text-main" aria-current="page">User</li>
        </ol>
    </nav>
</div>
<!-- END: Page Header Banner -->

<div class="card border-light shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">List Users</h5>
        <a href="{{ route('user.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add User
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px; font-weight: bold;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <strong>{{ $user->name }}</strong>
                                @if(auth()->id() == $user->id)
                                <span class="badge bg-info ms-1">You</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-primary">
                            <i class="bi bi-shield-fill-check"></i>
                            {{ $user->role->name ?? 'No Role' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if(auth()->id() != $user->id)
                            <form action="{{ route('user.destroy', $user->id) }}" method="post" class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @else
                            <button class="btn btn-sm btn-secondary" disabled title="Cannot delete your own account">
                                <i class="bi bi-trash"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="bi bi-inbox display-4 d-block mb-2"></i>
                        No users found. Click "Add User" to create one.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Total users -->
    <div class="mt-3 text-muted">
        <small>Total: {{ $users->count() }} users</small>
    </div>
</div>
@endsection
