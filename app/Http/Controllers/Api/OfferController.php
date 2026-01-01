<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function featured()
    {
        $offer = Offer::featured()->first();

        if (!$offer) {
            return response()->json(['data' => null]);
        }

        return response()->json([
            'data' => [
                'title_en' => $offer->title_en,
                'title_de' => $offer->title_de,
                'start_date' => $offer->start_date ? $offer->start_date->toIso8601String() : null,
                'end_date' => $offer->end_date->toIso8601String(),
                'price' => $offer->price,
                'target_link' => '/tour/' . $offer->target_link,
                'image' => asset('storage/' . $offer->image),
            ]
        ]);
    }
}
