<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamSubmission;
use App\Models\Student;
use App\Models\ExamType;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalSubmissions = ExamSubmission::count();
        $pendingSubmissions = ExamSubmission::where('status', 'menunggu_verifikasi')->count();
        $acceptedSubmissions = ExamSubmission::where('status', 'berkas_diterima')->count();
        $rejectedSubmissions = ExamSubmission::where('status', 'berkas_ditolak')->count();
        
        $totalStudents = Student::count();
        $totalExamTypes = ExamType::count();

        // Recent submissions
        $recentSubmissions = ExamSubmission::with(['student', 'examType'])
            ->latest()
            ->take(10)
            ->get();

        // Submissions by exam type
        $submissionsByType = ExamSubmission::with('examType')
            ->selectRaw('exam_type_id, count(*) as total')
            ->groupBy('exam_type_id')
            ->get();

        // Submissions by status
        $submissionsByStatus = ExamSubmission::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->get();

        return view('admin.dashboard.index', compact(
            'totalSubmissions',
            'pendingSubmissions',
            'acceptedSubmissions',
            'rejectedSubmissions',
            'totalStudents',
            'totalExamTypes',
            'recentSubmissions',
            'submissionsByType',
            'submissionsByStatus'
        ));
    }
}
