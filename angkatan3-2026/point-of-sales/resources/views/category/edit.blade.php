@extends('app')
@section('content')
<form action="{{ route('category.update', $category->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="category_name" class="form-label">Category Name</label>
        <input type="text" name="category_name" class="form-control" value="{{ old('category_name', $category->category_name) }}" required>
        @error('category_name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="is_active" value="1" {{ $category->is_active == 1 ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="is_active" value="0" {{ $category->is_active == 0 ? 'checked' : '' }}>
            <label class="form-check-label">In-Active</label>
        </div>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Kirim</button>
        <a href="{{ route('category.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
