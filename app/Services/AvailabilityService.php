<?php

namespace App\Services;

use App\Models\Tour;
use App\Models\TourAvailability;
use Illuminate\Support\Facades\DB;

class AvailabilityService
{
    /**
     * Mark all active tours as sold out for a given date.
     */
    public function closeDate(string $date): void
    {
        $tours = Tour::where('status', 'active')->get();

        DB::transaction(function () use ($tours, $date) {
            foreach ($tours as $tour) {
                TourAvailability::updateOrCreate(
                    ['tour_id' => $tour->id, 'date' => $date],
                    ['status' => 'sold_out', 'available_seats' => 0]
                );
            }
        });
    }

    /**
     * Re-open availability for all tours for a given date.
     */
    public function openDate(string $date): void
    {
        TourAvailability::whereDate('date', $date)
            ->where('status', 'sold_out')
            ->delete();
    }

    /**
     * Check if a date is globally closed.
     */
    public function isDateClosed(string $date): bool
    {
        return TourAvailability::whereDate('date', $date)
            ->where('status', 'sold_out')
            ->exists();
    }

    /**
     * Synchronize global status if a specific tour is marked as sold out.
     */
    public function syncGlobalStatus(string $date, string $status): void
    {
        if ($status === 'sold_out') {
            $this->closeDate($date);
        }
    }
}
