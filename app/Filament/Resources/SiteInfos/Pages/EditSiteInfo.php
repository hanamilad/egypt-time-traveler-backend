<?php

namespace App\Filament\Resources\SiteInfos\Pages;

use App\Filament\Resources\SiteInfos\SiteInfoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSiteInfo extends EditRecord
{
    protected static string $resource = SiteInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
