<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'icon',
        'proficiency_level'
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_tools')
            ->withPivot('specific_use')
            ->withTimestamps();
    }

    public function certificates()
    {
        return $this->belongsToMany(Certificate::class, 'certificate_tools')
            ->withPivot('relevance')
            ->withTimestamps();
    }
}