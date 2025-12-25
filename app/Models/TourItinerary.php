<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourItinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'day_number', // Optional if day-based
        'time',
        'title_en',
        'title_de',
        'description_en',
        'description_de',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
