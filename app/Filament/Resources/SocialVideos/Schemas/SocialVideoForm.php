<?php

namespace App\Filament\Resources\SocialVideos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SocialVideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('platform')
                    ->options([
                        'youtube' => 'YouTube'
                    ])
                    ->required(),
                TextInput::make('url')
                    ->url()
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
