<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'city_id',
        'title_en',
        'title_de',
        'short_desc_en',
        'short_desc_de',
        'price',
        'original_price',
        'child_discount_percent',
        'duration_hours',
        'max_group',
        'rating',
        'review_count',
        'featured',
        'image',
        'duration_days',
        'duration_days',
        'status',
        'is_package',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'child_discount_percent' => 'decimal:2',
        'rating' => 'decimal:1',
        'duration_days' => 'integer',
        'is_package' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        $value = $this->image;

        if (!$value) {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        return asset('storage/' . $value);
    }



    public function details()
    {
        return $this->hasOne(TourDetail::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function itineraries()
    {
        return $this->hasMany(TourItinerary::class);
    }

    public function images()
    {
        return $this->hasMany(TourImage::class);
    }

    public function faqs()
    {
        return $this->hasMany(TourFaq::class);
    }

    public function reviews()
    {
        return $this->hasMany(TourReview::class);
    }

    public function availabilities()
    {
        return $this->hasMany(TourAvailability::class);
    }

    public function pricings()
    {
        return $this->hasMany(TourPricing::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePackages($query)
    {
        return $query->where('is_package', true);
    }

    public function scopeCity($query, $city)
    {
        if ($city) {
            // Support both city_id and city name
            if (is_numeric($city)) {
                return $query->where('city_id', $city);
            } else {
                return $query->whereHas('city', function ($q) use ($city) {
                    $q->where('name_en', 'like', '%' . $city . '%');
                });
            }
        }
        return $query;
    }

    public function scopePriceRange($query, $range)
    {
        if ($range === 'budget') {
            return $query->where('price', '<', 50);
        } elseif ($range === 'standard') {
            return $query->whereBetween('price', [50, 150]);
        } elseif ($range === 'luxury') {
            return $query->where('price', '>', 150);
        }
        return $query;
    }

    public function updateReviewStats()
    {
        $stats = $this->reviews()
            ->where('status', 'approved')
            ->selectRaw('count(*) as count, avg(rating) as avg_rating')
            ->first();

        $this->update([
            'review_count' => $stats->count ?? 0,
            'rating' => round($stats->avg_rating ?? 0, 1),
        ]);
    }

    public function scopeExamples($query)
    {
        return $query;
    }
}
