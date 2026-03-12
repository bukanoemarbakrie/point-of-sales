<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = Attendance::with('student')->latest()->get();
        $title = 'Data Attendance';
        return view('attendance.index', compact('attendances', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::get();
        return view('attendance.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date = $request->date;
        $attendaces = $request->attendances;
        foreach($attendaces as $attendace){
            //Jika Datanya ada, kita update
            $existingAttendance = Attendance::where('student_id', $attendace['student_id'])->whereDate('date', $date)
            ->first();
            if($existingAttendance){
                $existingAttendance->update([
                    'status_in' => $attendace['status_in'] ?? null,
                    'check_in' => $attendace['check_in'] ?? null,
                    'status_out' => $attendace['status_out'] ?? null,
                    'check_out' => $attendace['check_out'] ?? null,
                    'note' => $attendace['note'] ?? null,
                ]);
            }else{
                //Kalo tidak ada insert
                Attendance::create([
                    'student_id' => $attendace['student_id'],
                    'date' => $date,
                    'status_in' => $attendace['status_in'] ?? null,
                    'check_in' => $attendace['check_in'] ?? null,
                    'status_out' => $attendace['status_out'] ?? null,
                    'check_out' => $attendace['check_out'] ?? null,
                    'note' => $attendace['note'] ?? null,

                ]);
            }
             Alert::success('Success', 'Attendance created successfully');
             return redirect()->route('attendance.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attendance = Attendance::with('student')->findOrFail($id);
        $title = 'Edit Attendance';
        return view('attendance.edit', compact('attendance', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required|date',
            'status_in' => 'nullable|string',
            'status_out' => 'nullable|string',
        ]);

        $attendace = Attendance::findOrFail($id);
        $attendace->update([
            'date' => $request->date,
            'status_in' => $request->status_in,
            'check_in' => $request->check_in,
            'status_out' => $request->status_out,
            'check_out' => $request->check_out,
            'note' => $request->note,
        ]);
        Alert::success('Success', 'Data Attendance has been update');
        return redirect()->route('attendance.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
