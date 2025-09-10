<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamType extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
    ];

    public function requirements(): HasMany
    {
        return $this->hasMany(ExamRequirement::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
