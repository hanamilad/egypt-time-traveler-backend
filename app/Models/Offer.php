<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'title_en',
        'title_de',
        'end_date',
        'target_link',
        'image',
        'active',
    ];

    protected $casts = [
        'end_date' => 'datetime',
        'active' => 'boolean',
    ];

    public function scopeFeatured($query)
    {
        return $query->where('active', true)->where('end_date', '>', now())->orderBy('end_date', 'asc');
    }
}
