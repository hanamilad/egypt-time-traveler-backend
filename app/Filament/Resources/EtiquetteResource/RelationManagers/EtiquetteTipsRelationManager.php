<?php

namespace App\Filament\Resources\EtiquetteResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\CreateAction;

class EtiquetteTipsRelationManager extends RelationManager
{
    protected static string $relationship = 'tips';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Forms\Components\TextInput::make('title_en')->maxLength(255),
            \Filament\Forms\Components\TextInput::make('title_de')->maxLength(255),
            \Filament\Forms\Components\Textarea::make('description_en'),
            \Filament\Forms\Components\Textarea::make('description_de'),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title_en')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('title_de')->sortable()->searchable(),
        ])->recordActions([
            EditAction::make(),
            DeleteAction::make(),
        ]);
    }
    protected function getTableHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

