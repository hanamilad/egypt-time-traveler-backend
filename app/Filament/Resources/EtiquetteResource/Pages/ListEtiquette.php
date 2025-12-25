<?php

namespace App\Filament\Resources\EtiquetteResource\Pages;

use App\Filament\Resources\EtiquetteResource;
use App\Models\Etiquette;
use Filament\Resources\Pages\ListRecords;

class ListEtiquette extends ListRecords
{
    protected static string $resource = EtiquetteResource::class;
    public function mount(): void
    {
        parent::mount();

        $record = Etiquette::first();

        if ($record) {
            redirect(EtiquetteResource::getUrl('edit', ['record' => $record]));
        } else {
            redirect(EtiquetteResource::getUrl('create'));
        }
    }
    protected function getHeaderActions(): array
    {
        return [];
    }
}
