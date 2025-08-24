<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSubmission extends Model
{
    protected $fillable = [
        'student_id',
        'exam_type_id',
        'submission_number',
        'status',
        'revision_reason',
        'notes',
        'submitted_at',
        'verified_at',
        'verified_by'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime'
    ];

    // Relasi dengan student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi dengan exam type
    public function examType()
    {
        return $this->belongsTo(ExamType::class);
    }

    // Relasi dengan submission documents
    public function documents()
    {
        return $this->hasMany(SubmissionDocument::class);
    }

    // Relasi dengan admin yang memverifikasi
    public function verifier()
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }

    // Scope untuk submissions berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk submissions yang menunggu verifikasi
    public function scopePending($query)
    {
        return $query->where('status', 'menunggu_verifikasi');
    }

    // Scope untuk submissions yang diterima
    public function scopeAccepted($query)
    {
        return $query->where('status', 'berkas_diterima');
    }

    // Scope untuk submissions yang ditolak
    public function scopeRejected($query)
    {
        return $query->where('status', 'berkas_ditolak');
    }
}
