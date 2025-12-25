<?php

namespace App\Enums;

enum ReviewStatus: string
{
    case pending = 'pending';
    case approved = 'approved';
    case rejected = 'rejected';
}

