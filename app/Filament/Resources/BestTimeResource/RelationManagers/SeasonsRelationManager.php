<?php

namespace App\Filament\Resources\BestTimeResource\RelationManagers;

use App\Enums\SeasonName;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class SeasonsRelationManager extends RelationManager
{
    protected static string $relationship = 'seasons';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Forms\Components\Select::make('season_name')->options([
                SeasonName::winter->value => 'winter',
                SeasonName::spring->value => 'spring',
                SeasonName::summer->value => 'summer',
                SeasonName::fall->value => 'fall',
            ]),
            \Filament\Forms\Components\TextInput::make('name_en')->maxLength(255),
            \Filament\Forms\Components\TextInput::make('name_de')->maxLength(255),
            \Filament\Forms\Components\Textarea::make('description_en'),
            \Filament\Forms\Components\Textarea::make('description_de'),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('season_name')->sortable(),
            Tables\Columns\TextColumn::make('name_en')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('name_de')->sortable()->searchable(),
        ])->recordActions([
            EditAction::make(),
            DeleteAction::make(),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
