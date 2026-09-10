@extends('app')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Data Role' }}</h1>
        <p class="page-subtitle">Manage user roles</p>
    </div>
</div>

<div class="card border-light shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">List Roles</h5>
        <a href="{{ route('role.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Role
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th width="5%">#</th>
                    <th>Role Name</th>
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
                        <a href="{{ route('role.edit', $role->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('role.destroy', $role->id) }}" method="post" class="d-inline"
                            onsubmit="return confirm('Delete this role?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" {{ $role->name == 'Administrator' ? 'disabled' : '' }}>
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-muted">No roles found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
