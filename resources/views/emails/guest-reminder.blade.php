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
            background-color: #0d9488;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .content {
            padding: 20px;
            background-color: #fff;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8em;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Upcoming Tour Reminder</h2>
        </div>
        <div class="content">
            <p>Dear {{ $booking->name }},</p>

            <p>{!! nl2br(e($bodyMessage)) !!}</p>

            <p><strong>Tour Details:</strong></p>
            <ul>
                <li><strong>Tour:</strong> {{ $booking->tour->title_en ?? 'N/A' }}</li>
                <li><strong>Date:</strong> {{ $booking->date->format('l, F j, Y') }}</li>
                <li><strong>Pickup:</strong> {{ $booking->pickup_location ?? 'TBD' }}</li>
            </ul>

            <p>We look forward to seeing you!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }}  TimeTraveler. All rights reserved.</p>
        </div>
    </div>
</body>

</html>