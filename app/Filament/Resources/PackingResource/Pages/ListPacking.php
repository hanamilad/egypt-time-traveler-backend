<?php

namespace App\Filament\Resources\PackingResource\Pages;

use App\Filament\Resources\PackingResource;
use App\Models\Packing;
use Filament\Resources\Pages\ListRecords;

class ListPacking extends ListRecords
{
    protected static string $resource = PackingResource::class;
    public function mount(): void
    {
        parent::mount();

        $record = Packing::first();

        if ($record) {
            redirect(PackingResource::getUrl('edit', ['record' => $record]));
        } else {
            redirect(PackingResource::getUrl('create'));
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
