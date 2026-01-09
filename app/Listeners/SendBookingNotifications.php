<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Mail\AdminBookingNotification;
use App\Mail\GuestBookingConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendBookingNotifications
{
    /**
     * Handle the event.
     */
    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking;

        // 1. Send Admin Notification
        try {
            $adminEmail = config('mail.from.address', 'admin@example.com');
            Mail::to($adminEmail)->send(new AdminBookingNotification($booking));
        } catch (\Exception $e) {
            Log::error('Failed to send admin booking email: ' . $e->getMessage());
        }

        // 2. Send Guest Confirmation
        try {
            Mail::to($booking->email)->send(new GuestBookingConfirmation($booking));
        } catch (\Exception $e) {
            Log::error('Failed to send guest booking confirmation email: ' . $e->getMessage());
        }
    }
}
