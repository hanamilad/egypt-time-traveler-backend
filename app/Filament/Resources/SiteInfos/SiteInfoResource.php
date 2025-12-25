<?php

namespace App\Filament\Resources\SiteInfos;

use App\Filament\Resources\SiteInfos\Pages\CreateSiteInfo;
use App\Filament\Resources\SiteInfos\Pages\EditSiteInfo;
use App\Filament\Resources\SiteInfos\Pages\ListSiteInfos;
use App\Filament\Resources\SiteInfos\Schemas\SiteInfoForm;
use App\Filament\Resources\SiteInfos\Tables\SiteInfosTable;
use App\Models\SiteInfo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SiteInfoResource extends Resource
{
    protected static ?string $model = SiteInfo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'brand1';

    public static function form(Schema $schema): Schema
    {
        return SiteInfoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SiteInfosTable::configure($table);
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
            'index' => ListSiteInfos::route('/'),
            'create' => CreateSiteInfo::route('/create'),
            'edit' => EditSiteInfo::route('/{record}/edit'),
        ];
    }
}
