<?php

namespace App\Filament\Resources\TourResource\Pages;

use App\Filament\Resources\TourResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTour extends EditRecord
{
    protected static string $resource = TourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load details relationship data into the main form
        if ($this->record->details) {
            $data['full_desc_en'] = $this->record->details->full_desc_en;
            $data['full_desc_de'] = $this->record->details->full_desc_de;
            $data['highlights_en'] = $this->record->details->highlights_en;
            $data['highlights_de'] = $this->record->details->highlights_de;
            $data['included_en'] = $this->record->details->included_en;
            $data['included_de'] = $this->record->details->included_de;
            $data['not_included_en'] = $this->record->details->not_included_en;
            $data['not_included_de'] = $this->record->details->not_included_de;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extract details data before saving
        $detailsData = [
            'full_desc_en' => $data['full_desc_en'] ?? null,
            'full_desc_de' => $data['full_desc_de'] ?? null,
            'highlights_en' => $data['highlights_en'] ?? null,
            'highlights_de' => $data['highlights_de'] ?? null,
            'included_en' => $data['included_en'] ?? null,
            'included_de' => $data['included_de'] ?? null,
            'not_included_en' => $data['not_included_en'] ?? null,
            'not_included_de' => $data['not_included_de'] ?? null,
        ];

        // Store in a property to save after the tour is saved
        $this->detailsData = $detailsData;

        // Remove from main data
        unset(
            $data['full_desc_en'],
            $data['full_desc_de'],
            $data['highlights_en'],
            $data['highlights_de'],
            $data['included_en'],
            $data['included_de'],
            $data['not_included_en'],
            $data['not_included_de']
        );

        return $data;
    }

    protected function afterSave(): void
    {
        // Save or update the details relationship
        if (isset($this->detailsData)) {
            $this->record->details()->updateOrCreate(
                ['tour_id' => $this->record->id],
                $this->detailsData
            );
        }
    }
}
