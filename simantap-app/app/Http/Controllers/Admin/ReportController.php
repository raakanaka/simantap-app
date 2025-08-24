<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamSubmission;
use App\Models\ExamType;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalSubmissions = ExamSubmission::count();
        $pendingSubmissions = ExamSubmission::where('status', 'menunggu_verifikasi')->count();
        $acceptedSubmissions = ExamSubmission::where('status', 'berkas_diterima')->count();
        $rejectedSubmissions = ExamSubmission::where('status', 'berkas_ditolak')->count();

        $submissionsByType = ExamSubmission::with('examType')
            ->selectRaw('exam_type_id, count(*) as total')
            ->groupBy('exam_type_id')
            ->get();

        $submissionsByStatus = ExamSubmission::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->get();

        $recentSubmissions = ExamSubmission::with(['student', 'examType'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.index', compact(
            'totalSubmissions',
            'pendingSubmissions',
            'acceptedSubmissions',
            'rejectedSubmissions',
            'submissionsByType',
            'submissionsByStatus',
            'recentSubmissions'
        ));
    }

    public function accepted()
    {
        $submissions = ExamSubmission::with(['student', 'examType', 'verifier'])
            ->where('status', 'berkas_diterima')
            ->latest()
            ->paginate(15);

        return view('admin.reports.accepted', compact('submissions'));
    }

    public function rejected()
    {
        $submissions = ExamSubmission::with(['student', 'examType', 'verifier'])
            ->where('status', 'berkas_ditolak')
            ->latest()
            ->paginate(15);

        return view('admin.reports.rejected', compact('submissions'));
    }

    public function pending()
    {
        $submissions = ExamSubmission::with(['student', 'examType'])
            ->where('status', 'menunggu_verifikasi')
            ->latest()
            ->paginate(15);

        return view('admin.reports.pending', compact('submissions'));
    }

    public function exportAccepted()
    {
        $submissions = ExamSubmission::with(['student', 'examType', 'verifier'])
            ->where('status', 'berkas_diterima')
            ->latest()
            ->get();

        return $this->exportToCSV($submissions, 'laporan_pengajuan_diterima');
    }

    public function exportRejected()
    {
        $submissions = ExamSubmission::with(['student', 'examType', 'verifier'])
            ->where('status', 'berkas_ditolak')
            ->latest()
            ->get();

        return $this->exportToCSV($submissions, 'laporan_pengajuan_ditolak');
    }

    public function exportPending()
    {
        $submissions = ExamSubmission::with(['student', 'examType'])
            ->where('status', 'menunggu_verifikasi')
            ->latest()
            ->get();

        return $this->exportToCSV($submissions, 'laporan_pengajuan_menunggu');
    }

    public function exportAll(Request $request)
    {
        $query = ExamSubmission::with(['student', 'examType', 'verifier']);

        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('exam_type_id') && $request->exam_type_id !== '') {
            $query->where('exam_type_id', $request->exam_type_id);
        }

        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }

        $submissions = $query->latest()->get();

        return $this->exportToCSV($submissions, 'laporan_pengajuan_lengkap');
    }

    private function exportToCSV($submissions, $filename)
    {
        $filename = $filename . '_' . date('Y-m-d_H-i-s') . '.csv';
        
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
                'Program Studi',
                'Jenis Ujian',
                'Status',
                'Tanggal Submit',
                'Tanggal Verifikasi',
                'Verifikator',
                'Alasan Revisi',
                'Catatan'
            ]);

            // CSV Data
            foreach ($submissions as $submission) {
                fputcsv($file, [
                    $submission->submission_number,
                    $submission->student->nim,
                    $submission->student->name,
                    $submission->student->study_program,
                    $submission->examType->name,
                    $submission->status,
                    $submission->submitted_at?->format('d/m/Y H:i'),
                    $submission->verified_at?->format('d/m/Y H:i'),
                    $submission->verifier?->name ?? '-',
                    $submission->revision_reason ?? '-',
                    $submission->notes ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
