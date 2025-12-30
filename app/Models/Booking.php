<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'tour_id',
        'date',
        'name',
        'email',
        'phone',
        'travelers',
        'adults',
        'children',
        'price_per_adult',
        'price_per_child',
        'price_per_person', // Legacy/Simplified
        'pickup_location',
        'notes',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'payment_reference',
    ];

    protected $casts = [
        'date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
