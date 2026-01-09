<?php

namespace App\Services;

use App\Models\Tour;
use App\Models\TourPricing;
use App\Models\TourAvailability;

class BookingPricingService
{
    /**
     * Calculate the total price for a booking.
     *
     * @param Tour $tour
     * @param string $date
     * @param int $adults
     * @param int $children
     * @return array
     */
    public function calculate(Tour $tour, string $date, int $adults, int $children): array
    {
        $totalPeople = $adults + $children;
        $pricePerPerson = $this->getBasePricePerPerson($tour, $date, $totalPeople);

        $adultSubtotal = $adults * $pricePerPerson;
        
        // Apply child discount if applicable
        $discount = $tour->child_discount_percent ?? 0;
        $pricePerChild = $pricePerPerson * (1 - ($discount / 100));
        $childSubtotal = $children * $pricePerChild;

        $totalPrice = $adultSubtotal + $childSubtotal;

        return [
            'total_price' => round($totalPrice, 2),
            'price_per_adult' => round($pricePerPerson, 2),
            'price_per_child' => round($pricePerChild, 2),
            'currency' => 'USD', // Based on project context
        ];
    }

    /**
     * Determine the base price per person based on hierarchy.
     */
    protected function getBasePricePerPerson(Tour $tour, string $date, int $totalPeople): float
    {
        // 1. Check Tiered Pricing (Custom Pricing)
        $tieredPricing = TourPricing::where('tour_id', $tour->id)
            ->where('people_count', $totalPeople)
            ->first();

        if ($tieredPricing) {
            return (float) ($tieredPricing->price / $totalPeople);
        }

        // 2. Check Special Date Price
        $availability = TourAvailability::where('tour_id', $tour->id)
            ->whereDate('date', $date)
            ->first();

        if ($availability && $availability->special_price) {
            return (float) $availability->special_price;
        }

        // 3. Fallback to default Tour Price
        return (float) $tour->price;
    }
}
