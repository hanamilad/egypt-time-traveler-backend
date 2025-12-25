<?php

namespace App\Filament\Resources\SocialVideos;

use App\Filament\Resources\SocialVideos\Pages\CreateSocialVideo;
use App\Filament\Resources\SocialVideos\Pages\EditSocialVideo;
use App\Filament\Resources\SocialVideos\Pages\ListSocialVideos;
use App\Filament\Resources\SocialVideos\Schemas\SocialVideoForm;
use App\Filament\Resources\SocialVideos\Tables\SocialVideosTable;
use App\Models\SocialVideo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SocialVideoResource extends Resource
{
    protected static ?string $model = SocialVideo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'url';

    public static function form(Schema $schema): Schema
    {
        return SocialVideoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SocialVideosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSocialVideos::route('/'),
            'create' => CreateSocialVideo::route('/create'),
            'edit' => EditSocialVideo::route('/{record}/edit'),
        ];
    }
}
