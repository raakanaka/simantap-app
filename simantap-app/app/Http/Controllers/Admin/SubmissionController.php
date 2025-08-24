<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamSubmission;
use App\Models\ExamType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = ExamSubmission::with(['student', 'examType', 'documents.examRequirement']);

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

        return view('admin.submissions.index', compact('submissions', 'examTypes'));
    }

    public function show($id)
    {
        $submission = ExamSubmission::with(['student', 'examType', 'documents.examRequirement', 'verifier'])
            ->findOrFail($id);

        return view('admin.submissions.show', compact('submission'));
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:berkas_diterima,berkas_ditolak',
            'revision_reason' => 'required_if:status,berkas_ditolak|nullable|string',
            'notes' => 'nullable|string',
        ]);

        $submission = ExamSubmission::findOrFail($id);
        
        $submission->update([
            'status' => $request->status,
            'revision_reason' => $request->revision_reason,
            'notes' => $request->notes,
            'verified_at' => now(),
            'verified_by' => Auth::guard('admin')->id(),
        ]);

        // Update document statuses
        if ($request->status === 'berkas_diterima') {
            $submission->documents()->update(['status' => 'verified']);
        } else {
            $submission->documents()->update(['status' => 'rejected']);
        }

        $statusMessage = $request->status === 'berkas_diterima' ? 'Pengajuan berhasil diverifikasi dan diterima!' : 'Pengajuan ditolak dengan alasan revisi.';

        return redirect()->route('admin.submissions.show', $submission->id)
            ->with('success', $statusMessage);
    }

    public function export(Request $request)
    {
        $query = ExamSubmission::with(['student', 'examType']);

        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('exam_type_id') && $request->exam_type_id !== '') {
            $query->where('exam_type_id', $request->exam_type_id);
        }

        $submissions = $query->latest()->get();

        // Generate CSV
        $filename = 'laporan_pengajuan_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($submissions) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'No. Pengajuan',
                'NIM',
                'Nama Mahasiswa',
                'Jenis Ujian',
                'Status',
                'Tanggal Submit',
                'Tanggal Verifikasi',
                'Verifikator',
                'Catatan'
            ]);

            // CSV Data
            foreach ($submissions as $submission) {
                fputcsv($file, [
                    $submission->submission_number,
                    $submission->student->nim,
                    $submission->student->name,
                    $submission->examType->name,
                    $submission->status,
                    $submission->submitted_at?->format('d/m/Y H:i'),
                    $submission->verified_at?->format('d/m/Y H:i'),
                    $submission->verifier?->name ?? '-',
                    $submission->notes ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
