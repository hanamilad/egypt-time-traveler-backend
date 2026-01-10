<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .header {
            background-color: #2b3990;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: normal;
        }

        .content {
            padding: 30px;
        }

        .message-box {
            background-color: #f9f9f9;
            border-left: 4px solid #2b3990;
            padding: 15px;
            margin-bottom: 25px;
        }

        .section-title {
            color: #2b3990;
            font-size: 18px;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .booking-details {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .booking-details th,
        .booking-details td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .booking-details th {
            color: #555;
            font-weight: 600;
            width: 40%;
            background-color: #fafafa;
        }

        .footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #eee;
        }

        .btn-link {
            display: inline-block;
            margin-top: 10px;
            color: #2b3990;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Booking Request Received</h1>
            <p style="margin: 5px 0 0; opacity: 0.9; font-size: 16px;">Buchungsanfrage Erhalten</p>
        </div>

        <div class="content">
            <!-- English Section -->
            <div style="margin-bottom: 30px;">
                <p>Dear <strong>{{ $booking->name }}</strong>,</p>

                <div class="message-box">
                    <p style="margin: 0;">Thank you for choosing <strong>Time Traveler</strong>.</p>
                    <p style="margin: 10px 0 0;">We have received your booking request. Our team will review your details and contact you within <strong>24 hours</strong> to confirm your reservation and arrange the next steps.</p>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

            <!-- German Section -->
            <div style="margin-bottom: 30px;">
                <p>Sehr geehrte(r) <strong>{{ $booking->name }}</strong>,</p>

                <div class="message-box">
                    <p style="margin: 0;">Vielen Dank, dass Sie sich für <strong>Time Traveler</strong> entschieden haben.</p>
                    <p style="margin: 10px 0 0;">Wir haben Ihre Buchungsanfrage erhalten. Unser Team wird Ihre Angaben prüfen und sich innerhalb von <strong>24 Stunden</strong> bei Ihnen melden, um Ihre Reservierung zu bestätigen und die nächsten Schritte zu besprechen.</p>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="section-title">Booking Summary / Buchungsübersicht</div>

            <table class="booking-details">
                <tr>
                    <th>Reference / Referenz</th>
                    <td>{{ $booking->booking_reference }}</td>
                </tr>
                <tr>
                    <th>Tour</th>
                    <td>{{ $booking->tour->title_en ?? 'Guided Tour' }}</td>
                </tr>
                <tr>
                    <th>Date / Datum</th>
                    <td>{{ $booking->date->format('l, F j, Y') }}</td>
                </tr>
                <tr>
                    <th>Participants / Teilnehmer</th>
                    <td>
                        {{ $booking->adults }} Adult(s)
                        @if($booking->children > 0)
                        , {{ $booking->children }} Child(ren)
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Pickup / Abholung</th>
                    <td>{{ $booking->pickup_location ?? 'TBA' }}</td>
                </tr>
            </table>

            <p style="margin-top: 30px; text-align: center; font-style: italic; color: #666;">
                We look forward to creating unforgettable memories with you!<br>
                Wir freuen uns darauf, unvergessliche Erinnerungen mit Ihnen zu schaffen!
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Time Traveler. All rights reserved.</p>
            <p>
                <a href="#" class="btn-link">www.timetraveller.tours</a>
            </p>
        </div>
    </div>
</body>

</html>