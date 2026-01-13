<?php

namespace App\Filament\Resources\TourResource\Pages;

use App\Filament\Resources\TourResource;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Schemas\Schema;

class ManageReviews extends ManageRelatedRecords
{
    protected static string $resource = TourResource::class;

    protected static string $relationship = 'reviews';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function getNavigationLabel(): string
    {
        return 'Reviews';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('author')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5),
                Forms\Components\Textarea::make('comment')
                    ->label('Comment')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('author')
            ->columns([
                Tables\Columns\TextColumn::make('author')->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->comment),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                    }),
                 Tables\Columns\ImageColumn::make('photos.path')
                    ->label('Photos')
                    ->disk('public')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->headerActions([
                \Filament\Actions\CreateAction::make(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
