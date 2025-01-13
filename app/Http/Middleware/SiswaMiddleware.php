<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SiswaMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'siswa') {
            return $next($request);
        }

        return redirect('/login'); // Atau halaman lain jika tidak memiliki akses
    }
}