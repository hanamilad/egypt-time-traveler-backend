<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackingResource\Pages;
use App\Filament\Resources\PackingResource\RelationManagers\PackingCategoriesRelationManager;
use App\Models\Packing;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;

class PackingResource extends Resource
{
    protected static ?string $model = Packing::class;
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
            PackingCategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPacking::route('/'),
            'create' => Pages\CreatePacking::route('/create'),
            'view' => Pages\ViewPacking::route('/{record}'),
            'edit' => Pages\EditPacking::route('/{record}/edit'),
        ];
    }
}
