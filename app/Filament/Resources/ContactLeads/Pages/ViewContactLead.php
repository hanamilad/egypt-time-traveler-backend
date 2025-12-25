<?php

namespace App\Filament\Resources\ContactLeads\Pages;

use App\Filament\Resources\ContactLeads\ContactLeadResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContactLead extends ViewRecord
{
    protected static string $resource = ContactLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

