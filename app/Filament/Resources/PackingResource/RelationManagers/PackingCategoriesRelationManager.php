<?php

namespace App\Filament\Resources\PackingResource\RelationManagers;

use Filament\Actions\CreateAction as ActionsCreateAction;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;


class PackingCategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'categories';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Forms\Components\TextInput::make('name_en')->maxLength(255),
            \Filament\Forms\Components\TextInput::make('name_de')->maxLength(255),
            Repeater::make('items_en')
                ->label('Items (EN)')
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
                ->label('Items (DE)')
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

    public function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name_en')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('name_de')->sortable()->searchable(),
        ])->recordActions([
            EditAction::make(),
            DeleteAction::make(),
        ]);
    }
    protected function getTableHeaderActions(): array
    {
        return [
            ActionsCreateAction::make(),
        ];
    }
}
