<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\Admin;
use App\Models\Lecturer;
use App\Models\Submission;
use App\Models\ExamType;
use App\Models\StudyProgram;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        // Basic Statistics
        $totalStudents = Student::count();
        $totalLecturers = Lecturer::count();
        $totalAdmins = Admin::count();
        $totalExamTypes = ExamType::count();
        $totalStudyPrograms = StudyProgram::count();
        
        // Student Statistics
        $verifiedStudents = Student::where('is_verified', true)->count();
        $unverifiedStudents = Student::where('is_verified', false)->count();
        
        // Submission Statistics
        $allSubmissions = Submission::all();
        $pendingSubmissions = $allSubmissions->where('status', 'menunggu_verifikasi');
        $approvedSubmissions = $allSubmissions->where('status', 'berkas_diterima');
        $rejectedSubmissions = $allSubmissions->where('status', 'berkas_ditolak');
        
        // Lecturer Statistics
        $activeLecturers = Lecturer::where('status', 'active')->count();
        $inactiveLecturers = Lecturer::where('status', 'inactive')->count();
        
        // Study Program Statistics
        $activeStudyPrograms = StudyProgram::where('is_active', true)->count();
        $inactiveStudyPrograms = StudyProgram::where('is_active', false)->count();
        
        // Recent Activities
        $recentSubmissions = Submission::with(['student', 'examType'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $recentStudents = Student::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $recentLecturers = Lecturer::with('studyProgram')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Monthly Statistics (last 6 months)
        $monthlySubmissions = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlySubmissions[] = [
                'month' => $date->format('M Y'),
                'count' => Submission::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            ];
        }

        $stats = [
            'total_submissions' => $allSubmissions->count(),
            'pending_submissions' => $pendingSubmissions->count(),
            'approved_submissions' => $approvedSubmissions->count(),
            'rejected_submissions' => $rejectedSubmissions->count(),
            'total_students' => $totalStudents,
            'total_lecturers' => $totalLecturers,
            'total_admins' => $totalAdmins,
            'total_exam_types' => $totalExamTypes,
            'total_study_programs' => $totalStudyPrograms,
            'verified_students' => $verifiedStudents,
            'unverified_students' => $unverifiedStudents,
            'active_lecturers' => $activeLecturers,
            'inactive_lecturers' => $inactiveLecturers,
            'active_study_programs' => $activeStudyPrograms,
            'inactive_study_programs' => $inactiveStudyPrograms,
        ];

        return view('admin.dashboard', compact('stats', 'recentSubmissions', 'recentStudents', 'recentLecturers', 'monthlySubmissions'));
    }

    public function submissions()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $submissions = Submission::with(['student', 'examType', 'documents'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.submissions', compact('submissions'));
    }

    public function verifySubmission(Request $request, $id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $submission = Submission::findOrFail($id);
        $submission->status = 'berkas_diterima';
        $submission->verified_by = Session::get('user_name');
        $submission->verified_at = now();
        $submission->save();

        return redirect()->back()->with('success', 'Pengajuan berhasil diverifikasi!');
    }

    public function rejectSubmission(Request $request, $id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'revision_reason' => 'required|string|max:1000'
        ]);

        $submission = Submission::findOrFail($id);
        $submission->status = 'berkas_ditolak';
        $submission->revision_reason = $request->revision_reason;
        $submission->verified_by = Session::get('user_name');
        $submission->verified_at = now();
        $submission->save();

        return redirect()->back()->with('success', 'Pengajuan ditolak dengan alasan yang diberikan.');
    }

    public function downloadDocument($submissionId, $documentId)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $submission = Submission::findOrFail($submissionId);
            $document = $submission->documents()->findOrFail($documentId);
            
            // File disimpan di storage/app/private/submissions/{id}/filename
            // Karena disk 'local' mengarah ke storage/app/private
            $filePath = storage_path('app/private/' . $document->file_path);
            
            \Log::info('Trying to download file: ' . $filePath);
            \Log::info('File exists: ' . (file_exists($filePath) ? 'Yes' : 'No'));
            
            if (!file_exists($filePath)) {
                \Log::error('File not found at: ' . $filePath);
                return response()->json(['error' => 'File tidak ditemukan di: ' . $filePath], 404);
            }
            
            // Set proper headers for PDF
            if ($document->mime_type === 'application/pdf') {
                $headers = [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $document->original_filename . '"',
                    'Cache-Control' => 'public, max-age=3600'
                ];
            } else {
                $headers = [
                    'Content-Type' => $document->mime_type,
                    'Content-Disposition' => 'attachment; filename="' . $document->original_filename . '"'
                ];
            }
            
            return response()->file($filePath, $headers);
        } catch (\Exception $e) {
            \Log::error('Error downloading document: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengunduh file: ' . $e->getMessage()], 500);
        }
    }

    public function getSubmissionDocuments($submissionId)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $submission = Submission::findOrFail($submissionId);
            $documents = $submission->documents()->get();
            
            $documentsData = $documents->map(function($doc) {
                return [
                    'id' => $doc->id,
                    'original_filename' => $doc->original_filename,
                    'file_path' => $doc->file_path,
                    'file_size' => $doc->file_size,
                    'mime_type' => $doc->mime_type,
                    'created_at' => $doc->created_at
                ];
            });
            
            return response()->json($documentsData);
        } catch (\Exception $e) {
            \Log::error('Error getting submission documents: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get documents'], 500);
        }
    }

    public function students()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $students = Student::orderBy('created_at', 'desc')->get();
        $studyPrograms = StudyProgram::where('is_active', true)->orderBy('name')->get();
        return view('admin.students', compact('students', 'studyPrograms'));
    }

    public function verifyStudent(Request $request, $id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $student = Student::findOrFail($id);
        $student->is_verified = true;
        $student->verified_by = Session::get('user_name');
        $student->verified_at = now();
        $student->save();

        return redirect()->back()->with('success', 'Mahasiswa berhasil diverifikasi!');
    }

    public function updateStudent(Request $request, $id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'nim' => 'required|string|max:255|unique:students,nim,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $id,
            'study_program' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'is_verified' => 'boolean'
        ]);

        $student = Student::findOrFail($id);
        $student->update($request->all());

        return redirect()->back()->with('success', 'Data mahasiswa berhasil diperbarui!');
    }

    public function updateStudentPassword(Request $request, $id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'new_password' => 'required|string|min:6|confirmed'
        ]);

        $student = Student::findOrFail($id);
        $student->password = Hash::make($request->new_password);
        $student->save();

        return redirect()->back()->with('success', 'Password mahasiswa berhasil diperbarui!');
    }

    public function storeStudent(Request $request)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'nim' => 'required|string|max:255|unique:students,nim',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email',
            'password' => 'required|string|min:6|confirmed',
            'study_program' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:14',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
            'is_verified' => 'boolean'
        ]);

        $studentData = $request->all();
        $studentData['password'] = Hash::make($request->password);
        $studentData['is_verified'] = $request->has('is_verified') ? true : false;
        $studentData['verified_by'] = $request->has('is_verified') ? Session::get('user_name') : null;
        $studentData['verified_at'] = $request->has('is_verified') ? now() : null;
        $studentData['registration_date'] = now();
        
        Student::create($studentData);

        return redirect()->back()->with('success', 'Akun mahasiswa berhasil ditambahkan!');
    }

    public function destroyStudent($id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $student = Student::findOrFail($id);
        
        // Delete related submissions and documents
        $submissions = $student->submissions;
        foreach ($submissions as $submission) {
            // Delete submission documents
            foreach ($submission->documents as $document) {
                // Delete file from storage
                if (file_exists(storage_path('app/' . $document->file_path))) {
                    unlink(storage_path('app/' . $document->file_path));
                }
                $document->delete();
            }
            $submission->delete();
        }
        
        // Delete student
        $student->delete();

        return redirect()->back()->with('success', 'Akun mahasiswa berhasil dihapus!');
    }

    public function lecturers()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $lecturers = Lecturer::with('studyProgram')->orderBy('created_at', 'desc')->get();
        $studyPrograms = StudyProgram::where('is_active', true)->orderBy('name')->get();
        
        // Create dummy expertise data for the form
        $expertises = collect([
            (object)['id' => 1, 'name' => 'Teknik Informatika'],
            (object)['id' => 2, 'name' => 'Sistem Informasi'],
            (object)['id' => 3, 'name' => 'Manajemen Dakwah'],
            (object)['id' => 4, 'name' => 'Tafsir Hadis'],
            (object)['id' => 5, 'name' => 'Pendidikan Agama Islam'],
        ]);
        
        return view('admin.lecturers', compact('lecturers', 'studyPrograms', 'expertises'));
    }

    public function storeLecturer(Request $request)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'nip' => 'required|string|max:255|unique:lecturers,nip',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:lecturers,email',
            'password' => 'required|string|min:6|confirmed',
            'expertise' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'study_program_id' => 'nullable|exists:study_programs,id'
        ]);

        $lecturerData = $request->all();
        $lecturerData['password'] = Hash::make($request->password);
        
        Lecturer::create($lecturerData);

        return redirect()->back()->with('success', 'Dosen baru berhasil ditambahkan!');
    }


    public function updateLecturer(Request $request, $id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        \Log::info('Update Lecturer Request', [
            'id' => $id,
            'data' => $request->all()
        ]);

        $validationRules = [
            'nip' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'expertise' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'study_program_id' => 'nullable|exists:study_programs,id',
        ];

        // Add password validation only if password is provided
        if ($request->filled('password')) {
            $validationRules['password'] = 'required|string|min:6|confirmed';
        }

        $request->validate($validationRules);

        $lecturer = Lecturer::findOrFail($id);
        $lecturerData = $request->all();
        
        // Handle password update
        if ($request->filled('password')) {
            $lecturerData['password'] = Hash::make($request->password);
            \Log::info('Password updated for lecturer', ['id' => $id]);
        } else {
            unset($lecturerData['password']);
            \Log::info('Password not updated for lecturer', ['id' => $id]);
        }
        
        \Log::info('Updating lecturer with data', [
            'id' => $id,
            'data' => $lecturerData
        ]);
        
        $lecturer->update($lecturerData);

        \Log::info('Lecturer updated successfully', ['id' => $id]);

        return redirect()->back()->with('success', 'Data dosen berhasil diperbarui!');
    }

    public function destroyLecturer($id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $lecturer = Lecturer::findOrFail($id);
        $lecturer->delete();

        return redirect()->back()->with('success', 'Data dosen berhasil dihapus!');
    }

    public function reports()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $submissions = Submission::with(['student', 'examType'])->get();
        $examTypes = ExamType::all();
        
        return view('admin.reports', compact('submissions', 'examTypes'));
    }

    public function registrations()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $students = Student::orderBy('created_at', 'desc')->get();
        return view('admin.registrations', compact('students'));
    }

    public function settings()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $admin = Admin::findOrFail(Session::get('user_id'));
        return view('admin.settings', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500'
        ]);

        $admin = Admin::findOrFail(Session::get('user_id'));
        $admin->update($request->only(['name', 'email', 'phone', 'address']));

        // Update session name if changed
        Session::put('user_name', $admin->name);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed'
        ]);

        $admin = Admin::findOrFail(Session::get('user_id'));

        // Check current password
        if ($admin->password !== $request->current_password) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai!');
        }

        // Update password
        $admin->password = $request->new_password;
        $admin->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }

    public function studyPrograms()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $studyPrograms = StudyProgram::with(['lecturers'])->orderBy('faculty')->orderBy('name')->get();
        return view('admin.study-programs', compact('studyPrograms'));
    }

    public function storeStudyProgram(Request $request)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        try {
            $request->validate([
                'code' => 'required|string|max:10|unique:study_programs,code',
                'name' => 'required|string|max:255',
                'faculty' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000'
            ]);

            $studyProgram = StudyProgram::create([
                'code' => $request->code,
                'name' => $request->name,
                'faculty' => $request->faculty,
                'description' => $request->description,
                'is_active' => true
            ]);

            return redirect()->back()->with('success', 'Program studi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updateStudyProgram(Request $request, $id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'code' => 'required|string|max:10|unique:study_programs,code,' . $id,
            'name' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        $studyProgram = StudyProgram::findOrFail($id);
        $studyProgram->update($request->all());

        return redirect()->back()->with('success', 'Program studi berhasil diperbarui!');
    }

    public function destroyStudyProgram($id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $studyProgram = StudyProgram::findOrFail($id);
        
        // Check if there are students using this study program
        $studentCount = Student::where('study_program', $studyProgram->name)->count();
        if ($studentCount > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus program studi yang masih memiliki mahasiswa!');
        }

        $studyProgram->delete();

        return redirect()->back()->with('success', 'Program studi berhasil dihapus!');
    }

    public function examTypes()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $examTypes = ExamType::orderBy('name')->get();
        return view('admin.exam-types', compact('examTypes'));
    }

    public function storeExamType(Request $request)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:exam_types,code',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive'
        ]);

        ExamType::create($request->all());

        return redirect()->back()->with('success', 'Jenis ujian berhasil ditambahkan!');
    }

    public function updateExamType(Request $request, $id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:exam_types,code,' . $id,
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive'
        ]);

        $examType = ExamType::findOrFail($id);
        $examType->update($request->all());

        return redirect()->back()->with('success', 'Jenis ujian berhasil diperbarui!');
    }

    public function destroyExamType($id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('auth.login');
        }

        $examType = ExamType::findOrFail($id);
        
        // Check if exam type has submissions
        if ($examType->submissions()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus jenis ujian yang memiliki pengajuan!');
        }

        $examType->delete();

        return redirect()->back()->with('success', 'Jenis ujian berhasil dihapus!');
    }
}
