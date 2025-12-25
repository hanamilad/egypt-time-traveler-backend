<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialVideo extends Model
{
    protected $fillable = [
        'platform',
        'url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    //
}
