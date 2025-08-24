<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionDocument extends Model
{
    protected $fillable = [
        'exam_submission_id',
        'exam_requirement_id',
        'document_name',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'status',
        'rejection_reason'
    ];

    protected $casts = [
        'file_size' => 'integer'
    ];

    // Relasi dengan exam submission
    public function examSubmission()
    {
        return $this->belongsTo(ExamSubmission::class);
    }

    // Relasi dengan exam requirement
    public function examRequirement()
    {
        return $this->belongsTo(ExamRequirement::class);
    }

    // Scope untuk documents berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk documents yang diupload
    public function scopeUploaded($query)
    {
        return $query->where('status', 'uploaded');
    }

    // Scope untuk documents yang diverifikasi
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    // Scope untuk documents yang ditolak
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Get file URL
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    // Get file size in human readable format
    public function getFileSizeHumanAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
