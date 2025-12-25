<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'full_desc_en',
        'full_desc_de',
        'highlights_en',
        'highlights_de',
        'included_en',
        'included_de',
        'not_included_en',
        'not_included_de',
    ];

    protected $casts = [
        'highlights_en' => 'array',
        'highlights_de' => 'array',
        'included_en' => 'array',
        'included_de' => 'array',
        'not_included_en' => 'array',
        'not_included_de' => 'array',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
