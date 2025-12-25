<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Packing extends Model
{
    protected $table = 'packing';

    public $timestamps = false;

    protected $fillable = [
        'title_en',
        'title_de',
        'intro_en',
        'intro_de',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(PackingCategory::class, 'packing_id');
    }
}

