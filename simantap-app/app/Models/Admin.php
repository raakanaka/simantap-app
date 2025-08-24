<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'role',
        'phone',
        'address',
        'status',
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

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }
}
