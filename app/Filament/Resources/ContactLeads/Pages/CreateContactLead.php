<?php

namespace App\Filament\Resources\ContactLeads\Pages;

use App\Filament\Resources\ContactLeads\ContactLeadResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactLead extends CreateRecord
{
    protected static string $resource = ContactLeadResource::class;
}

