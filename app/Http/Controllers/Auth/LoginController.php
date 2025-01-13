<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Tambahkan ini

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Ganti dengan nama view login Anda
    }

    /**
     * Mengelola login pengguna.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tambahkan logging
        Log::info('Login attempt', [ // Ganti \Log dengan Log
            'email' => $request->email,
            'password_provided' => !empty($request->password)
        ]);

        // Coba login
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate(); // Regenerasi session

            $user = Auth::user(); // Ambil pengguna yang sedang login

            Log::info('Login successful', ['user' => $user->email, 'role' => $user->role]); // Ganti \Log dengan Log

            // Redirect berdasarkan role pengguna
            return $this->authenticated($request, $user);
        }

        Log::warning('Login failed', ['email' => $request->email]); // Ganti \Log dengan Log

        // Jika login gagal, kembalikan dengan error
        return back()->withErrors([
            'email' => 'Kredensial ini tidak cocok dengan catatan kami.',
        ]);
    }

    /**
     * Menangani pengalihan setelah berhasil login.
     */
    protected function authenticated(Request $request, $user)
{
    Log::info('User  authenticated', [
        'email' => $user->email,
        'role' => $user->role,
    ]);

    if ($user->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role == 'teacher') {
        return redirect()->route('teacher.dashboard');
    } elseif ($user->role == 'siswa') {
        Log::info('Redirecting siswa to absen.show');
        return redirect()->route('student.home');
    }

    Log::warning('Unknown role for user', ['role' => $user->role]);
    return redirect('/');
}

    /**
     * Mengelola logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Logout pengguna
        $request->session()->invalidate(); // Hapus session
        $request->session()->regenerateToken(); // Regenerasi token CSRF
        return redirect('/'); // Redirect ke halaman utama
    }
}
