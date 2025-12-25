<?php

namespace App\Filament\Resources\ContactLeads\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Schema;

class ContactLeadInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Placeholder::make('name')->label('Name'),
            Placeholder::make('email')->label('Email'),
            Placeholder::make('phone')->label('Phone'),
            Placeholder::make('interest')->label('Interest'),
            Placeholder::make('adults')->label('Adults'),
            Placeholder::make('children')->label('Children'),
            Placeholder::make('status')->label('Status'),
            Placeholder::make('message')->label('Message'),
            Placeholder::make('created_at')->label('Created At'),
            Placeholder::make('updated_at')->label('Updated At'),
        ]);
    }
}

