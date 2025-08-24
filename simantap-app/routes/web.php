<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamSubmissionController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SubmissionController as AdminSubmissionController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/exam-types', [DashboardController::class, 'showExamTypes'])->name('exam-types');
    Route::get('/exam-types/{examType}/requirements', [DashboardController::class, 'showRequirements'])->name('requirements');

    // Exam Submissions
    Route::get('/submissions', [ExamSubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/create/{examType}', [ExamSubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submissions/{examType}', [ExamSubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/submissions/{submission}', [ExamSubmissionController::class, 'show'])->name('submissions.show');
    Route::get('/submissions/{submission}/edit', [ExamSubmissionController::class, 'edit'])->name('submissions.edit');
    Route::put('/submissions/{submission}', [ExamSubmissionController::class, 'update'])->name('submissions.update');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    // Admin Authentication
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Protected Admin Routes
    Route::middleware('admin.auth')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Admin Submissions Management
        Route::get('/submissions', [AdminSubmissionController::class, 'index'])->name('admin.submissions.index');
        Route::get('/submissions/{submission}', [AdminSubmissionController::class, 'show'])->name('admin.submissions.show');
        Route::post('/submissions/{submission}/verify', [AdminSubmissionController::class, 'verify'])->name('admin.submissions.verify');
        Route::get('/submissions/export', [AdminSubmissionController::class, 'export'])->name('admin.submissions.export');

        // Admin Profile Management
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('admin.profile.index');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::put('/profile/password', [AdminProfileController::class, 'changePassword'])->name('admin.profile.password');

        // Admin Notifications
        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
        Route::post('/notifications/send/{submission}', [AdminNotificationController::class, 'sendToStudent'])->name('admin.notifications.send');
        Route::post('/notifications/bulk', [AdminNotificationController::class, 'sendBulkNotification'])->name('admin.notifications.bulk');
        Route::put('/notifications/{notification}/read', [AdminNotificationController::class, 'markAsRead'])->name('admin.notifications.read');
        Route::put('/notifications/read-all', [AdminNotificationController::class, 'markAllAsRead'])->name('admin.notifications.readAll');

        // Admin Reports
        Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/reports/accepted', [AdminReportController::class, 'accepted'])->name('admin.reports.accepted');
        Route::get('/reports/rejected', [AdminReportController::class, 'rejected'])->name('admin.reports.rejected');
        Route::get('/reports/pending', [AdminReportController::class, 'pending'])->name('admin.reports.pending');
        Route::get('/reports/export/accepted', [AdminReportController::class, 'exportAccepted'])->name('admin.reports.exportAccepted');
        Route::get('/reports/export/rejected', [AdminReportController::class, 'exportRejected'])->name('admin.reports.exportRejected');
        Route::get('/reports/export/pending', [AdminReportController::class, 'exportPending'])->name('admin.reports.exportPending');
        Route::get('/reports/export/all', [AdminReportController::class, 'exportAll'])->name('admin.reports.exportAll');
    });
});
