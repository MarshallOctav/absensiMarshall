<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

     public function handle($request, Closure $next, $guard = null)
{
    if (Auth::check()) {
        // Cek apakah role user adalah siswa, jika iya, arahkan ke absen
        if (Auth::user()->role === 'siswa') {
            return redirect()->route('student.home');
        }
        // Jika tidak, arahkan ke dashboard atau halaman default lainnya
        return redirect('/dashboard');
    }

    return $next($request);
}

}
