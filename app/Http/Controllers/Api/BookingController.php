<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use App\Services\AvailabilityService;
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

        // Global Check: Check if the date is closed for all tours (guide busy)
        if (app(AvailabilityService::class)->isDateClosed($validated['date'])) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, we are fully booked (Sold Out) for the selected date.'
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

        // Trigger Admin Email
        try {
            $adminEmail = env('MAIL_FROM_ADDRESS', 'admin@example.com'); // Fallback or distinct admin email
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\AdminBookingNotification($booking));
        } catch (\Exception $e) {
            // Log mail failure but don't fail the request
            \Illuminate\Support\Facades\Log::error('Failed to send admin booking email: ' . $e->getMessage());
        }

        // Trigger Guest Confirmation Email
        try {
            \Illuminate\Support\Facades\Mail::to($booking->email)->send(new \App\Mail\GuestBookingConfirmation($booking));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send guest booking confirmation email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking request received',
            'booking_id' => $booking->id,
            'reference' => $booking->booking_reference
        ], 201);
    }
}
