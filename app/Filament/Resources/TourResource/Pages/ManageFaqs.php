<?php

namespace App\Filament\Resources\TourResource\Pages;

use App\Filament\Resources\TourResource;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Schemas\Schema;

class ManageFaqs extends ManageRelatedRecords
{
    protected static string $resource = TourResource::class;

    protected static string $relationship = 'faqs';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function getNavigationLabel(): string
    {
        return 'FAQs';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('question_en')
                    ->label('Question (English)')
                    ->required()
                    ->maxLength(500)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('answer_en')
                    ->label('Answer (English)')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('question_de')
                    ->label('Question (German)')
                    ->maxLength(500)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('answer_de')
                    ->label('Answer (German)')
                    ->rows(4)
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question_en')
            ->columns([
                Tables\Columns\TextColumn::make('question_en')
                    ->label('Question (EN)')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->question_en),
                Tables\Columns\TextColumn::make('question_de')
                    ->label('Question (DE)')
                    ->limit(50)
                    ->toggleable()
                    ->tooltip(fn ($record) => $record->question_de),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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
            ->emptyStateHeading('No FAQs yet')
            ->emptyStateDescription('Create your first FAQ to help customers understand this tour better.');
    }
}
