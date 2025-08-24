<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamRequirement extends Model
{
    protected $fillable = [
        'exam_type_id',
        'document_name',
        'description',
        'is_required',
        'file_types',
        'max_size',
        'order',
        'status'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'max_size' => 'integer',
        'order' => 'integer'
    ];

    // Relasi dengan exam type
    public function examType()
    {
        return $this->belongsTo(ExamType::class);
    }

    // Relasi dengan submission documents
    public function submissionDocuments()
    {
        return $this->hasMany(SubmissionDocument::class);
    }

    // Scope untuk requirements yang aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope untuk requirements yang wajib
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }
}
