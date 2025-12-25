<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('booking_reference')
                    ->label('Booking Reference')
                    ->default(fn () => 'BK-' . strtoupper(uniqid()))
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('tour_id')
                    ->label('Tour')
                    ->relationship('tour', 'title_en')
                    ->searchable()
                    ->required()
                    ->preload(),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('travelers')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('adults')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('children')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('price_per_adult')
                    ->required()
                    ->numeric(),
                TextInput::make('price_per_child')
                    ->required()
                    ->numeric(),
                TextInput::make('price_per_person')
                    ->required()
                    ->numeric(),
                TextInput::make('pickup_location')
                    ->default(null),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('total_price')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'paid' => 'Paid',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
        ])
                    ->default('pending')
                    ->required(),
                Select::make('payment_status')
                    ->options(['unpaid' => 'Unpaid', 'partial' => 'Partial', 'paid' => 'Paid', 'refunded' => 'Refunded'])
                    ->default('unpaid')
                    ->required(),
                TextInput::make('payment_method')
                    ->default(null),
                TextInput::make('payment_reference')
                    ->default(null),
            ]);
    }
}
