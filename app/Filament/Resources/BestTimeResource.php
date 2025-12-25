<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BestTimeResource\Pages;
use App\Filament\Resources\BestTimeResource\RelationManagers\SeasonsRelationManager;
use App\Models\BestTime;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;

class BestTimeResource extends Resource
{
    protected static ?string $model = BestTime::class;
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
            SeasonsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBestTime::route('/'),
            'create' => Pages\CreateBestTime::route('/create'),
            'view' => Pages\ViewBestTime::route('/{record}'),
            'edit' => Pages\EditBestTime::route('/{record}/edit'),
        ];
    }
}
