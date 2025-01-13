<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // Menampilkan halaman home siswa
    public function index()
    {
        $absences = Attendance::where('student_id', auth()->id())
            ->where('date', '>=', now()->subWeek()) // Mengambil data satu minggu terakhir
            ->orderBy('date', 'desc')
            ->get();

        return view('student.home', compact('absences'));
    }

    // Menampilkan form absen masuk
    public function showCheckInForm()
    {
        return view('student.absen-masuk');
    }

    // Menyimpan absensi masuk (check-in)
    public function storeCheckIn(Request $request)
    {
        // Validasi input
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'required',
        ]);

        // Menyimpan data absensi
        $attendance = new Attendance();
        $attendance->student_id = Auth::id();
        $attendance->date = now()->format('Y-m-d');
        $attendance->check_in = now()->format('H:i:s');
        $attendance->latitude = $request->latitude;
        $attendance->longitude = $request->longitude;
        $attendance->image = $request->image;
        $attendance->check_in_status = 'tepat waktu'; // Status bisa disesuaikan
        $attendance->save();

        return redirect()->route('student.home')->with('success', 'Absensi berhasil');
    }

    // Menampilkan form absen pulang
    public function showCheckOutForm()
    {
        return view('student.absen-pulang');
    }

    // Menyimpan absensi pulang (check-out)
    public function storeCheckOut(Request $request)
    {
        // Validasi input
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // Menyimpan data absensi pulang
        $attendance = Attendance::where('student_id', Auth::id())
            ->whereDate('date', now()->format('Y-m-d'))
            ->first();

        if ($attendance) {
            $attendance->check_out = now()->format('H:i:s');
            $attendance->check_out_status = 'tepat waktu'; // Status bisa disesuaikan
            $attendance->save();

            return redirect()->route('student.home')->with('success', 'Absensi pulang berhasil');
        }

        return redirect()->route('student.home')->with('error', 'Absen masuk tidak ditemukan');
    }
}
