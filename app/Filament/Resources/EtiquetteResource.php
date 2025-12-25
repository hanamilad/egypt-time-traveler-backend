<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EtiquetteResource\Pages;
use App\Filament\Resources\EtiquetteResource\RelationManagers\EtiquetteTipsRelationManager;
use App\Models\Etiquette;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;

class EtiquetteResource extends Resource
{
    protected static ?string $model = Etiquette::class;
    protected static UnitEnum|string|null $navigationGroup = 'tips-advice';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Forms\Components\TextInput::make('title_en')->maxLength(255),
            \Filament\Forms\Components\TextInput::make('title_de')->maxLength(255),
            \Filament\Forms\Components\Textarea::make('intro_en'),
            \Filament\Forms\Components\Textarea::make('intro_de'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('title_en')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('title_de')->searchable()->sortable(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            EtiquetteTipsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEtiquette::route('/'),
            'create' => Pages\CreateEtiquette::route('/create'),
            'view' => Pages\ViewEtiquette::route('/{record}'),
            'edit' => Pages\EditEtiquette::route('/{record}/edit'),
        ];
    }
}
