<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

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

        try {
            $booking = $this->bookingService->createBooking($validated);

            return response()->json([
                'success' => true,
                'message' => 'Booking request received',
                'booking_id' => $booking->id,
                'reference' => $booking->booking_reference
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }
}
