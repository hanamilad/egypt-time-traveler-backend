<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EtiquetteTip extends Model
{
    protected $table = 'etiquette_tips';

    public $timestamps = false;

    protected $fillable = [
        'etiquette_id',
        'title_en',
        'title_de',
        'description_en',
        'description_de',
    ];

    public function etiquette(): BelongsTo
    {
        return $this->belongsTo(Etiquette::class, 'etiquette_id');
    }
}

