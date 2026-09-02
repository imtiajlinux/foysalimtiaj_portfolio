<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'title',
        'email',
        'phone',
        'date_of_birth',
        'profile_photo',
        'cover_image',
        'cv_file',
        'website',
        'short_bio',
        'about',
        'current_address',
        'permanent_address',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
    ];
}
