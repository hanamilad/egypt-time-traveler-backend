<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BestTime extends Model
{
    protected $table = 'best_time';

    public $timestamps = false;

    protected $fillable = [
        'title_en',
        'title_de',
        'intro_en',
        'intro_de',
    ];

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class, 'best_time_id');
    }
}

