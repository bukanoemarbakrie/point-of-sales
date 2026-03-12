@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold text-primary">{{ $title ?? 'Edit Attendance' }}</h5>
                    <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary btn-sm">Back to List</a>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('attendance.update', $attendance->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="student_name" class="form-label fw-bold">Student Name</label>
                                <input type="text" id="student_name" class="form-control bg-light" value="{{ $attendance->student->name }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" id="date" class="form-control" value="{{ $attendance->date }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="status_in" class="form-label fw-bold">Status In</label>
                                <select class="form-select" name="status_in" id="status_in">
                                    <option value="">Select Status...</option>
                                    <option value="Hadir" {{ strtolower($attendance->status_in) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Sakit" {{ strtolower($attendance->status_in) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                    <option value="Izin" {{ strtolower($attendance->status_in) == 'izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="Alpa" {{ strtolower($attendance->status_in) == 'alpa' ? 'selected' : '' }}>Alpa</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="check_in" class="form-label fw-bold">Check In</label>
                                <input type="time" class="form-control" name="check_in" id="check_in" value="{{ $attendance->check_in ? date('H:i', strtotime($attendance->check_in)) : '' }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="status_out" class="form-label fw-bold">Status Out</label>
                                <select class="form-select" name="status_out" id="status_out">
                                    <option value="">Select Status...</option>
                                    <option value="Pulang" {{ strtolower($attendance->status_out) == 'pulang' ? 'selected' : '' }}>Pulang</option>
                                    <option value="Bolos" {{ strtolower($attendance->status_out) == 'bolos' ? 'selected' : '' }}>Bolos</option>
                                    <option value="Izin Pulang Cepat" {{ strtolower($attendance->status_out) == 'izin pulang cepat' ? 'selected' : '' }}>Izin Pulang Cepat</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="check_out" class="form-label fw-bold">Check Out</label>
                                <input type="time" class="form-control" name="check_out" id="check_out" value="{{ $attendance->check_out ? date('H:i', strtotime($attendance->check_out)) : '' }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="note" class="form-label fw-bold">Note</label>
                            <input type="text" class="form-control" name="note" id="note" placeholder="Optional..." value="{{ $attendance->note }}">
                        </div>

                        <hr>
                        <div class="text-end">
                            <button type="reset" class="btn btn-light me-2 px-4 shadow-sm">Reset</button>
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">Update Attendance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
