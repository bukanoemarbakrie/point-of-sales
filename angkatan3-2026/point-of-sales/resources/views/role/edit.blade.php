@extends('app')
@section('content')
<form action="{{ route('role.update', $role->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Kirim</button>
        <a href="{{ route('role.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
