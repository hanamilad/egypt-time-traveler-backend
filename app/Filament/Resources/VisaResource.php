<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisaResource\Pages;
use App\Models\Visa;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;

class VisaResource extends Resource
{
    protected static ?string $model = Visa::class;
    protected static UnitEnum|string|null $navigationGroup = 'tips-advice';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title_en')
                ->label('Title (EN)')
                ->required()
                ->maxLength(255),

            TextInput::make('title_de')
                ->label('Title (DE)')
                ->required()
                ->maxLength(255),

            Textarea::make('intro_en')
                ->label('Intro (EN)')
                ->rows(3),

            Textarea::make('intro_de')
                ->label('Intro (DE)')
                ->rows(3),

            Repeater::make('items_en')
                ->label('Visa Items (EN)')
                ->schema([
                    Textarea::make('item')
                        ->label('Item')
                        ->required(),
                ])
                ->afterStateHydrated(function (Repeater $component, $state) {
                    if (is_array($state)) {
                        $component->state(
                            collect($state)
                                ->map(fn($value) => ['item' => $value])
                                ->all()
                        );
                    }
                })
                ->dehydrateStateUsing(
                    fn($state) =>
                    collect($state)->pluck('item')->values()->all()
                )
                ->reorderable(),

            Repeater::make('items_de')
                ->label('Visa Items (DE)')
                ->schema([
                    Textarea::make('item')
                        ->label('Item')
                        ->required(),
                ])
                ->afterStateHydrated(function (Repeater $component, $state) {
                    if (is_array($state)) {
                        $component->state(
                            collect($state)
                                ->map(fn($value) => ['item' => $value])
                                ->all()
                        );
                    }
                })
                ->dehydrateStateUsing(
                    fn($state) =>
                    collect($state)->pluck('item')->values()->all()
                )
                ->reorderable(),

        ]);
    }


    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('title_en')->searchable(false)->sortable(),
            Tables\Columns\TextColumn::make('title_de')->searchable(false)->sortable(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisa::route('/'),
            'create' => Pages\CreateVisa::route('/create'),
            'view' => Pages\ViewVisa::route('/{record}'),
            'edit' => Pages\EditVisa::route('/{record}/edit'),
        ];
    }
}
