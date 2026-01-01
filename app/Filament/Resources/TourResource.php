<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Models\Tour;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Illuminate\Support\Str;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-globe-alt';

    public static function getNavigationGroup(): ?string
    {
        return 'Tours Management';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Forms\Components\TextInput::make('title_en')
                ->label('Title (EN)')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (string $state, $set) => $set('slug', Str::slug($state))),
            \Filament\Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),
            \Filament\Forms\Components\TextInput::make('title_de')
                ->label('Title (DE)')
                ->required(),
            \Filament\Forms\Components\Select::make('city')
                ->options([
                    'cairo' => 'Cairo',
                    'luxor' => 'Luxor',
                    'aswan' => 'Aswan',
                    'alexandria' => 'Alexandria',
                    'hurghada' => 'Hurghada',
                ])
                ->required(),

            \Filament\Forms\Components\TextInput::make('price')
                ->numeric()
                ->prefix('$')
                ->required()
                ->live(onBlur: true),
            \Filament\Forms\Components\TextInput::make('original_price')
                ->numeric()
                ->prefix('$')
                ->live(onBlur: true),
            \Filament\Forms\Components\Placeholder::make('discount_percentage')
                ->label('Discount Percentage')
                ->content(function ($get) {
                    $price = $get('price');
                    $originalPrice = $get('original_price');

                    if ($price && $originalPrice && $originalPrice > $price) {
                        $discount = (($originalPrice - $price) / $originalPrice) * 100;
                        return number_format($discount, 2) . '% OFF';
                    }

                    return 'No Discount';
                }),
            \Filament\Forms\Components\TextInput::make('child_discount_percent')
                ->label('Child Discount %')
                ->numeric()
                ->suffix('%')
                ->minValue(0)
                ->maxValue(100)
                ->default(0)
                ->helperText('Percentage discount for children'),
            \Filament\Forms\Components\TextInput::make('duration_hours')
                ->numeric()
                ->suffix('Hours'),
            \Filament\Forms\Components\TextInput::make('duration_days')
                ->numeric()
                ->suffix('Days'),

            \Filament\Forms\Components\TextInput::make('max_group')
                ->numeric()
                ->default(12),
            \Filament\Forms\Components\FileUpload::make('image')
                ->label('Main Image')
                ->image()
                ->disk('public')
                ->directory('tours')
                ->required(),
            \Filament\Forms\Components\Textarea::make('short_desc_en')
                ->label('Short Description (EN)')
                ->rows(3)
                ->required(),
            \Filament\Forms\Components\Textarea::make('short_desc_de')
                ->label('Short Description (DE)')
                ->rows(3)
                ->required(),
            \Filament\Forms\Components\Toggle::make('featured'),
            \Filament\Forms\Components\Toggle::make('is_package')
                ->label('Holiday Package'),
            \Filament\Forms\Components\Select::make('status')
                ->options([
                    'active' => 'Active',
                    'draft' => 'Draft',
                    'archived' => 'Archived',
                ])
                ->default('active')
                ->required(),
            \Filament\Forms\Components\RichEditor::make('full_desc_en')
                ->label('Full Description (EN)')
                ->required()
                ->columnSpanFull(),
            \Filament\Forms\Components\RichEditor::make('full_desc_de')
                ->label('Full Description (DE)')
                ->required()
                ->columnSpanFull(),
            \Filament\Forms\Components\TagsInput::make('highlights_en')
                ->label('Highlights (EN)')
                ->columnSpanFull(),
            \Filament\Forms\Components\TagsInput::make('highlights_de')
                ->label('Highlights (DE)')
                ->columnSpanFull(),
            \Filament\Forms\Components\TagsInput::make('included_en')
                ->label('Included (EN)')
                ->columnSpanFull(),
            \Filament\Forms\Components\TagsInput::make('included_de')
                ->label('Included (DE)')
                ->columnSpanFull(),
            \Filament\Forms\Components\TagsInput::make('not_included_en')
                ->label('Not Included (EN)')
                ->columnSpanFull(),
            \Filament\Forms\Components\TagsInput::make('not_included_de')
                ->label('Not Included (DE)')
                ->columnSpanFull(),

            \Filament\Forms\Components\Repeater::make('images')
                ->relationship()
                ->schema([
                    \Filament\Forms\Components\FileUpload::make('url')
                        ->label('Image')
                        ->image()
                        ->disk('public')
                        ->directory('tour-gallery')
                        ->required(),
                    \Filament\Forms\Components\TextInput::make('alt_en')->label('Alt Text (EN)'),
                    \Filament\Forms\Components\TextInput::make('alt_de')->label('Alt Text (DE)'),
                    \Filament\Forms\Components\Toggle::make('is_primary')->label('Primary?'),
                ]),


        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('title_en')->searchable()->sortable()->limit(30),
                Tables\Columns\TextColumn::make('city')->sortable(),
                Tables\Columns\TextColumn::make('price')->money('USD')->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric(1)
                    ->sortable(),
                Tables\Columns\TextColumn::make('review_count')
                    ->label('Reviews')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('featured')->boolean(),
                Tables\Columns\IconColumn::make('is_package')
                    ->label('Package')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'draft' => 'warning',
                        'archived' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')->date(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('city')
                    ->options([
                        'cairo' => 'Cairo',
                        'luxor' => 'Luxor',
                        'aswan' => 'Aswan',
                        'alexandria' => 'Alexandria',
                        'hurghada' => 'Hurghada',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'draft' => 'Draft',
                        'archived' => 'Archived',
                    ]),
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\Action::make('reviews')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->url(fn (Tour $record) => TourResource::getUrl('reviews', ['record' => $record])),
                \Filament\Actions\Action::make('pricing')
                    ->icon('heroicon-o-currency-dollar')
                    ->url(fn (Tour $record) => TourResource::getUrl('pricing', ['record' => $record])),
                \Filament\Actions\Action::make('faqs')
                    ->icon('heroicon-o-question-mark-circle')
                    ->url(fn (Tour $record) => TourResource::getUrl('faqs', ['record' => $record])),
                \Filament\Actions\Action::make('itineraries')
                    ->icon('heroicon-o-map')
                    ->url(fn (Tour $record) => TourResource::getUrl('itineraries', ['record' => $record])),
                \Filament\Actions\Action::make('availabilities')
                    ->icon('heroicon-o-calendar-days')
                    ->url(fn (Tour $record) => TourResource::getUrl('availabilities', ['record' => $record])),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
            'reviews' => Pages\ManageReviews::route('/{record}/reviews'),
            'pricing' => Pages\ManagePricing::route('/{record}/pricing'),
            'faqs' => Pages\ManageFaqs::route('/{record}/faqs'),
            'itineraries' => Pages\ManageItineraries::route('/{record}/itineraries'),
            'availabilities' => Pages\ManageAvailabilities::route('/{record}/availabilities'),
        ];
    }
}