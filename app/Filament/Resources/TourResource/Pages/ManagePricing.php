<?php

namespace App\Filament\Resources\TourResource\Pages;

use App\Filament\Resources\TourResource;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Schemas\Schema;

class ManagePricing extends ManageRelatedRecords
{
    protected static string $resource = TourResource::class;

    protected static string $relationship = 'pricings';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-currency-dollar';

    public static function getNavigationLabel(): string
    {
        return 'Custom Pricing';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('people_count')
                    ->label('Number of People')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->helperText('Condition: When booking has this number of people.'),
                
                Forms\Components\TextInput::make('price')
                    ->label('Total Price')
                    ->numeric()
                    ->prefix('$')
                    ->required()
                    ->minValue(0)
                    ->helperText('The total price for the entire group.'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('people_count')
            ->columns([
                Tables\Columns\TextColumn::make('people_count')
                    ->label('People Count')
                    ->sortable()
                    ->badge(),

                // Inline Editing Enabled
                Tables\Columns\TextInputColumn::make('price')
                    ->label('Total Price')
                    ->type('number')
                    ->rules(['numeric', 'min:0'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('price_per_person')
                    ->label('Price Per Person (Calc)')
                    ->prefix('$')
                    ->state(fn ($record) => $record->people_count > 0 ? number_format($record->price / $record->people_count, 2) : 0),
            ])
            ->headerActions([
                \Filament\Actions\Action::make('generate_standard')
                    ->label('Generate Standard Rates')
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->action(function (ManagePricing $livewire) {
                        $tour = $livewire->getOwnerRecord();
                        $basePrice = $tour->price;
                        $maxGroup = $tour->max_group;

                        for ($i = 1; $i <= $maxGroup; $i++) {
                             $tour->pricings()->firstOrCreate(
                                 ['people_count' => $i],
                                 ['price' => $basePrice * $i]
                             );
                        }
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Rates Generated')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('people_count');
    }
}
