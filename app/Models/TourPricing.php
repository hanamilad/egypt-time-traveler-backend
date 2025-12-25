<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'people_count',
        'price',
    ];

    protected $casts = [
        'people_count' => 'integer',
        'price' => 'decimal:2',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
