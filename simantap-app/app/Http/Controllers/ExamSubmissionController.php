<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ExamType;
use App\Models\ExamSubmission;
use App\Models\SubmissionDocument;
use App\Models\ExamRequirement;

class ExamSubmissionController extends Controller
{
    public function create($examTypeId)
    {
        $examType = ExamType::with('requirements')->findOrFail($examTypeId);
        return view('submissions.create', compact('examType'));
    }

    public function store(Request $request, $examTypeId)
    {
        $request->validate([
            'documents.*' => 'required|file|max:20480', // Max 20MB
        ]);

        $examType = ExamType::with('requirements')->findOrFail($examTypeId);
        $student = Auth::user();

        // Generate submission number
        $submissionNumber = 'SUB-' . date('Ymd') . '-' . str_pad(ExamSubmission::count() + 1, 4, '0', STR_PAD_LEFT);

        // Create exam submission
        $submission = ExamSubmission::create([
            'student_id' => $student->id,
            'exam_type_id' => $examTypeId,
            'submission_number' => $submissionNumber,
            'status' => 'menunggu_verifikasi',
            'submitted_at' => now(),
        ]);

        // Upload documents
        foreach ($request->file('documents', []) as $requirementId => $file) {
            $requirement = ExamRequirement::find($requirementId);
            
            if ($requirement && $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('submissions/' . $submission->id, $fileName, 'public');

                SubmissionDocument::create([
                    'exam_submission_id' => $submission->id,
                    'exam_requirement_id' => $requirementId,
                    'document_name' => $requirement->document_name,
                    'file_path' => $filePath,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                    'status' => 'uploaded',
                ]);
            }
        }

        return redirect()->route('submissions.show', $submission->id)
            ->with('success', 'Pengajuan berhasil disubmit!');
    }

    public function show($id)
    {
        $submission = ExamSubmission::with(['examType', 'documents.examRequirement'])
            ->where('student_id', Auth::id())
            ->findOrFail($id);

        return view('submissions.show', compact('submission'));
    }

    public function index()
    {
        $submissions = ExamSubmission::with('examType')
            ->where('student_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('submissions.index', compact('submissions'));
    }

    public function edit($id)
    {
        $submission = ExamSubmission::with(['examType', 'documents.examRequirement'])
            ->where('student_id', Auth::id())
            ->where('status', 'berkas_ditolak')
            ->findOrFail($id);

        return view('submissions.edit', compact('submission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'documents.*' => 'nullable|file|max:20480',
        ]);

        $submission = ExamSubmission::where('student_id', Auth::id())
            ->where('status', 'berkas_ditolak')
            ->findOrFail($id);

        // Update existing documents or upload new ones
        foreach ($request->file('documents', []) as $requirementId => $file) {
            if ($file) {
                $requirement = ExamRequirement::find($requirementId);
                
                // Delete old document if exists
                $oldDocument = SubmissionDocument::where('exam_submission_id', $submission->id)
                    ->where('exam_requirement_id', $requirementId)
                    ->first();

                if ($oldDocument) {
                    Storage::disk('public')->delete($oldDocument->file_path);
                    $oldDocument->delete();
                }

                // Upload new document
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('submissions/' . $submission->id, $fileName, 'public');

                SubmissionDocument::create([
                    'exam_submission_id' => $submission->id,
                    'exam_requirement_id' => $requirementId,
                    'document_name' => $requirement->document_name,
                    'file_path' => $filePath,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                    'status' => 'uploaded',
                ]);
            }
        }

        // Update submission status
        $submission->update([
            'status' => 'menunggu_verifikasi',
            'revision_reason' => null,
            'submitted_at' => now(),
        ]);

        return redirect()->route('submissions.show', $submission->id)
            ->with('success', 'Pengajuan berhasil diperbarui!');
    }
}
