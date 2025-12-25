<?php

namespace App\Filament\Resources\SiteInfos\Pages;

use App\Filament\Resources\SiteInfos\SiteInfoResource;
use App\Models\SiteInfo;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSiteInfos extends ListRecords
{
    protected static string $resource = SiteInfoResource::class;

    protected function getHeaderActions(): array
    {
        if (SiteInfo::count() > 0) {
            return [];
        }
        return [
            CreateAction::make(),
        ];
    }
}
