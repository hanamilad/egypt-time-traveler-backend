<?php

namespace App\Filament\Resources\BestTimeResource\Pages;

use App\Filament\Resources\BestTimeResource;
use App\Models\BestTime;
use Filament\Resources\Pages\ListRecords;

class ListBestTime extends ListRecords
{
    protected static string $resource = BestTimeResource::class;

    public function mount(): void
    {
        parent::mount();

        $record = BestTime::first();

        if ($record) {
            redirect(BestTimeResource::getUrl('edit', ['record' => $record]));
        } else {
            redirect(BestTimeResource::getUrl('create'));
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
