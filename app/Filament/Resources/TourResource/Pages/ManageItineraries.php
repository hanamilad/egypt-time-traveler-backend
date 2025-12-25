<?php

namespace App\Filament\Resources\TourResource\Pages;

use App\Filament\Resources\TourResource;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Schemas\Schema;

class ManageItineraries extends ManageRelatedRecords
{
    protected static string $resource = TourResource::class;

    protected static string $relationship = 'itineraries';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map';

    public static function getNavigationLabel(): string
    {
        return 'Itineraries';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('day_number')
                    ->label('Day Number')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->minValue(1),
                Forms\Components\TextInput::make('time')
                    ->label('Time')
                    ->type('time'),
                Forms\Components\TextInput::make('title_en')
                    ->label('Title (English)')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description_en')
                    ->label('Description (English)')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('title_de')
                    ->label('Title (German)')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description_de')
                    ->label('Description (German)')
                    ->rows(4)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title_en')
            ->columns([
                Tables\Columns\TextColumn::make('day_number')
                    ->label('Day')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('time')
                    ->label('Time')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->title_en),
                Tables\Columns\TextColumn::make('title_de')
                    ->label('Title (DE)')
                    ->limit(40)
                    ->toggleable()
                    ->tooltip(fn ($record) => $record->title_de),
            ])
            ->defaultSort('day_number', 'asc')
            ->reorderable('day_number')
            ->headerActions([
                \Filament\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                \Filament\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus'),
            ])
            ->emptyStateHeading('No itinerary yet')
            ->emptyStateDescription('Create the first day of your tour itinerary.');
    }
}
