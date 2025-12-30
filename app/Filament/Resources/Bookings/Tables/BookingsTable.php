<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\TourAvailability;
use App\Models\Booking;
use App\Services\AvailabilityService;
use App\Mail\TourClosingNotification;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_reference')
                    ->label('Reference')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('tour.title_en')
                    ->label('Tour')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                TextColumn::make('date')
                    ->label('Tour Date')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),
                TextColumn::make('name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('travelers')
                    ->label('Travelers')
                    ->badge()
                    ->formatStateUsing(fn ($state, $record) => "{$record->adults}A + {$record->children}C"),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'paid' => 'success',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unpaid' => 'danger',
                        'partial' => 'warning',
                        'paid' => 'success',
                        'refunded' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Booked At')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                        'refunded' => 'Refunded',
                    ]),
                \Filament\Tables\Filters\Filter::make('date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        \Filament\Forms\Components\DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('date', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('date', '<=', $date));
                    }),
            ])
            ->defaultSort('date', 'desc')
            ->recordActions([
                EditAction::make(),
                Action::make('accept_trip')
                    ->label("Accept the trip")
                    ->hidden(fn (Booking $record) => 
                        app(AvailabilityService::class)->isDateClosed($record->date->format('Y-m-d'))
                    )
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation(function (Booking $record) {
                        return Booking::where('tour_id', $record->tour_id)
                            ->whereDate('date', $record->date)
                            ->where('id', '!=', $record->id)
                            ->exists();
                    })
                    ->modalHeading("Accept trip and close date?")
                    ->modalDescription("There are other bookings for this tour on this day. They will be notified that the tour is now closed.")
                    ->form(function (Booking $record) {
                        $hasOtherBookings = Booking::where('tour_id', $record->tour_id)
                            ->whereDate('date', $record->date)
                            ->where('id', '!=', $record->id)
                            ->exists();

                        if (!$hasOtherBookings) {
                            return [];
                        }

                        return [
                            Textarea::make('message')
                                ->label('Notification Message')
                                ->placeholder('Enter the message to send to other customers...')
                                ->required()
                                ->rows(5)
                                ->default('We are sorry, but this tour date is now closed as it has reached maximum capacity or the guide is no longer available.'),
                        ];
                    })
                    ->action(function (Booking $record, array $data) {
                        // 1. Update the chosen booking to confirmed
                        $record->update(['status' => 'confirmed']);

                        // 2. Close availability GLOBALLY for this date (All tours)
                        app(AvailabilityService::class)->closeDate($record->date->format('Y-m-d'));
                        
                        // 3. Find OTHER bookings for the same tour and date
                        $otherBookings = Booking::where('tour_id', $record->tour_id)
                            ->whereDate('date', $record->date)
                            ->where('id', '!=', $record->id)
                            ->get();

                        // 4. Send emails only if message is provided and bookings exist
                        if (!empty($data['message']) && $otherBookings->count() > 0) {
                            foreach ($otherBookings as $booking) {
                                if ($booking->email) {
                                    Mail::to($booking->email)->send(new TourClosingNotification($booking, $data['message']));
                                }
                            }
                        }
                        
                        Notification::make()
                            ->title($otherBookings->count() > 0 
                                ? "Trip accepted, date closed globally, and notifications sent." 
                                : "Trip accepted and date closed globally.")
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
