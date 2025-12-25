<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
    protected $fillable = [
        'brand1', 'brand2', 'tagline',
        'address', 'phone', 'email', 'availability',
        'social_links',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
}
