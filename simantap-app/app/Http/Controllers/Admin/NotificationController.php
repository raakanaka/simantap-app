<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamSubmission;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = \App\Models\Notification::where('notifiable_type', 'App\Models\Student')
            ->latest()
            ->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function sendToStudent(Request $request, $submissionId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'type' => 'required|in:info,warning,success,danger',
        ]);

        $submission = ExamSubmission::with('student')->findOrFail($submissionId);
        
        // Create notification for student
        $submission->student->notify(new \App\Notifications\AdminNotification(
            $request->message,
            $request->type,
            Auth::guard('admin')->user()->name
        ));

        return redirect()->back()
            ->with('success', 'Notifikasi berhasil dikirim kepada mahasiswa!');
    }

    public function sendBulkNotification(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'message' => 'required|string|max:1000',
            'type' => 'required|in:info,warning,success,danger',
        ]);

        $students = Student::whereIn('id', $request->student_ids)->get();
        
        foreach ($students as $student) {
            $student->notify(new \App\Notifications\AdminNotification(
                $request->message,
                $request->type,
                Auth::guard('admin')->user()->name
            ));
        }

        return redirect()->back()
            ->with('success', 'Notifikasi berhasil dikirim kepada ' . $students->count() . ' mahasiswa!');
    }

    public function markAsRead($id)
    {
        $notification = \App\Models\Notification::findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()
            ->with('success', 'Notifikasi ditandai sebagai telah dibaca!');
    }

    public function markAllAsRead()
    {
        \App\Models\Notification::where('notifiable_type', 'App\Models\Student')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()->back()
            ->with('success', 'Semua notifikasi ditandai sebagai telah dibaca!');
    }
}
