<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    // Relasi dengan exam requirements
    public function requirements()
    {
        return $this->hasMany(ExamRequirement::class);
    }

    // Relasi dengan exam submissions
    public function submissions()
    {
        return $this->hasMany(ExamSubmission::class);
    }

    // Scope untuk exam types yang aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
