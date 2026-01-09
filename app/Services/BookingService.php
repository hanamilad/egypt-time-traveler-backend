<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Tour;
use App\Events\BookingCreated;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\AvailabilityService;
use App\Services\BookingPricingService;

class BookingService
{
    protected $availabilityService;
    protected $pricingService;

    public function __construct(
        AvailabilityService $availabilityService,
        BookingPricingService $pricingService
    ) {
        $this->availabilityService = $availabilityService;
        $this->pricingService = $pricingService;
    }

    /**
     * Handle the booking creation process.
     *
     * @param array $data
     * @return Booking
     * @throws \Exception
     */
    public function createBooking(array $data): Booking
    {
        $tour = Tour::findOrFail($data['tour_id']);

        // Check availability
        if ($this->availabilityService->isDateClosed($data['date'])) {
            throw new \Exception('Sorry, we are fully booked (Sold Out) for the selected date.', 422);
        }

        // Calculate pricing
        $pricing = $this->pricingService->calculate(
            $tour,
            $data['date'],
            $data['adults'],
            $data['children'] ?? 0
        );

        return DB::transaction(function () use ($tour, $data, $pricing) {
            $booking = Booking::create([
                'booking_reference' => strtoupper(Str::random(10)),
                'tour_id' => $tour->id,
                'date' => $data['date'],
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'travelers' => $data['adults'] + ($data['children'] ?? 0),
                'adults' => $data['adults'],
                'children' => $data['children'] ?? 0,
                'price_per_adult' => $pricing['price_per_adult'],
                'price_per_child' => $pricing['price_per_child'],
                'price_per_person' => $pricing['price_per_adult'], // Legacy
                'pickup_location' => $data['pickup_location'] ?? null,
                'notes' => $data['notes'] ?? null,
                'total_price' => $pricing['total_price'],
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            // Dispatch event for notifications
            event(new BookingCreated($booking));

            return $booking;
        });
    }
}
