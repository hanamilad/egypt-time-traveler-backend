<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackingCategory extends Model
{
    protected $table = 'packing_categories';

    public $timestamps = false;

    protected $fillable = [
        'packing_id',
        'name_en',
        'name_de',
        'items_en',
        'items_de',
    ];

    protected $casts = [
        'items_en' => 'array',
        'items_de' => 'array',
    ];

    public function packing(): BelongsTo
    {
        return $this->belongsTo(Packing::class, 'packing_id');
    }
}

