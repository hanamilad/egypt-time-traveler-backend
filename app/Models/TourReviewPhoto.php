<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourReviewPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'path',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    public function review()
    {
        return $this->belongsTo(TourReview::class, 'review_id');
    }
}
