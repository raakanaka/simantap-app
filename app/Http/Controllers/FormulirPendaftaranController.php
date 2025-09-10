<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormulirPendaftaran;
use App\Models\Submission;
use App\Models\Student;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class FormulirPendaftaranController extends Controller
{

    public function downloadFormulir($submissionId)
    {
        // Check authentication for student
        if (!Session::has('user_id') || Session::get('user_type') !== 'student') {
            return redirect()->route('auth.login');
        }

        try {
            // Get submission data with student info, exam type, and requirements
            $submission = Submission::with(['student', 'documents', 'examType', 'documents.requirement'])->findOrFail($submissionId);
            
            // Check if submission is approved
            if ($submission->status !== 'berkas_diterima') {
                return redirect()->back()->with('error', 'Pengajuan belum disetujui.');
            }

            // Get exam requirements for this submission
            $requirements = \App\Models\ExamRequirement::where('exam_type_id', $submission->exam_type_id)
                ->where('is_required', true)
                ->orderBy('order')
                ->get();

            // Create formulir data with real student data and exam type
            $formulir = (object) [
                'student_name' => $submission->student_name,
                'student_nim' => $submission->student_nim,
                'place_of_birth' => $submission->student->place_of_birth ?? 'Belum diisi',
                'date_of_birth' => $submission->student->date_of_birth ? \Carbon\Carbon::parse($submission->student->date_of_birth)->format('d F Y') : 'Belum diisi',
                'semester' => '8',
                'study_program' => $submission->student_study_program ?? 'Belum diisi',
                'phone_number' => $submission->student->phone ?? 'Belum diisi',
                'thesis_title' => $submission->title ?? 'Belum diisi',
                'journal_name' => 'Belum diisi',
                'supervisor' => $submission->supervisor_name ?? 'Belum ditentukan',
                'current_date' => now()->format('d F Y'),
                'secretary_name' => 'M. Fachran Haikal, STP., MM',
                'secretary_nip' => '198002272009121004',
                'exam_type' => $submission->examType,
                'requirements' => $requirements,
                'submission' => $submission
            ];

            // Generate PDF using DomPDF with proper template based on exam type
            $pdf = Pdf::loadView('formulir.dynamic', ['formulir' => $formulir]);
            $pdf->setPaper('A4', 'portrait');
            
            $filename = 'Formulir_' . str_replace(' ', '_', $submission->examType->name) . '_' . $submission->student_nim . '_' . now()->format('Y-m-d') . '.pdf';
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat generate formulir.');
        }
    }


}