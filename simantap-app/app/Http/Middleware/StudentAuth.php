<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Check if the authenticated user is a student
        if (!Auth::user() instanceof \App\Models\Student) {
            Auth::logout();
            return redirect('/login')->withErrors(['nim' => 'Akses ditolak. Hanya mahasiswa yang dapat mengakses sistem ini.']);
        }

        return $next($request);
    }
}
