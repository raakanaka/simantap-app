<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'nim',
        'password',
        'name',
        'email',
        'study_program',
        'faculty',
        'semester',
        'phone',
        'address',
        'status',
        'is_verified',
        'verified_by',
        'verified_at',
        'registration_date',
        'ktm_file',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'registration_date' => 'datetime',
    ];

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'student_nim', 'nim');
    }
}
