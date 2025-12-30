<?php

namespace App\Filament\Pages;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\TourAvailability;
use App\Services\AvailabilityService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class CalendarPage extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Calendar';
    protected static ?string $title = 'Availability Calendar';
    protected static ?string $slug = 'calendar';

    protected string $view = 'filament.pages.calendar-page';

    public static function getNavigationGroup(): ?string
    {
        return 'Tours Management';
    }

    public function getEvents(string $start, string $end): array
    {
        $bookings = Booking::with('tour:id,title_en')
            ->select('id', 'tour_id', 'date', 'name', 'status')
            ->whereBetween('date', [$start, $end])
            ->whereIn('status', ['confirmed', 'paid', 'completed'])
            ->get()
            ->map(function (Booking $booking) {
                return [
                    'id' => 'booking-' . $booking->id,
                    'title' => ($booking->tour->title_en ?? 'Unknown') . ' (' . $booking->name . ')',
                    'start' => $booking->date->format('Y-m-d'),
                    'color' => '#fbbf24',
                    'textColor' => '#000',
                ];
            })
            ->toArray();

        // Add "Sold Out" indicators for the range
        $soldOutDates = TourAvailability::whereBetween('date', [$start, $end])
            ->where('status', 'sold_out')
            ->select('date')
            ->distinct()
            ->get()
            ->map(function ($availability) {
                return [
                    'id' => 'soldout-' . $availability->date->format('Y-m-d'),
                    'title' => '❌ SOLD OUT',
                    'start' => $availability->date->format('Y-m-d'),
                    'color' => '#ef4444',
                    'allDay' => true,
                    'display' => 'background',
                ];
            })
            ->toArray();

        return array_merge($bookings, $soldOutDates);
    }

    public function toggleSoldOut($date)
    {
        $service = app(AvailabilityService::class);
        $isSoldOut = $service->isDateClosed($date);

        if ($isSoldOut) {
            $service->openDate($date);

            Notification::make()
                ->title('Availability Re-opened')
                ->success()
                ->send();
        } else {
            $service->closeDate($date);

            Notification::make()
                ->title('Day Marked as Sold Out')
                ->danger()
                ->send();
        }

        $this->dispatch('calendar-updated');
    }
}
