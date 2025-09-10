<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'role',
        'phone',
        'address',
        'status',
    ];

    protected $hidden = [
        'password',
    ];
}
