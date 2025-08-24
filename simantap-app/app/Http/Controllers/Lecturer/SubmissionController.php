<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\ExamSubmission;
use App\Models\ExamType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $lecturer = Auth::guard('lecturer')->user();
        
        $query = ExamSubmission::with(['student', 'examType', 'documents.examRequirement'])
            ->whereHas('student', function($query) use ($lecturer) {
                $query->where('study_program', $lecturer->study_program);
            });

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by exam type
        if ($request->has('exam_type_id') && $request->exam_type_id !== '') {
            $query->where('exam_type_id', $request->exam_type_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }

        $submissions = $query->latest()->paginate(15);
        $examTypes = ExamType::all();

        return view('lecturer.submissions.index', compact('submissions', 'examTypes', 'lecturer'));
    }

    public function show($id)
    {
        $lecturer = Auth::guard('lecturer')->user();
        
        $submission = ExamSubmission::with(['student', 'examType', 'documents.examRequirement', 'verifier'])
            ->whereHas('student', function($query) use ($lecturer) {
                $query->where('study_program', $lecturer->study_program);
            })
            ->findOrFail($id);

        return view('lecturer.submissions.show', compact('submission', 'lecturer'));
    }

    public function verify(Request $request, $id)
    {
        $lecturer = Auth::guard('lecturer')->user();
        
        $request->validate([
            'status' => 'required|in:berkas_diterima,berkas_ditolak',
            'revision_reason' => 'required_if:status,berkas_ditolak|nullable|string',
            'notes' => 'nullable|string',
        ]);

        $submission = ExamSubmission::whereHas('student', function($query) use ($lecturer) {
            $query->where('study_program', $lecturer->study_program);
        })->findOrFail($id);
        
        $submission->update([
            'status' => $request->status,
            'revision_reason' => $request->revision_reason,
            'notes' => $request->notes,
            'verified_at' => now(),
            'verified_by' => $lecturer->id,
        ]);

        // Update document statuses
        if ($request->status === 'berkas_diterima') {
            $submission->documents()->update(['status' => 'verified']);
        } else {
            $submission->documents()->update(['status' => 'rejected']);
        }

        $statusMessage = $request->status === 'berkas_diterima' ? 'Pengajuan berhasil diverifikasi dan diterima!' : 'Pengajuan ditolak dengan alasan revisi.';

        return redirect()->route('lecturer.submissions.show', $submission->id)
            ->with('success', $statusMessage);
    }

    public function tasks()
    {
        $lecturer = Auth::guard('lecturer')->user();
        
        // Get pending submissions that need verification
        $pendingTasks = ExamSubmission::with(['student', 'examType'])
            ->whereHas('student', function($query) use ($lecturer) {
                $query->where('study_program', $lecturer->study_program);
            })
            ->where('status', 'menunggu_verifikasi')
            ->latest()
            ->paginate(15);

        return view('lecturer.tasks.index', compact('pendingTasks', 'lecturer'));
    }

    public function status()
    {
        $lecturer = Auth::guard('lecturer')->user();
        
        // Get all submissions with their status
        $submissions = ExamSubmission::with(['student', 'examType', 'verifier'])
            ->whereHas('student', function($query) use ($lecturer) {
                $query->where('study_program', $lecturer->study_program);
            })
            ->latest()
            ->paginate(15);

        return view('lecturer.submissions.status', compact('submissions', 'lecturer'));
    }
}
