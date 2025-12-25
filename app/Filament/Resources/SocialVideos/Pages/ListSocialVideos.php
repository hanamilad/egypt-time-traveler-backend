<?php

namespace App\Filament\Resources\SocialVideos\Pages;

use App\Filament\Resources\SocialVideos\SocialVideoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSocialVideos extends ListRecords
{
    protected static string $resource = SocialVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
