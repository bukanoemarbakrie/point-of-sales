@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <h5 class="card-title">{{ $title ?? '' }}</h5>
                <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your name" required value="{{ $student->name  }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone *</label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                    placeholder="Enter your phone" value="{{ $student->phone  }}">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image </label>
                                <input type="file" id="image" name="image">

                                <img src="{{ asset('uploads/students/'.$student->image) }}" alt="" width="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" required value="{{ $student->email  }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block">Gender *</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="1" {{ $student->gender == 1 ? 'checked': '' }}>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="0" {{ $student->gender == 0 ? 'checked': '' }}>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Address </label>
                                <textarea name="address" id="" class="form-control" placeholder="Enter your address">{{ $student->address}}</textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
