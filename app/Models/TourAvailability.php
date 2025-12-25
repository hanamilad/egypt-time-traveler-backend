<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourAvailability extends Model
{
    use HasFactory;

    protected $table = 'tour_availability'; // Ensure correct table name mapping

    protected $fillable = [
        'tour_id',
        'date',
        'available_seats',
        'special_price',
        'status', // available, sold_out, etc.
    ];

    protected $casts = [
        'date' => 'date',
        'special_price' => 'decimal:2',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
