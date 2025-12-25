<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etiquette extends Model
{
    protected $table = 'etiquette';

    public $timestamps = false;

    protected $fillable = [
        'title_en',
        'title_de',
        'intro_en',
        'intro_de',
    ];

    public function tips(): HasMany
    {
        return $this->hasMany(EtiquetteTip::class, 'etiquette_id');
    }
}

