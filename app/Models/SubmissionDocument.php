<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionDocument extends Model
{
    protected $fillable = [
        'submission_id',
        'requirement_id',
        'original_filename',
        'stored_filename',
        'file_path',
        'file_size',
        'mime_type',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(ExamRequirement::class, 'requirement_id');
    }
}
