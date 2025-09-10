<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\FormulirPendaftaranController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('auth.login');
});

// Test route - no authentication required
Route::get('/test-download-pdf', function () {
    $filePath = public_path('formulir_template.pdf');
    return response()->download($filePath, 'Formulir_Test.pdf');
});

// Test submission route
Route::post('/test-submission', function (\Illuminate\Http\Request $request) {
    \Log::info('Test submission received:', $request->all());
    return response()->json(['status' => 'success', 'data' => $request->all()]);
});

// Test student submission route
Route::post('/test-student-submission', function (\Illuminate\Http\Request $request) {
    \Log::info('Test student submission received:', $request->all());
    return response()->json(['status' => 'success', 'data' => $request->all()]);
});

// Test session route
Route::get('/test-session', function () {
    \Log::info('Test session route accessed');
    return response()->json([
        'session_id' => session()->getId(),
        'user_id' => session('user_id'),
        'user_type' => session('user_type'),
        'all_session' => session()->all()
    ]);
});

// Test form route without authentication
Route::get('/test-form', function () {
    return view('student.create-submission', [
        'examTypes' => \App\Models\ExamType::where('status', 'active')->get(),
        'selectedExamType' => \App\Models\ExamType::first()
    ]);
});

// Test submission route without authentication
Route::post('/test-submit', function (\Illuminate\Http\Request $request) {
    \Log::info('Test submission received:', [
        'exam_type_id' => $request->exam_type_id,
        'title' => $request->title,
        'documents_count' => $request->hasFile('documents') ? count($request->file('documents')) : 0,
        'requirement_ids' => $request->requirement_ids,
        'all_data' => $request->all()
    ]);

    // Debug file information
    if ($request->hasFile('documents')) {
        foreach ($request->file('documents') as $index => $file) {
            \Log::info("File $index debug:", [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'client_mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'is_valid' => $file->isValid(),
                'error' => $file->getError(),
                'extension' => $file->getClientOriginalExtension()
            ]);
        }
    }

    // Custom validation for documents
    $documents = $request->file('documents');
    $validatedDocuments = [];
    
    if (!$documents || count($documents) === 0) {
        return response()->json(['error' => 'Dokumen harus diupload'], 400);
    }
    
    foreach ($documents as $index => $file) {
        if (!$file || !$file->isValid()) {
            \Log::error("File $index is invalid:", [
                'is_file' => $file ? 'yes' : 'no',
                'is_valid' => $file ? $file->isValid() : 'no',
                'error' => $file ? $file->getError() : 'no file'
            ]);
            return response()->json(['error' => "File $index tidak valid atau rusak"], 400);
        }
        
        $allowedMimes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $allowedExtensions = ['pdf', 'doc', 'docx'];
        
        $mimeType = $file->getMimeType();
        $extension = strtolower($file->getClientOriginalExtension());
        
        \Log::info("File $index validation:", [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $mimeType,
            'extension' => $extension,
            'size' => $file->getSize(),
            'allowed_mimes' => $allowedMimes,
            'allowed_extensions' => $allowedExtensions
        ]);
        
        if (!in_array($mimeType, $allowedMimes) && !in_array($extension, $allowedExtensions)) {
            \Log::error("File $index validation failed:", [
                'mime_type' => $mimeType,
                'extension' => $extension,
                'not_in_mimes' => !in_array($mimeType, $allowedMimes),
                'not_in_extensions' => !in_array($extension, $allowedExtensions)
            ]);
            return response()->json(['error' => "File $index format tidak valid. Harus PDF, DOC, atau DOCX"], 400);
        }
        
        if ($file->getSize() > 10240 * 1024) { // 10MB
            return response()->json(['error' => "File $index terlalu besar. Maksimal 10MB"], 400);
        }
        
        $validatedDocuments[] = $file;
    }
    
    return response()->json([
        'success' => true,
        'message' => 'File upload validation passed',
        'validated_files' => count($validatedDocuments),
        'files' => array_map(function($file) {
            return [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'type' => $file->getMimeType()
            ];
        }, $validatedDocuments)
    ]);
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// Alias untuk kompatibilitas Laravel auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Student Authentication Routes
Route::get('/student/login', [AuthController::class, 'showStudentLogin'])->name('student.login');
Route::post('/student/login', [AuthController::class, 'studentLogin'])->name('student.login');
Route::get('/student/register', [AuthController::class, 'showStudentRegister'])->name('student.register');
Route::post('/student/register', [AuthController::class, 'studentRegister'])->name('student.register');

// Lecturer Authentication Routes
Route::get('/lecturer/login', [AuthController::class, 'showLecturerLogin'])->name('lecturer.login');
Route::post('/lecturer/login', [AuthController::class, 'lecturerLogin'])->name('lecturer.login');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/submissions', [AdminController::class, 'submissions'])->name('submissions');
    Route::post('/submissions/{id}/verify', [AdminController::class, 'verifySubmission'])->name('verify-submission');
    Route::post('/submissions/{id}/reject', [AdminController::class, 'rejectSubmission'])->name('reject-submission');
    Route::get('/submissions/{submissionId}/documents/{documentId}/download', [AdminController::class, 'downloadDocument'])->name('download-document');
    Route::get('/submissions/{submissionId}/documents', [AdminController::class, 'getSubmissionDocuments'])->name('submission-documents');


        Route::get('/students', [AdminController::class, 'students'])->name('students');
        Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
        Route::post('/students/{id}/verify', [AdminController::class, 'verifyStudent'])->name('verify-student');
        Route::put('/students/{id}', [AdminController::class, 'updateStudent'])->name('students.update');
        Route::post('/students/{id}/password', [AdminController::class, 'updateStudentPassword'])->name('students.password');
        Route::delete('/students/{id}', [AdminController::class, 'destroyStudent'])->name('students.destroy');
    Route::get('/lecturers', [AdminController::class, 'lecturers'])->name('lecturers');
    Route::post('/lecturers', [AdminController::class, 'storeLecturer'])->name('lecturers.store');
    Route::put('/lecturers/{id}', [AdminController::class, 'updateLecturer'])->name('lecturers.update');
    Route::delete('/lecturers/{id}', [AdminController::class, 'destroyLecturer'])->name('lecturers.destroy');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/registrations', [AdminController::class, 'registrations'])->name('registrations');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings/profile', [AdminController::class, 'updateProfile'])->name('settings.profile');
        Route::post('/settings/password', [AdminController::class, 'updatePassword'])->name('settings.password');
        Route::get('/study-programs', [AdminController::class, 'studyPrograms'])->name('study-programs');
        Route::post('/study-programs', [AdminController::class, 'storeStudyProgram'])->name('study-programs.store');
        Route::put('/study-programs/{id}', [AdminController::class, 'updateStudyProgram'])->name('study-programs.update');
        Route::delete('/study-programs/{id}', [AdminController::class, 'destroyStudyProgram'])->name('study-programs.destroy');
        Route::get('/exam-types', [AdminController::class, 'examTypes'])->name('exam-types');
        Route::post('/exam-types', [AdminController::class, 'storeExamType'])->name('exam-types.store');
        Route::put('/exam-types/{id}', [AdminController::class, 'updateExamType'])->name('exam-types.update');
        Route::delete('/exam-types/{id}', [AdminController::class, 'destroyExamType'])->name('exam-types.destroy');
    });

