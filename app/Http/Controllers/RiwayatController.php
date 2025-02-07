<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        // Fetch attendance data from the database
        $attendances = Attendance::all(); // Adjust this query as needed

        return view('student.riwayat', compact('attendances'));
    }
}
