<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Student;
use App\Models\ExamType;
use Illuminate\Support\Facades\Session;

class LecturerController extends Controller
{
    public function dashboard()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'lecturer') {
            return redirect()->route('auth.login');
        }

        $lecturer = \App\Models\Lecturer::find(Session::get('user_id'));
        
        // Get statistics
        $totalSubmissions = Submission::count();
        $pendingSubmissions = Submission::where('status', 'menunggu_verifikasi')->count();
        $approvedSubmissions = Submission::where('status', 'berkas_diterima')->count();
        $rejectedSubmissions = Submission::where('status', 'berkas_ditolak')->count();
        
        return view('lecturer.dashboard', compact('lecturer', 'totalSubmissions', 'pendingSubmissions', 'approvedSubmissions', 'rejectedSubmissions'));
    }

    public function submissions(Request $request)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'lecturer') {
            return redirect()->route('auth.login');
        }

        $query = Submission::with(['student', 'examType', 'documents']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by exam type
        if ($request->filled('exam_type')) {
            $query->where('exam_type_id', $request->exam_type);
        }

        // Search by student name or NIM
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('student_name', 'like', "%{$searchTerm}%")
                  ->orWhere('student_nim', 'like', "%{$searchTerm}%")
                  ->orWhere('title', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $submissions = $query->orderBy('created_at', 'desc')->get();
        
        // Get exam types for filter dropdown
        $examTypes = ExamType::where('status', 'active')->orderBy('name')->get();

        return view('lecturer.submissions', compact('submissions', 'examTypes'));
    }

    public function status()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'lecturer') {
            return redirect()->route('auth.login');
        }

        $submissions = Submission::with(['student', 'examType'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingSubmissions = $submissions->where('status', 'menunggu_verifikasi');
        $approvedSubmissions = $submissions->where('status', 'berkas_diterima');
        $rejectedSubmissions = $submissions->where('status', 'berkas_ditolak');

        return view('lecturer.status', compact('submissions', 'pendingSubmissions', 'approvedSubmissions', 'rejectedSubmissions'));
    }

    public function tasks()
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'lecturer') {
            return redirect()->route('auth.login');
        }

        $submissions = Submission::with(['student', 'examType'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingSubmissions = $submissions->where('status', 'menunggu_verifikasi');
        $rejectedSubmissions = $submissions->where('status', 'berkas_ditolak');
        $approvedSubmissions = $submissions->where('status', 'berkas_diterima');

        return view('lecturer.tasks', compact('submissions', 'pendingSubmissions', 'rejectedSubmissions', 'approvedSubmissions'));
    }

    public function verifySubmission(Request $request, $id)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'lecturer') {
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
        if (!Session::has('user_id') || Session::get('user_type') !== 'lecturer') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'revision_reason' => 'required|string|max:500'
        ]);

        $submission = Submission::findOrFail($id);
        $submission->status = 'berkas_ditolak';
        $submission->revision_reason = $request->revision_reason;
        $submission->verified_by = Session::get('user_name');
        $submission->verified_at = now();
        $submission->save();

        return redirect()->back()->with('success', 'Pengajuan berhasil ditolak!');
    }

    public function bulkApprove(Request $request)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'lecturer') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'submission_ids' => 'required|array|min:1',
            'submission_ids.*' => 'exists:submissions,id'
        ]);

        $submissionIds = $request->submission_ids;
        $approvedCount = 0;

        foreach ($submissionIds as $id) {
            $submission = Submission::find($id);
            if ($submission && $submission->status === 'menunggu_verifikasi') {
                $submission->status = 'berkas_diterima';
                $submission->verified_by = Session::get('user_name');
                $submission->verified_at = now();
                $submission->save();
                $approvedCount++;
            }
        }

        return redirect()->back()->with('success', "Berhasil menyetujui {$approvedCount} pengajuan!");
    }

    public function bulkReject(Request $request)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'lecturer') {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'submission_ids' => 'required|array|min:1',
            'submission_ids.*' => 'exists:submissions,id',
            'revision_reason' => 'required|string|max:500'
        ]);

        $submissionIds = $request->submission_ids;
        $rejectedCount = 0;

        foreach ($submissionIds as $id) {
            $submission = Submission::find($id);
            if ($submission && $submission->status === 'menunggu_verifikasi') {
                $submission->status = 'berkas_ditolak';
                $submission->revision_reason = $request->revision_reason;
                $submission->verified_by = Session::get('user_name');
                $submission->verified_at = now();
                $submission->save();
                $rejectedCount++;
            }
        }

        return redirect()->back()->with('success', "Berhasil menolak {$rejectedCount} pengajuan!");
    }

    public function downloadDocument($submissionId, $documentId)
    {
        // Check authentication
        if (!Session::has('user_id') || Session::get('user_type') !== 'lecturer') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $submission = Submission::findOrFail($submissionId);
            $document = $submission->documents()->findOrFail($documentId);
            
            // File disimpan di storage/app/private/submissions/{id}/filename
            // Karena disk 'local' mengarah ke storage/app/private
            $filePath = storage_path('app/private/' . $document->file_path);
            
            \Log::info('Lecturer trying to download file: ' . $filePath);
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
        if (!Session::has('user_id') || Session::get('user_type') !== 'lecturer') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $submission = Submission::with(['documents.requirement'])->findOrFail($submissionId);
            $documents = $submission->documents->map(function($doc) {
                return [
                    'id' => $doc->id,
                    'original_filename' => $doc->original_filename,
                    'file_path' => $doc->file_path,
                    'file_size' => $doc->file_size,
                    'mime_type' => $doc->mime_type,
                    'requirement_name' => $doc->requirement ? $doc->requirement->document_name : 'Unknown',
                    'uploaded_at' => $doc->created_at->format('d/m/Y H:i')
                ];
            });

            return response()->json([
                'success' => true,
                'documents' => $documents
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting submission documents: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil data dokumen: ' . $e->getMessage()], 500);
        }
    }
}