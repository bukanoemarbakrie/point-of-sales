@extends('app')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title ?? 'Data Category' }}</h1>
    </div>
</div>

<div class="card border-light shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">List Categories</h5>
        <a href="{{ route('category.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Category
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th width="5%">#</th>
                    <th>Category Name</th>
                    <th width="15%">Status</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $key => $category)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $category->category_name }}</td>
                    <td>
                        @if($category->is_active == 1)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-danger">In-Active</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('category.destroy', $category->id) }}" method="post" class="d-inline"
                            onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">No categories found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
