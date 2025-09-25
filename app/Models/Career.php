<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'institution',
        'type', // education/work
        'start_date',
        'end_date',
        'description',
        'achievements',
        'location'
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'achievements' => 'array'
    ];
}