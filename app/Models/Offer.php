<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'title_en',
        'title_de',
        'start_date',
        'end_date',
        'price',
        'target_link',
        'image',
        'active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
        'active' => 'boolean',
    ];

    public function scopeFeatured($query)
    {
        return $query->where('active', true)
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>', now())
                     ->orderBy('end_date', 'asc');
    }
}
