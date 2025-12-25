<?php

namespace App\Enums;

enum BookingStatus: string
{
    case pending = 'pending';
    case confirmed = 'confirmed';
    case paid = 'paid';
    case cancelled = 'cancelled';
    case completed = 'completed';
}

