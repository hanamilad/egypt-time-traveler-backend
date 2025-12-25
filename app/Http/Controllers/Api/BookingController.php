<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\TourAvailability;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'date' => 'required|date',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'pickup_location' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $tour = Tour::findOrFail($validated['tour_id']);

        // Check availability
        $availability = TourAvailability::where('tour_id', $tour->id)
            ->whereDate('date', $validated['date'])
            ->first();

        if ($availability && $availability->status === 'sold_out') {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, this tour is closed for the selected date.'
            ], 422);
        }
        // Calculate price
        $adults = $validated['adults'];
        $children = $validated['children'] ?? 0;
        $pricePerAdult = $tour->price; // Or fetch from specific availability pricing
        $pricePerChild = $tour->price * 0.7; // Example child discount
        
        $totalPrice = ($adults * $pricePerAdult) + ($children * $pricePerChild);

        $booking = Booking::create([
            'booking_reference' => strtoupper(Str::random(10)),
            'tour_id' => $tour->id,
            'date' => $validated['date'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'travelers' => $adults + $children,
            'adults' => $adults,
            'children' => $children,
            'price_per_adult' => $pricePerAdult,
            'price_per_child' => $pricePerChild,
            'price_per_person' => $pricePerAdult, // Legacy
            'pickup_location' => $validated['pickup_location'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking request received',
            'booking_id' => $booking->id,
            'reference' => $booking->booking_reference
        ], 201);
    }
}
