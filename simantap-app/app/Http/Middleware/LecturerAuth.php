<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LecturerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('lecturer')->check()) {
            return redirect('/lecturer/login');
        }

        $lecturer = Auth::guard('lecturer')->user();
        
        if (!$lecturer->isActive()) {
            Auth::guard('lecturer')->logout();
            return redirect('/lecturer/login')->withErrors(['username' => 'Akun dosen tidak aktif.']);
        }

        return $next($request);
    }
}
