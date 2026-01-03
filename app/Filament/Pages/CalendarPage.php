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
            ->select('id', 'tour_id', 'date', 'name', 'phone', 'status')
            ->whereBetween('date', [$start, $end])
            ->whereIn('status', ['confirmed', 'paid', 'completed'])
            ->get()
            ->map(function (Booking $booking) {
                return [
                    'id' => 'booking-' . $booking->id,
                    'title' => ($booking->tour->title_en ?? 'Unknown'), // First line (mostly)
                    'start' => $booking->date->format('Y-m-d'),
                    'color' => '#fbbf24',
                    'textColor' => '#000',
                    'extendedProps' => [
                        'tourName' => $booking->tour->title_en ?? 'Unknown Tour',
                        'guestName' => $booking->name,
                        'guestCount' => "{$booking->travelers} Pax", // e.g. "3 Pax"
                        'phone' => $booking->phone,
                        'bookingId' => $booking->id,
                        'email' => $booking->email,
                    ],
                    // We removed the 'url' here to prevent auto-navigation on click. 
                    // Navigation will be handled by a specific part of the event content or double click if we wanted.
                    // But requirement says "btn ... and when i click this btn open a popup".
                    // We can keep 'url' if we want the card background to still link, but user wants specific actions.
                    // Let's keep 'url' null so we handle clicks entirely in JS or allow specific navigation buttons.
                    // Actually, let's keep 'url' but preventDefault in JS if blocking specific areas.
                    // However, to satisfy "4 lines ... btn", custom rendering is best. 
                    'url' => \App\Filament\Resources\Bookings\BookingResource::getUrl('edit', ['record' => $booking]),
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

    public function sendReminder(int $bookingId, string $message)
    {
        $booking = Booking::with('tour')->find($bookingId);

        if (! $booking) {
            Notification::make()
                ->title('Booking not found')
                ->danger()
                ->send();
            return;
        }

        try {
            // Send the email
            \Illuminate\Support\Facades\Mail::to($booking->email)
                ->send(new \App\Mail\GuestReminderNotification($booking, $message));

            Notification::make()
                ->title('Reminder Sent Successfully')
                ->success()
                ->send();

            // Dispatch event to close modal on frontend
            $this->dispatch('reminder-sent');
        } catch (\Exception $e) {
            Notification::make()
                ->title('Failed to send reminder')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
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
