<?php

namespace App\Filament\Resources\ContactLeads\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactLeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('interest')
                ->options([
                    'day-tours' => 'Day Tours', 
                    'nile-cruises' => 'Nile Cruises',
                    'holiday-packages' => 'Holiday Packages',
                    'custom' => 'Custom',
                ])
                ->native(false),

            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('email')->email()->required()->maxLength(255),
            TextInput::make('phone')->tel()->maxLength(50),
            TextInput::make('adults')->numeric()->default(1)->minValue(1),
            TextInput::make('children')->numeric()->default(0)->minValue(0),

            Select::make('status')
                ->options([
                    'new' => 'New',
                    'in_progress' => 'In Progress',
                    'resolved' => 'Resolved',
                ])
                ->native(false)
                ->default('new'),

            Textarea::make('message')->required(),
        ]);
    }
}