// Lecturer Routes
Route::prefix('lecturer')->name('lecturer.')->group(function () {
    Route::get('/dashboard', [LecturerController::class, 'dashboard'])->name('dashboard');
    Route::get('/submissions', [LecturerController::class, 'submissions'])->name('submissions');
    Route::get('/status', [LecturerController::class, 'status'])->name('status');
    Route::get('/tasks', [LecturerController::class, 'tasks'])->name('tasks');
    Route::post('/submissions/{id}/verify', [LecturerController::class, 'verifySubmission'])->name('verify-submission');
    Route::post('/submissions/{id}/reject', [LecturerController::class, 'rejectSubmission'])->name('reject-submission');
    Route::post('/submissions/bulk-approve', [LecturerController::class, 'bulkApprove'])->name('bulk-approve');
    Route::post('/submissions/bulk-reject', [LecturerController::class, 'bulkReject'])->name('bulk-reject');
    Route::get('/submissions/{submissionId}/documents/{documentId}/download', [LecturerController::class, 'downloadDocument'])->name('download-document');
    Route::get('/submissions/{submissionId}/documents', [LecturerController::class, 'getSubmissionDocuments'])->name('submission-documents');
});

// Student Routes (Protected)
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/exam-types', [StudentController::class, 'examTypes'])->name('exam-types');
    Route::get('/requirements/{examTypeId}', [StudentController::class, 'showRequirements'])->name('requirements');                                                                        
    Route::get('/create-submission/{examTypeId?}', [StudentController::class, 'createSubmission'])->name('create-submission');
    Route::get('/my-submissions', [StudentController::class, 'mySubmissions'])->name('my-submissions');                                                                                    
    Route::post('/submit-application', [StudentController::class, 'storeSubmission'])->name('submit-application');
    Route::get('/submissions/{submissionId}/download-formulir', [FormulirPendaftaranController::class, 'downloadFormulir'])->name('download-formulir');
    Route::get('/submissions/{submissionId}/documents', [StudentController::class, 'getSubmissionDocuments'])->name('submission-documents');
});
