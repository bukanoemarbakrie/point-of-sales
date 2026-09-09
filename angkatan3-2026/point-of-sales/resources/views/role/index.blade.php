@extends('app')
@section('content')
<!-- START: Page Header Banner -->
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Data Role' }}</h1>
        <p class="page-subtitle">Manage user roles and permissions</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none text-muted-green">Home</a></li>
            <li class="breadcrumb-item active text-main" aria-current="page">Role</li>
        </ol>
    </nav>
</div>
<!-- END: Page Header Banner -->

<div class="card border-light shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">List Roles</h5>
        <a href="{{ route('role.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Role
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
                    <th>Role Name</th>
                    <th width="15%">Status</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $key => $role)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <i class="bi bi-shield-fill-check me-2 text-primary"></i>
                        {{ $role->name }}
                    </td>
                    <td>
                        @if($role->is_active == 1)
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle"></i> Active
                        </span>
                        @else
                        <span class="badge bg-danger">
                            <i class="bi bi-x-circle"></i> In-Active
                        </span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('role.edit', $role->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('role.destroy', $role->id) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" {{ $role->name == 'Administrator' ? 'disabled' : '' }}>
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                        @if($role->name == 'Administrator')
                        <span class="text-muted small">(Protected)</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-inbox display-4 d-block mb-2"></i>
                        No roles found. Click "Add Role" to create one.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Total roles -->
    <div class="mt-3 text-muted">
        <small>Total: {{ $roles->count() }} roles</small>
    </div>
</div>
@endsection
