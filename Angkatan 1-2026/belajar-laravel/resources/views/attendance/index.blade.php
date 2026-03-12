@extends('layouts.app')
@section('content')
 <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $title ?? 'Data Attendance' }}</h5>
                <div class="mb-3" align="right">
                    <a href="{{ route('attendance.create') }}" class="btn btn-primary btn-sm">Create New Attendance</a>
                    <div class="table-responsive">
                        <table class="table table-border table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Student Name</th>
                                    <th>Date</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Status In</th>
                                    <th>Status Out</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $attendance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $attendance->student->name }}</td>
                                    <td>{{ date('d-M-Y', strtotime($attendance->date)) }}</td>
                                    <td>{{ $attendance->check_in }}</td>
                                    <td>{{ $attendance->check_out}}</td>
                                    <td>{{ $attendance->status_in }}</td>
                                    <td>{{ $attendance->status_out}}</td>
                                    <td>{{ $attendance->note}}</td>
                                    <td>
                                        <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form method="POST" action="{{ route('attendance.destroy', $attendance->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Data Attendace is Empty</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
@endsection
