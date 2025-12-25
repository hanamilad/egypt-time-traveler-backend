<?php

namespace App\Enums;

enum TourStatus: string
{
    case active = 'active';
    case draft = 'draft';
    case archived = 'archived';
}

