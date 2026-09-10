@extends('app')
@section('content')
<form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-control" required>
            <option value="" hidden>Select One</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" class="form-control" name="product_name" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" class="form-control" name="product_price" step="any" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Qty</label>
        <input type="number" class="form-control" name="qty" min="0" value="0" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Photo</label>
        <input type="file" class="form-control" name="product_photo">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="product_description"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="is_active" value="1" checked>
            <label class="form-check-label">Active</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="is_active" value="0">
            <label class="form-check-label">In-Active</label>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Simpan</button>
    <a href="{{ route('product.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
