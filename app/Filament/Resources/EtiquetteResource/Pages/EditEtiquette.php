<?php

namespace App\Filament\Resources\EtiquetteResource\Pages;

use App\Filament\Resources\EtiquetteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEtiquette extends EditRecord
{
    protected static string $resource = EtiquetteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
