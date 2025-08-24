<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\ExamType;
use App\Models\ExamSubmission;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $examTypes = ExamType::active()->get();
        $submissions = $student->examSubmissions()->with('examType')->latest()->get();
        
        return view('dashboard.index', compact('student', 'examTypes', 'submissions'));
    }

    public function showExamTypes()
    {
        $examTypes = ExamType::active()->get();
        return view('dashboard.exam-types', compact('examTypes'));
    }

    public function showRequirements($examTypeId)
    {
        $examType = ExamType::with('requirements')->findOrFail($examTypeId);
        return view('dashboard.requirements', compact('examType'));
    }
}
