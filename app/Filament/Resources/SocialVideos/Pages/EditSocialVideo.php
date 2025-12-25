<?php

namespace App\Filament\Resources\SocialVideos\Pages;

use App\Filament\Resources\SocialVideos\SocialVideoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSocialVideo extends EditRecord
{
    protected static string $resource = SocialVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
