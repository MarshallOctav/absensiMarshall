<?php
namespace App\Http\Controllers;

use App\Models\ClassModel; // Ganti dengan model yang sesuai
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data kelas dari database
        $classes = ClassModel::all(); // Sesuaikan dengan model yang Anda gunakan

        return view('dashboard', compact('classes'));
    }
}
