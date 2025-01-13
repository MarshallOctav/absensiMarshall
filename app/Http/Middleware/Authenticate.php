<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Handle the authenticated user redirect based on role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticated(Request $request, $user)
    {
        // Log the authentication details
        Log::info('User authenticated', [
            'email' => $user->email,
            'role' => $user->role,
        ]);

        // Redirect based on user role
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'teacher') {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->role == 'siswa') {
            return redirect()->route('student.home');
        }

        // Fallback if the role is unknown
        Log::warning('Unknown role for user', ['role' => $user->role]);
        return redirect('/');
    }
}
