<?php

namespace App\Filament\Resources\SiteInfos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\KeyValue;
use Filament\Schemas\Schema;

class SiteInfoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('brand1')
                ->label('العلامة 1')
                ->required(),
            TextInput::make('brand2')
                ->label('العلامة 2')
                ->required(),
            TextInput::make('tagline')
                ->label('سطر الوصف')
                ->nullable(),
            TextInput::make('address')
                ->label('العنوان')
                ->nullable(),
            TextInput::make('phone')
                ->label('الهاتف')
                ->nullable(),
            TextInput::make('email')
                ->label('البريد الإلكتروني')
                ->email()
                ->nullable(),
            TextInput::make('availability')
                ->label('التواجد')
                ->nullable(),
            KeyValue::make('social_links')
                ->label('روابط التواصل الاجتماعي')
                ->keyLabel('المنصة')
                ->valueLabel('الرابط')
                ->nullable(),
        ]);
    }
}
