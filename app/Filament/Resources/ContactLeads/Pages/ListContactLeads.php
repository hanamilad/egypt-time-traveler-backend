<?php

namespace App\Filament\Resources\ContactLeads\Pages;

use App\Filament\Resources\ContactLeads\ContactLeadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactLeads extends ListRecords
{
    protected static string $resource = ContactLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

