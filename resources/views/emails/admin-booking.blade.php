<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .header {
            background-color: #2b3990;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .content {
            padding: 20px;
            background-color: #fff;
        }

        .booking-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .booking-details th,
        .booking-details td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .booking-details th {
            background-color: #f2f2f2;
            width: 40%;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8em;
            color: #777;
        }

        .total-price {
            font-size: 1.2em;
            font-weight: bold;
            color: #2b3990;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>New Tour Booking Received</h2>
        </div>
        <div class="content">
            <p>Dear Admin,</p>
            <p>A new booking has been successfully placed. Please find the details below:</p>

            <table class="booking-details">
                <tr>
                    <th>Booking Reference</th>
                    <td>{{ $booking->booking_reference }}</td>
                </tr>
                <tr>
                    <th>Tour Name</th>
                    <td>{{ $booking->tour->title_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Customer Name</th>
                    <td>{{ $booking->name }}</td>
                </tr>
                <tr>
                    <th>Customer Email</th>
                    <td>{{ $booking->email }}</td>
                </tr>
                <tr>
                    <th>Customer Phone</th>
                    <td>{{ $booking->phone }}</td>
                </tr>
                <tr>
                    <th>Tour Date</th>
                    <td>{{ $booking->date->format('l, F j, Y') }}</td>
                </tr>
                <tr>
                    <th>Participants</th>
                    <td>
                        {{ $booking->adults }} Adult(s)
                        @if($booking->children > 0), {{ $booking->children }} Child(ren) @endif
                    </td>
                </tr>
                <tr>
                    <th>Pickup Location</th>
                    <td>{{ $booking->pickup_location ?? 'Not specified' }}</td>
                </tr>
                @if($booking->notes)
                <tr>
                    <th>Special Requests/Notes</th>
                    <td>{{ $booking->notes }}</td>
                </tr>
                @endif
                <tr>
                    <th>Total Price</th>
                    <td class="total-price">${{ number_format($booking->total_price, 2) }}</td>
                </tr>
                <tr>
                    <th>Payment Status</th>
                    <td style="text-transform: capitalize;">{{ $booking->payment_status }}</td>
                </tr>
            </table>

            <p style="margin-top: 20px;">
                Please log in to the admin dashboard to manage this booking.
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }}  TimeTraveler. All rights reserved.</p>
        </div>
    </div>
</body>

</html>