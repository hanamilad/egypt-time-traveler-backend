<?php

namespace App\Filament\Resources\ContactLeads\Tables;

use App\Models\ContactLead;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Action;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select as SelectField;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactLeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->sortable()->searchable(),
                TextColumn::make('email')->label('Email')->sortable()->searchable(),
                TextColumn::make('phone')->label('Phone')->sortable()->searchable(),
                TextColumn::make('interest')
                    ->label('Interest')
                    ->badge()
                    ->colors([
                        'info' => ['day-tours', 'nile-cruises'],
                        'warning' => ['holiday-packages'],
                        'success' => ['custom'],
                    ]),
                TextColumn::make('adults')->label('Adults')->sortable(),
                TextColumn::make('children')->label('Children')->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => 'new',
                        'info' => 'in_progress',
                        'success' => 'resolved',
                    ])
                    ->sortable(),
                TextColumn::make('created_at')->label('Created')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'in_progress' => 'In Progress',
                        'resolved' => 'Resolved',
                    ]),
                SelectFilter::make('interest')
                    ->options([
                        'day-tours' => 'Day Tours',
                        'nile-cruises' => 'Nile Cruises',
                        'holiday-packages' => 'Holiday Packages',
                        'custom' => 'Custom',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('changeStatus')
                    ->label('Change Status')
                    ->form([
                        SelectField::make('status')
                            ->options([
                                'new' => 'New',
                                'in_progress' => 'In Progress',
                                'resolved' => 'Resolved',
                            ])
                            ->required(),
                    ])
                    ->action(function (ContactLead $record, array $data): void {
                        $record->update(['status' => $data['status']]);
                    }),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make(),
                ]),
            ])
            ->recordClasses(fn (ContactLead $record) => match ($record->status) {
                'new' => 'border-s-2 border-yellow-600 dark:border-yellow-300',
                'in_progress' => 'border-s-2 border-blue-600 dark:border-blue-300',
                'resolved' => 'border-s-2 border-green-600 dark:border-green-300',
                default => null,
            });
    }
}
