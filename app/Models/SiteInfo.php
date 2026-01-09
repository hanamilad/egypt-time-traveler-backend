<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
    protected $fillable = [
        'brand1',
        'brand2',
        'tagline',
        'address',
        'phone',
        'email',
        'availability',
        'social_links',
        'booking_policy_en',
        'booking_policy_de',
        'cancellation_policy_en',
        'cancellation_policy_de',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
}
