<?php

namespace App\Services;

use App\Models\ExamSubmission;
use App\Models\SubmissionDocument;
use App\Models\ExamRequirement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ExamSubmissionService
{
    /**
     * Create a new exam submission
     */
    public function createSubmission($studentId, $examTypeId, $documents)
    {
        // Generate submission number
        $submissionNumber = $this->generateSubmissionNumber();

        // Create exam submission
        $submission = ExamSubmission::create([
            'student_id' => $studentId,
            'exam_type_id' => $examTypeId,
            'submission_number' => $submissionNumber,
            'status' => 'menunggu_verifikasi',
            'submitted_at' => now(),
        ]);

        // Upload documents
        $this->uploadDocuments($submission, $documents);

        return $submission;
    }

    /**
     * Update an existing exam submission
     */
    public function updateSubmission($submission, $documents)
    {
        // Upload new documents
        $this->uploadDocuments($submission, $documents);

        // Update submission status
        $submission->update([
            'status' => 'menunggu_verifikasi',
            'revision_reason' => null,
            'submitted_at' => now(),
        ]);

        return $submission;
    }

    /**
     * Upload documents for a submission
     */
    private function uploadDocuments($submission, $documents)
    {
        foreach ($documents as $requirementId => $file) {
            if ($file instanceof UploadedFile) {
                $requirement = ExamRequirement::find($requirementId);
                
                if ($requirement) {
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
        }
    }

    /**
     * Generate unique submission number
     */
    private function generateSubmissionNumber()
    {
        $date = date('Ymd');
        $count = ExamSubmission::whereDate('created_at', today())->count() + 1;
        
        return 'SUB-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Verify submission (for admin/dosen)
     */
    public function verifySubmission($submission, $status, $revisionReason = null, $verifiedBy = null)
    {
        $submission->update([
            'status' => $status,
            'revision_reason' => $revisionReason,
            'verified_at' => now(),
            'verified_by' => $verifiedBy,
        ]);

        return $submission;
    }

    /**
     * Get submission statistics for a student
     */
    public function getStudentStatistics($studentId)
    {
        $submissions = ExamSubmission::where('student_id', $studentId)->get();

        return [
            'total' => $submissions->count(),
            'pending' => $submissions->where('status', 'menunggu_verifikasi')->count(),
            'accepted' => $submissions->where('status', 'berkas_diterima')->count(),
            'rejected' => $submissions->where('status', 'berkas_ditolak')->count(),
        ];
    }
}
