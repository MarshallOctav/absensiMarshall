<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kelas
        $classes = ClassModel::all();

        // Query dasar untuk mengambil data absensi
        $query = Attendance::with('student');

        // Filter berdasarkan kelas jika ada `class_id` yang dipilih
        if ($request->filled('class_id')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('class_id', $request->input('class_id'));
            });
        }

        // Eksekusi query dan paginasi untuk mencegah terlalu banyak data
        $attendances = $query->paginate(10);

        // Kirim data ke view
        return view('teacher.dashboard', compact('attendances', 'classes'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'late_reason' => 'nullable|string|max:255', // Validasi untuk late_reason
        ]);

        try {
            // Ambil kelas siswa
            $student = Student::find(auth()->id()); // Ganti ini sesuai dengan cara Anda mendapatkan ID siswa
            $class = ClassModel::find($student->class_id);

            // Simpan data absensi ke database
            $attendance = Attendance::create([
                'student_id' => $student->id,
                'date' => now()->toDateString(),
                'check_in' => now()->toTimeString(),
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'image' => $request->file('image')->store('attendance_images', 'public'),
                'check_in_status' => now()->greaterThan($class->start_time) ? 'terlambat' : 'tepat waktu', // Cek status keterlambatan
                'late_reason' => $request->late_reason, // Simpan alasan keterlambatan jika ada
                'start_time' => $class->start_time, // Ambil start_time dari kelas
                'end_time' => $class->end_time, // Ambil end_time dari kelas
            ]);

            return response()->json(['success' => true, 'message' => 'Absensi berhasil dicatat.']);
        } catch (\Exception $e) {
            Log::error('Error storing attendance: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Terjadi kesalahan. Silakan coba lagi.'], 500);
        }
    }

    public function absenPulang(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            // Anda dapat menambahkan validasi lain jika perlu
        ]);

        // Ambil data absensi berdasarkan student_id dan tanggal
        $attendance = Attendance::where('student_id', Auth::id())
            ->whereDate('date', now()->toDateString())
            ->first();

        if (!$attendance) {
            return response()->json(['success' => false, 'message' => 'Data absen tidak ditemukan.'], 404);
        }

        // Update check_out dan check_out_status
        $attendance->update([
            'check_out' => now()->toTimeString(),
            'check_out_status' => now()->hour < 15 ? 'pulang cepat' : 'tepat waktu', // Contoh logika
        ]);

        return response()->json(['success' => true, 'message' => 'Absen pulang berhasil.']);
    }
}
