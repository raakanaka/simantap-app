<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function examType(): BelongsTo
    {
        return $this->belongsTo(ExamType::class);
    }

    public function submissionDocuments(): HasMany
    {
        return $this->hasMany(SubmissionDocument::class, 'requirement_id');
    }
}
