<?php

namespace App\Filament\Resources\BestTimeResource\Pages;

use App\Filament\Resources\BestTimeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBestTime extends EditRecord
{
    protected static string $resource = BestTimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
