<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lecturer;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('lecturer.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('lecturer')->attempt($credentials)) {
            $lecturer = Auth::guard('lecturer')->user();
            $lecturer->update(['last_login_at' => now()]);
            
            $request->session()->regenerate();
            return redirect()->intended('/lecturer/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::guard('lecturer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/lecturer/login');
    }
}
