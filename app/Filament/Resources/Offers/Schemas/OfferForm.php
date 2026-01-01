<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Schemas\Schema;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('title_en')
                    ->label('Title (English)')
                    ->required()
                    ->maxLength(255),
                \Filament\Forms\Components\TextInput::make('title_de')
                    ->label('Title (German)')
                    ->required()
                    ->maxLength(255),
                \Filament\Forms\Components\DateTimePicker::make('start_date')
                    ->label('Offer Start Date')
                    ->required()
                    ->native(false),
                \Filament\Forms\Components\DateTimePicker::make('end_date')
                    ->label('Offer End Date')
                    ->required()
                    ->native(false)
                    ->minDate(now())
                    ->after('start_date'),
                \Filament\Forms\Components\TextInput::make('price')
                    ->label('Offer Price')
                    ->numeric()
                    ->prefix('$') // Using $ as per TourResource
                    ->required(),
                \Filament\Forms\Components\Select::make('target_link')
                    ->label('Target Tour')
                    ->required()
                    ->searchable()
                    ->options(function () {
                        return \App\Models\Tour::active()
                            ->orderBy('title_en')
                            ->pluck('title_en', 'slug')
                            ->map(fn ($title, $slug) => $title)
                            ->toArray();
                    })
                    ->helperText('Select the tour this offer links to'),
                \Filament\Forms\Components\FileUpload::make('image')
                    ->label('Offer Image')
                    ->image()
                    ->disk('public')
                    ->directory('offers')
                    ->required(),
                \Filament\Forms\Components\Toggle::make('active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Only one active offer will be shown on the homepage'),
            ]);
    }
}
