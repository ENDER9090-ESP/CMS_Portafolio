<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'url',
        'image',
        'start_date',
        'end_date',
        'status'
    ];

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'project_tools')
            ->withPivot('specific_use')
            ->withTimestamps();
    }
}