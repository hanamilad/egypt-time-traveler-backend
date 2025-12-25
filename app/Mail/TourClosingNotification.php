<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class TourClosingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $customMessage;

    public function __construct(Booking $booking, $customMessage)
    {
        $this->booking = $booking;
        $this->customMessage = $customMessage;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Important Update: Your Booking for ' . $this->booking->tour->title_en,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tour-closing',
        );
    }
}
