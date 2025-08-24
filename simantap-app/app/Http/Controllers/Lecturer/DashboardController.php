<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\ExamSubmission;
use App\Models\Student;
use App\Models\ExamType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $lecturer = Auth::guard('lecturer')->user();
        
        // Statistics for lecturer's study program
        $totalSubmissions = ExamSubmission::whereHas('student', function($query) use ($lecturer) {
            $query->where('study_program', $lecturer->study_program);
        })->count();
        
        $pendingSubmissions = ExamSubmission::whereHas('student', function($query) use ($lecturer) {
            $query->where('study_program', $lecturer->study_program);
        })->where('status', 'menunggu_verifikasi')->count();
        
        $acceptedSubmissions = ExamSubmission::whereHas('student', function($query) use ($lecturer) {
            $query->where('study_program', $lecturer->study_program);
        })->where('status', 'berkas_diterima')->count();
        
        $rejectedSubmissions = ExamSubmission::whereHas('student', function($query) use ($lecturer) {
            $query->where('study_program', $lecturer->study_program);
        })->where('status', 'berkas_ditolak')->count();

        $totalStudents = Student::where('study_program', $lecturer->study_program)->count();

        // Recent submissions for lecturer's study program
        $recentSubmissions = ExamSubmission::with(['student', 'examType'])
            ->whereHas('student', function($query) use ($lecturer) {
                $query->where('study_program', $lecturer->study_program);
            })
            ->latest()
            ->take(10)
            ->get();

        // Submissions by exam type for lecturer's study program
        $submissionsByType = ExamSubmission::with('examType')
            ->whereHas('student', function($query) use ($lecturer) {
                $query->where('study_program', $lecturer->study_program);
            })
            ->selectRaw('exam_type_id, count(*) as total')
            ->groupBy('exam_type_id')
            ->get();

        // Submissions by status for lecturer's study program
        $submissionsByStatus = ExamSubmission::whereHas('student', function($query) use ($lecturer) {
            $query->where('study_program', $lecturer->study_program);
        })
        ->selectRaw('status, count(*) as total')
        ->groupBy('status')
        ->get();

        return view('lecturer.dashboard.index', compact(
            'lecturer',
            'totalSubmissions',
            'pendingSubmissions',
            'acceptedSubmissions',
            'rejectedSubmissions',
            'totalStudents',
            'recentSubmissions',
            'submissionsByType',
            'submissionsByStatus'
        ));
    }
}
