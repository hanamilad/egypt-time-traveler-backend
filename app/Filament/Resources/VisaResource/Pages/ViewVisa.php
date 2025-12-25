<?php

namespace App\Filament\Resources\VisaResource\Pages;

use App\Filament\Resources\VisaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVisa extends ViewRecord
{
    protected static string $resource = VisaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

