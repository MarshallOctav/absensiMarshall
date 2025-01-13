<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard()
    {
        // Ambil semua kelas
        $classes = ClassModel::withCount('students')->get();

        // Ambil data untuk dashboard
        $totalStudents = Student::count();

        $today = Carbon::today();

        $todayAttendance = Attendance::whereDate('date', $today)->count();

        $lateStudents = Attendance::whereDate('date', $today)
            ->where('check_in_status', 'terlambat')
            ->count();

        $absentStudents = Student::count() - $todayAttendance;

        $presentStudents = $todayAttendance - $lateStudents;

        $recentAttendances = Attendance::with('student')
            ->whereDate('date', $today)
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact(
            'totalStudents',
            'todayAttendance',
            'lateStudents',
            'absentStudents',
            'presentStudents',
            'recentAttendances',
            'classes'
        ));
    }

    // Method attendance tetap sama seperti sebelumnya
    public function attendance(Request $request)
    {
        // Ambil kelas
        $classes = ClassModel::all();

        // Query attendance
        $query = Attendance::with(['student', 'student.class']);

        // Filter logika
        if ($request->has('class_id') && $request->class_id) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->get();

        // Sesuaikan nama view
        return view('teacher.manage_attendance', compact('attendances', 'classes'));
    }
}
