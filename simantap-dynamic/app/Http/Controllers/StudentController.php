<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamType;
use App\Models\ExamRequirement;
use App\Models\Submission;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    public function dashboard()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'student') {
            return redirect()->route('login');
        }

        $student = \App\Models\Student::find(Session::get('user_id'));
        
        // Get student's submissions
        $submissions = Submission::where('student_nim', $student->nim)
            ->with('examType')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate stats for student dashboard
        $stats = [
            'total_submissions' => $submissions->count(),
            'pending_verification' => $submissions->where('status', 'menunggu_verifikasi')->count(),
            'accepted' => $submissions->where('status', 'berkas_diterima')->count(),
            'rejected' => $submissions->where('status', 'berkas_ditolak')->count(),
        ];
        
        return view('student.dashboard', compact('student', 'submissions', 'stats'));
    }

    public function examTypes()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'student') {
            return redirect()->route('auth.login');
        }

        $examTypes = ExamType::where('status', 'active')->orderBy('name')->get();
        return view('student.exam-types', compact('examTypes'));
    }

    public function requirements()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'student') {
            return redirect()->route('auth.login');
        }

        $requirements = ExamRequirement::all();
        return view('student.requirements', compact('requirements'));
    }

    public function showRequirements($examTypeId)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'student') {
            return redirect()->route('auth.login');
        }

        $examType = ExamType::findOrFail($examTypeId);
        $requirements = ExamRequirement::where('exam_type_id', $examTypeId)
            ->where('is_required', true)
            ->orderBy('order')
            ->get();
        
        return view('student.requirements', compact('examType', 'requirements'));
    }

    public function mySubmissions()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'student') {
            return redirect()->route('auth.login');
        }

        $student = \App\Models\Student::find(Session::get('user_id'));
        $submissions = Submission::where('student_nim', $student->nim)
            ->with(['examType', 'documents.requirement'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.my-submissions', compact('student', 'submissions'));
    }

    public function createSubmission($examTypeId = null)
    {
        // Temporarily disable authentication for debugging
        \Log::info('createSubmission called:', [
            'examTypeId' => $examTypeId,
            'session_data' => Session::all()
        ]);
        
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'student') {
            \Log::error('Authentication failed in createSubmission:', [
                'has_user_id' => Session::has('user_id'),
                'user_type' => Session::get('user_type'),
                'all_session' => Session::all()
            ]);
            return redirect()->route('auth.login');
        }

        $examTypes = ExamType::where('status', 'active')->orderBy('name')->get();
        $selectedExamType = null;
        
        if ($examTypeId) {
            $selectedExamType = ExamType::find($examTypeId);
        }
        
        return view('student.create-submission', compact('examTypes', 'selectedExamType'));
    }

    public function storeSubmission(Request $request)
    {
        // Debug session data
        \Log::info('Session data:', [
            'user_id' => Session::get('user_id'),
            'user_type' => Session::get('user_type'),
            'user_name' => Session::get('user_name'),
            'all_session' => Session::all()
        ]);
        
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'student') {
            \Log::error('Authentication failed:', [
                'has_user_id' => Session::has('user_id'),
                'user_type' => Session::get('user_type'),
                'expected_type' => 'student'
            ]);
            return redirect()->route('auth.login');
        }

        try {
            // Log request data for debugging
            \Log::info('Submission request data:', [
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
                return redirect()->back()->withErrors(['documents' => 'Dokumen harus diupload'])->withInput();
            }
            
            foreach ($documents as $index => $file) {
                if (!$file || !$file->isValid()) {
                    \Log::error("File $index is invalid:", [
                        'is_file' => $file ? 'yes' : 'no',
                        'is_valid' => $file ? $file->isValid() : 'no',
                        'error' => $file ? $file->getError() : 'no file'
                    ]);
                    return redirect()->back()->withErrors(["documents.$index" => "File tidak valid atau rusak"])->withInput();
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
                    return redirect()->back()->withErrors(["documents.$index" => "Format file tidak valid. Harus PDF, DOC, atau DOCX"])->withInput();
                }
                
                if ($file->getSize() > 10240 * 1024) { // 10MB
                    return redirect()->back()->withErrors(["documents.$index" => "Ukuran file terlalu besar. Maksimal 10MB"])->withInput();
                }
                
                $validatedDocuments[] = $file;
            }
            
            // Validate other fields
            if (!$request->exam_type_id || !\App\Models\ExamType::find($request->exam_type_id)) {
                return redirect()->back()->withErrors(['exam_type_id' => 'Jenis ujian tidak valid'])->withInput();
            }
            
            if (!$request->title || strlen($request->title) > 255) {
                return redirect()->back()->withErrors(['title' => 'Judul harus diisi dan maksimal 255 karakter'])->withInput();
            }
            
            if ($request->description && strlen($request->description) > 1000) {
                return redirect()->back()->withErrors(['description' => 'Deskripsi maksimal 1000 karakter'])->withInput();
            }
            
            if (!$request->requirement_ids || !is_array($request->requirement_ids) || count($request->requirement_ids) === 0) {
                return redirect()->back()->withErrors(['requirement_ids' => 'Pilih minimal satu persyaratan'])->withInput();
            }
            
            foreach ($request->requirement_ids as $requirementId) {
                if (!\App\Models\ExamRequirement::find($requirementId)) {
                    return redirect()->back()->withErrors(['requirement_ids' => 'Persyaratan tidak valid'])->withInput();
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error in storeSubmission:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }

        $student = \App\Models\Student::find(Session::get('user_id'));
        if (!$student) {
            \Log::error('Student not found:', ['user_id' => Session::get('user_id')]);
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan')->withInput();
        }

        $examType = ExamType::find($request->exam_type_id);
        if (!$examType) {
            \Log::error('Exam type not found:', ['exam_type_id' => $request->exam_type_id]);
            return redirect()->back()->with('error', 'Jenis ujian tidak ditemukan')->withInput();
        }

        // Generate submission number
        $submissionNumber = 'SUB-' . date('Y') . '-' . str_pad(Submission::count() + 1, 4, '0', STR_PAD_LEFT);

        \Log::info('Creating submission:', [
            'submission_number' => $submissionNumber,
            'student_nim' => $student->nim,
            'exam_type_id' => $request->exam_type_id
        ]);

        // Create submission
        $submission = Submission::create([
            'submission_number' => $submissionNumber,
            'student_nim' => $student->nim,
            'student_name' => $student->name,
            'student_study_program' => $student->study_program,
            'exam_type_id' => $request->exam_type_id,
            'exam_type_name' => $examType->name,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'menunggu_verifikasi',
            'submitted_at' => now()
        ]);

        if (!$submission) {
            \Log::error('Failed to create submission');
            return redirect()->back()->with('error', 'Gagal membuat pengajuan')->withInput();
        }

        \Log::info('Submission created successfully:', ['submission_id' => $submission->id]);

        // Handle file uploads with requirement mapping
        try {
            if (!empty($validatedDocuments) && $request->has('requirement_ids')) {
                $documents = $validatedDocuments;
                $requirementIds = $request->requirement_ids;
                
                \Log::info('Processing file uploads:', [
                    'documents_count' => count($documents),
                    'requirement_ids_count' => count($requirementIds)
                ]);
                
                foreach ($documents as $index => $file) {
                    $requirementId = $requirementIds[$index] ?? null;
                    
                    if ($requirementId) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('submissions/' . $submission->id, $filename);
                        
                        $document = $submission->documents()->create([
                            'submission_id' => $submission->id,
                            'requirement_id' => $requirementId,
                            'original_filename' => $file->getClientOriginalName(),
                            'stored_filename' => $filename,
                            'file_path' => $path,
                            'file_size' => $file->getSize(),
                            'mime_type' => $file->getMimeType()
                        ]);
                        
                        \Log::info('Document uploaded:', [
                            'document_id' => $document->id,
                            'requirement_id' => $requirementId,
                            'filename' => $filename
                        ]);
                    } else {
                        \Log::warning('No requirement ID for document:', ['index' => $index]);
                    }
                }
            } else {
                \Log::warning('No documents or requirement_ids in request');
            }
        } catch (\Exception $e) {
            \Log::error('Error uploading documents:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            // Don't fail the entire submission if file upload fails
        }

        \Log::info('Submission process completed successfully');
        return redirect()->route('student.my-submissions')->with('success', 'Pengajuan berhasil dibuat!');
    }

    public function getSubmissionDocuments($submissionId)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'student') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $student = \App\Models\Student::find(Session::get('user_id'));
        $submission = Submission::where('id', $submissionId)
            ->where('student_nim', $student->nim)
            ->with(['documents.requirement', 'examType'])
            ->first();

        if (!$submission) {
            return response()->json(['error' => 'Submission not found'], 404);
        }

        // Get all requirements for this exam type
        $requirements = \App\Models\ExamRequirement::where('exam_type_id', $submission->exam_type_id)
            ->where('is_required', true)
            ->orderBy('order')
            ->get();

        // Map requirements with upload status
        $documents = $requirements->map(function ($requirement) use ($submission) {
            $uploadedDoc = $submission->documents->where('requirement_id', $requirement->id)->first();
            
            return [
                'requirement_id' => $requirement->id,
                'requirement_name' => $requirement->document_name,
                'uploaded' => $uploadedDoc ? true : false,
                'original_filename' => $uploadedDoc ? $uploadedDoc->original_filename : null,
                'file_size' => $uploadedDoc ? $uploadedDoc->file_size : null,
                'uploaded_at' => $uploadedDoc ? $uploadedDoc->created_at : null,
            ];
        });

        return response()->json([
            'documents' => $documents,
            'total_requirements' => $requirements->count(),
            'uploaded_count' => $submission->documents->count(),
        ]);
    }
}