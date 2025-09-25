<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutMe extends Model
{
    protected $table = 'about_me';

    protected $fillable = [
        'name',
        'title',
        'bio',
        'photo',
        'email',
        'phone',
        'location',
        'social_links',
        'resume_url'
    ];

    protected $casts = [
        'social_links' => 'array'
    ];
}
