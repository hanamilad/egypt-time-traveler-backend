<?php

namespace App\Filament\Resources\VisaResource\Pages;

use App\Filament\Resources\VisaResource;
use Filament\Resources\Pages\ListRecords;

use App\Models\Visa;

class ListVisa extends ListRecords
{
    protected static string $resource = VisaResource::class;

    public function mount(): void
    {
        parent::mount();

        $record = Visa::first();

        if ($record) {
            redirect(VisaResource::getUrl('edit', ['record' => $record]));
        } else {
            redirect(VisaResource::getUrl('create'));
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
