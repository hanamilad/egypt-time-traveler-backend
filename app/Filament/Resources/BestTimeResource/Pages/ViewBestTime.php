<?php

namespace App\Filament\Resources\BestTimeResource\Pages;

use App\Filament\Resources\BestTimeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBestTime extends ViewRecord
{
    protected static string $resource = BestTimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

