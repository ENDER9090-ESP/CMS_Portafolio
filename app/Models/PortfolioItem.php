<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'item_type',
        'order'
    ];

    public function item()
    {
        return $this->morphTo();
    }
}