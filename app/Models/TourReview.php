<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourReview extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::saved(function ($review) {
            $review->tour->updateReviewStats();
        });

        static::deleted(function ($review) {
            $review->tour->updateReviewStats();
        });
    }

    protected $fillable = [
        'tour_id',
        'author',
        'country',
        'rating',
        'comment',
        'date',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
        'date' => 'date',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function photos()
    {
        return $this->hasMany(TourReviewPhoto::class, 'review_id');
    }
}
