<?php

namespace App\Models;

use App\Enums\SeasonName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Season extends Model
{
    protected $table = 'seasons';

    public $timestamps = false;

    protected $fillable = [
        'best_time_id',
        'season_name',
        'name_en',
        'name_de',
        'description_en',
        'description_de',
    ];

    protected $casts = [
        'season_name' => SeasonName::class,
    ];

    public function bestTime(): BelongsTo
    {
        return $this->belongsTo(BestTime::class, 'best_time_id');
    }

    public function scopeSeason($query, SeasonName|string $name)
    {
        $value = $name instanceof SeasonName ? $name->value : $name;
        return $query->where('season_name', $value);
    }
}

