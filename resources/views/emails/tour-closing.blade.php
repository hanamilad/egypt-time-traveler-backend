<x-mail::message>
# Important Update regarding your tour

Hello {{ $booking->name }},

We are writing to provide an important update regarding your booking **#{{ $booking->booking_reference }}** for **{{ $booking->tour->title_en }}** on **{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}**.

{{ $customMessage }}

If you have any questions, please feel free to reply to this email or contact us via phone.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
