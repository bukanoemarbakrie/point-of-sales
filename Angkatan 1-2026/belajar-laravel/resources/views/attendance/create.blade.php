@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold text-primary">Input Attendance (Bulk)</h5>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">Back to List</a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('attendance.store') }}" method="post">
                    @csrf
                    @include('attendance.form')
                    <hr>
                    <div class="text-end">
                        <button type="reset" class="btn btn-light me-2 px-4 shadow-sm">Reset Form</button>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm" id="btn-save">Save Attendance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
