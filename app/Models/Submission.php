<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    protected $fillable = [
        'submission_number',
        'student_nim',
        'student_name',
        'student_study_program',
        'exam_type_id',
        'exam_type_name',
        'title',
        'description',
        'status',
        'submitted_at',
        'revision_reason',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_nim', 'nim');
    }

    public function examType(): BelongsTo
    {
        return $this->belongsTo(ExamType::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(SubmissionDocument::class);
    }
}
