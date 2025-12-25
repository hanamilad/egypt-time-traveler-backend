<?php

namespace App\Filament\Resources\TourResource\Pages;

use App\Filament\Resources\TourResource;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Schemas\Schema;

class ManageAvailabilities extends ManageRelatedRecords
{
    protected static string $resource = TourResource::class;

    protected static string $relationship = 'availabilities';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-calendar-days';

    public static function getNavigationLabel(): string
    {
        return 'Availabilities';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\DatePicker::make('date')
                    ->label('Date')
                    ->required()
                    ->native(false)
                    ->displayFormat('Y-m-d')
                    ->minDate(now()),
                Forms\Components\TextInput::make('available_seats')
                    ->label('Available Seats')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->default(12),
                Forms\Components\TextInput::make('special_price')
                    ->label('Special Price')
                    ->numeric()
                    ->prefix('$')
                    ->helperText('Leave empty to use the default tour price'),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'available' => 'Available',
                        'sold_out' => 'Sold Out',
                    ])
                    ->default('available')
                    ->required(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('available_seats')
                    ->label('Seats')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state <= 3 => 'warning',
                        default => 'success',
                    }),
                Tables\Columns\TextColumn::make('special_price')
                    ->label('Special Price')
                    ->money('USD')
                    ->placeholder('Default price'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'sold_out' => 'danger',
                    }),
            ])
            ->defaultSort('date', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'sold_out' => 'Sold Out',
                    ]),
            ])
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
            ->emptyStateHeading('No availability dates')
            ->emptyStateDescription('Add available dates for this tour.');
    }
}
