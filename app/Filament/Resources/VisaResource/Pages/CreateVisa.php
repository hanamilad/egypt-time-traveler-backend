<?php

namespace App\Filament\Resources\VisaResource\Pages;

use App\Filament\Resources\VisaResource;
use App\Models\Visa;
use Filament\Resources\Pages\CreateRecord;

class CreateVisa extends CreateRecord
{
    protected static string $resource = VisaResource::class;

    protected function authorizeAccess(): void
    {
        abort_if(Visa::query()->exists(), 403);
    }
}


