<?php

namespace App\Filament\Resources\EtiquetteResource\Pages;

use App\Filament\Resources\EtiquetteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEtiquette extends ViewRecord
{
    protected static string $resource = EtiquetteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

