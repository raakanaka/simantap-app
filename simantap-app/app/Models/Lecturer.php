<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Lecturer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'nip',
        'study_program',
        'faculty',
        'position',
        'status',
        'phone',
        'address',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'last_login_at' => 'datetime',
    ];

    public function verifiedSubmissions()
    {
        return $this->hasMany(ExamSubmission::class, 'verified_by');
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isHeadOfProgram()
    {
        return $this->position === 'Ketua Program Studi';
    }

    public function isDean()
    {
        return $this->position === 'Dekan';
    }
}
