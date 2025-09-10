<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    protected $fillable = [
        'code',
        'name',
        'faculty',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationship with students
    public function students()
    {
        return $this->hasMany(Student::class, 'study_program', 'name');
    }

    // Relationship with lecturers
    public function lecturers()
    {
        return $this->hasMany(Lecturer::class);
    }
}
