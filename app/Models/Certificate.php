<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'issuing_organization',
        'issue_date',
        'expiry_date',
        'credential_id',
        'credential_url',
        'description',
        'image'
    ];

    protected $dates = [
        'issue_date',
        'expiry_date'
    ];

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'certificate_tools')
            ->withPivot('relevance')
            ->withTimestamps();
    }
}