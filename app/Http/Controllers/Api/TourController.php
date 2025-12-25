<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Http\Resources\TourResource;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::active();

        if ($request->has('featured') && $request->featured == 'true') {
            $query->where('featured', true);
        }

        if ($request->has('city')) {
            $query->city($request->city);
        }

        if ($request->has('price_range')) {
            $query->priceRange($request->price_range);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title_en', 'like', '%' . $request->search . '%')
                  ->orWhere('title_de', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->has('rating')) {
            if ($request->rating === '4plus') {
                $query->where('rating', '>=', 4);
            }
        }
        
        if ($request->has('duration')) {
        }

        $tours = $query->paginate($request->get('limit', 20));

        return TourResource::collection($tours); 
    }

    public function show($slug)
    {
        $tour = Tour::with(['details', 'itineraries', 'images', 'faqs', 'pricings', 'reviews' => function($query) {
            $query->where('status', 'approved')->with('photos');
        }])
            ->where('slug', $slug)
            ->firstOrFail();

        return new TourResource($tour);
    }

    public function availability($slug)
    {
        $tour = Tour::where('slug', $slug)->firstOrFail();
        $availability = $tour->availabilities()
             ->where('date', '>=', now())
             ->get()
             ->map(function($item) {
                 return [
                     'date' => $item->date,
                     'available_seats' => $item->available_seats,
                     'special_price' => $item->special_price,
                     'status' => $item->status,
                     'is_available' => $item->available_seats > 0 && ($item->status === 'available'),
                 ];
             });

        return response()->json(['data' => $availability]);
    }
}
