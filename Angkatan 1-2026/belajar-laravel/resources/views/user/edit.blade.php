@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                  <div class="alert alert-danger">{{ $errors->first() }}</div>
                  @endif
               <h5 class="card-title">{{ $tittle ?? ''  }}</h5>
               <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Role *</label>
                    <select name="role_id" id="" class="form-control">
                        <option value="">--Select Role--</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required value="{{ $user->name }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required value="{{ $user->email }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" value="">
                    <small class="text-secondary">Leave blank if you don't want to change the password</small>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url()->previous()}}" class="btn btn-secondary">Back</a>
               </form>
            </div>
        </div>
    </div>
</div>
@endsection
