<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Authenticatable
{
    use Notifiable, HasFactory;

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
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi dengan exam submissions
    public function examSubmissions()
    {
        return $this->hasMany(ExamSubmission::class);
    }

    // Get username untuk authentication
    public function getUsernameAttribute()
    {
        return $this->nim;
    }
}
