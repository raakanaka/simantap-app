<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormulirPendaftaran extends Model
{
    protected $fillable = [
        'submission_id',
        'student_nim',
        'student_name',
        'place_of_birth',
        'date_of_birth',
        'semester',
        'study_program',
        'phone_number',
        'thesis_title',
        'supervisor',
        'document_status',
        'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'document_status' => 'array'
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id', 'id');
    }
}
