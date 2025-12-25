<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourDetail;
use App\Models\TourItinerary;
use App\Models\TourAvailability;

class TourSeeder extends Seeder
{
    public function run()
    {
        $tour = Tour::create([
            'slug' => 'pyramids-sphinx-egyptian-museum',
            'city' => 'cairo',
            'title_en' => 'Pyramids, Sphinx & Egyptian Museum',
            'title_de' => 'Pyramiden, Sphinx & Ägyptisches Museum',
            'short_desc_en' => "Experience Cairo's iconic ancient wonders...",
            'short_desc_de' => "Erleben Sie Kairos ikonische antike Wunder...",
            'price' => 75.00,
            'original_price' => 95.00,
            'duration_hours' => 8,
            'max_group' => 12,
            'rating' => 4.9,
            'review_count' => 1247,
            'featured' => true,
            'image' => 'https://example.com/image.jpg',
            'duration_days' => 4,
            'status' => 'active',
        ]);

        TourDetail::create([
            'tour_id' => $tour->id,
            'full_desc_en' => "Embark on an unforgettable journey...",
            'full_desc_de' => "Begeben Sie sich auf eine unvergessliche Reise...",
            'highlights_en' => ["See the Great Pyramid", "Visit the Sphinx"],
            'highlights_de' => ["Sehen Sie die Große Pyramide", "Besuchen Sie die Sphinx"],
            'included_en' => ["Hotel pickup", "Lunch"],
            'included_de' => ["Hotelabholung", "Mittagessen"],
            'not_included_en' => ["Tips", "Personal expenses"],
            'not_included_de' => ["Trinkgelder", "Persönliche Ausgaben"],
            'meeting_point' => "Hotel pickup in Cairo",
            'map_lat' => 29.9792,
            'map_lng' => 31.1342,
        ]);

        TourItinerary::create([
            'tour_id' => $tour->id,
            'day_number' => 1,
            'time' => '08:00',
            'title_en' => 'Hotel Pickup',
            'title_de' => 'Hotelabholung',
            'description_en' => 'Pickup from your hotel...',
            'description_de' => 'Abholung von Ihrem Hotel...',
        ]);

        // Add Availability
        TourAvailability::create([
            'tour_id' => $tour->id,
            'date' => now()->addDays(5)->format('Y-m-d'),
            'available_seats' => 12,
            'special_price' => 65.00,
            'status' => 'available',
        ]);
        
        TourAvailability::create([
            'tour_id' => $tour->id,
            'date' => now()->addDays(6)->format('Y-m-d'),
            'available_seats' => 0,
            'status' => 'sold_out',
        ]);
    }
}
