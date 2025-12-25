<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visa extends Model
{
    protected $table = 'visa';

    public $timestamps = false;

    protected $fillable = [
        'title_en',
        'title_de',
        'intro_en',
        'intro_de',
        'items_en',
        'items_de',
    ];

    protected $casts = [
        'items_en' => 'array',
        'items_de' => 'array',
    ];
}

