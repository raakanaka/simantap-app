<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $fillable = [
        'nip',
        'password',
        'name',
        'email',
        'expertise',
        'position',
        'status',
        'phone',
        'address',
        'study_program_id',
    ];

    protected $hidden = [
        'password',
    ];

    // Relationship with study program
    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }
}
