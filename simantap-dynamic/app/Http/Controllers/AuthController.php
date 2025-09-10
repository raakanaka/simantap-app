<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Admin;
use App\Models\Lecturer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showStudentLogin()
    {
        $studyPrograms = \App\Models\StudyProgram::where('is_active', true)->get();
        return view('auth.student-login', compact('studyPrograms'));
    }

    public function showStudentRegister()
    {
        $studyPrograms = \App\Models\StudyProgram::where('is_active', true)->get();
        return view('auth.register', compact('studyPrograms'));
    }

    public function showLecturerLogin()
    {
        return view('auth.lecturer-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'user_type' => 'required|in:student,admin,lecturer',
            'password' => 'required|string',
        ]);

        $user = null;
        $userType = $request->user_type;

        if ($userType === 'student') {
            $request->validate(['nim' => 'required|string']);
            $user = Student::where('nim', $request->nim)->first();
        } elseif ($userType === 'admin') {
            $request->validate(['username' => 'required|string']);
            $user = Admin::where('username', $request->username)->first();
        } elseif ($userType === 'lecturer') {
            $request->validate(['username' => 'required|string']);
            // Cari dosen berdasarkan NIP atau email
            $user = Lecturer::where('nip', $request->username)
                           ->orWhere('email', $request->username)
                           ->first();
            
        }

        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('user_id', $user->id);
            Session::put('user_type', $userType);
            Session::put('user_name', $user->name);
            
            if ($userType === 'student') {
                Session::put('student_nim', $user->nim);
                return redirect()->route('student.dashboard');
            } elseif ($userType === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($userType === 'lecturer') {
                return redirect()->route('lecturer.dashboard');
            }
        }

        return redirect()->back()->with('error', 'Username/NIM atau password salah!');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('auth.login')->with('success', 'Berhasil logout!');
    }

    public function studentLogin(Request $request)
    {
        $request->validate([
            'login_field' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari mahasiswa berdasarkan NIM atau email
        $student = Student::where('nim', $request->login_field)
                         ->orWhere('email', $request->login_field)
                         ->first();

        if ($student) {
            // Cek status mahasiswa
            if ($student->status === 'pending') {
                return back()->withErrors(['login_field' => 'Akun Anda masih menunggu verifikasi admin.']);
            }
            
            if ($student->status === 'rejected') {
                return back()->withErrors(['login_field' => 'Akun Anda ditolak. Silakan hubungi admin.']);
            }

            // Cek password menggunakan Hash::check
            if (Hash::check($request->password, $student->password)) {
                // Set session untuk kompatibilitas dengan sistem yang ada
                Session::put('user_id', $student->id);
                Session::put('user_name', $student->name);
                Session::put('user_type', 'student');
                Session::put('user_email', $student->email);
                Session::put('student_nim', $student->nim);

                return redirect()->route('student.dashboard');
            }
        }

        return back()->withErrors(['login_field' => 'NIM/Email atau password salah.']);
    }

    public function studentRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|unique:students,nim',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string',
            'study_program_id' => 'required|exists:study_programs,id',
            'password' => 'required|string|min:8|confirmed',
            'ktm_file' => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
            'terms' => 'required|accepted',
        ]);

        // Handle KTM file upload
        $ktmPath = null;
        if ($request->hasFile('ktm_file')) {
            $ktmFile = $request->file('ktm_file');
            $ktmPath = $ktmFile->store('ktm_files', 'public');
        }

        // Get study program name from ID
        $studyProgram = \App\Models\StudyProgram::find($request->study_program_id);
        
        $student = Student::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            'phone' => $request->phone,
            'study_program' => $studyProgram ? $studyProgram->name : null,
            'faculty' => $studyProgram ? $studyProgram->faculty : null,
            'password' => Hash::make($request->password),
            'ktm_file' => $ktmPath,
            'status' => 'pending',
        ]);

        return redirect()->route('student.login')->with('success', 'Registrasi berhasil! Akun Anda akan diverifikasi admin dalam 1-2 hari kerja.');
    }

    public function lecturerLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $lecturer = Lecturer::where('email', $request->email)->first();

        if ($lecturer && Hash::check($request->password, $lecturer->password)) {
            Session::put('user_id', $lecturer->id);
            Session::put('user_name', $lecturer->name);
            Session::put('user_type', 'lecturer');
            Session::put('user_email', $lecturer->email);

            return redirect()->route('lecturer.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }
}
