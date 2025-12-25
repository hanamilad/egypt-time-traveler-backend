<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case unpaid = 'unpaid';
    case partial = 'partial';
    case paid = 'paid';
    case refunded = 'refunded';
}

