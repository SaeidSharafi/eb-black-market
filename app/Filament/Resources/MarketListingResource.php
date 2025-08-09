<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarketListingResource\Pages;
use App\Filament\Resources\MarketListingResource\RelationManagers;
use App\Models\Item;
use App\Models\MarketListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MarketListingResource extends Resource
{
    protected static ?string $model = MarketListing::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function getNavigationLabel(): string
    {
        return __('resources.market_listings.navigation');
    }

    public static function getLabel(): string
    {
        return __('resources.market_listings.label');
    }

    public static function getPluralLabel(): string
    {
        return __('resources.market_listings.plural_label');
    }

    public static function form(Form $form): Form
    {
        $locale = app()->getLocale();

        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Select::make('user_id')
                        ->label(__('resources.market_listings.fields.seller'))
                        ->default(auth()->id())
                        ->searchable()
                        ->preload()
                        ->relationship('user', 'name')
                        ->required(),
                    Forms\Components\Select::make('item_id')
                        ->label(__('resources.market_listings.fields.item'))
                        ->allowHtml()
                        ->required()
                        ->searchable()
                        ->options(
                            Item::all()->mapWithKeys(function ($item) {
                                return [$item->getKey() => static::getCleanOptionString($item)];
                            })
                        )
                        ->getSearchResultsUsing(function (string $search) use ($locale) {
                            $lowerCaseSearchTerm = '%' . $search . '%';
                            $items = Item::whereRaw(
                                "JSON_SEARCH(LOWER(JSON_EXTRACT(name, '$.*')), 'one', LOWER(?)) IS NOT NULL",
                                [$lowerCaseSearchTerm]
                            )->get();
                            return $items->mapWithKeys(function ($item) {
                                return [$item->getKey() => static::getCleanOptionString($item)];
                            })->toArray();
                        }),
                    Forms\Components\TextInput::make('quantity')
                        ->label(__('resources.market_listings.fields.quantity'))
                        ->numeric()
                        ->default(1)
                        ->required(),

                    Forms\Components\TextInput::make('quantity_per_bundle') // Corrected typo
                    ->label(__('resources.market_listings.fields.quantity_per_bundle'))
                        ->numeric()
                        ->default(1)
                        ->required(),

                    Forms\Components\Select::make('status')
                        ->label(__('resources.market_listings.fields.status'))
                        ->options([
                            'active'   => __('resources.market_listings.status.active'),
                            'inactive' => __('resources.market_listings.status.inactive'),
                            'sold'     => __('resources.market_listings.status.sold'),
                        ])
                        ->default('active')
                        ->required(),
                ])->columns(2),
                Forms\Components\Section::make(__('resources.market_listings.sections.prices'))
                    ->description(__('resources.market_listings.sections.prices_description'))
                    ->schema([
                        Forms\Components\TextInput::make('price_qrk')
                            ->label(__('resources.market_listings.fields.price_qrk'))->numeric(),
                        Forms\Components\TextInput::make('price_not')
                            ->label(__('resources.market_listings.fields.price_not'))->numeric(),
                        Forms\Components\TextInput::make('price_ton')
                            ->label(__('resources.market_listings.fields.price_ton'))->numeric(),
                        Forms\Components\TextInput::make('price_usd')
                            ->label(__('resources.market_listings.fields.price_usd'))->numeric(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('item.image')
                    ->label('')
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('item.name')
                    ->label(__('resources.market_listings.fields.item_name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('resources.market_listings.fields.seller'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.telegram_username')
                    ->label(__('resources.market_listings.fields.telegram'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('resources.market_listings.fields.quantity'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_per_bundle')
                    ->label(__('resources.market_listings.fields.quantity_per_bundle')),
                Tables\Columns\TextColumn::make('price_qrk')->label(__('resources.market_listings.fields.price_qrk'))
                    ->money('QRK')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('price_not')->label(__('resources.market_listings.fields.price_not'))
                    ->money('NOT')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('price_ton')->label(__('resources.market_listings.fields.price_ton'))
                    ->money('TON')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('price_usd')->label(__('resources.market_listings.fields.price_usd'))
                    ->money('USD')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')->label(__('resources.market_listings.fields.status'))->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active'   => 'Active',
                        'inactive' => 'Inactive',
                    ]),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index'  => Pages\ListMarketListings::route('/'),
            'create' => Pages\CreateMarketListing::route('/create'),
            'edit'   => Pages\EditMarketListing::route('/{record}/edit'),
        ];
    }

    public static function getCleanOptionString(Item $model): string
    {
        return
            view('filament.components.select-item-result')
                ->with('name', $model?->name)
                ->with('image', $model?->image)
                ->render();
    }
}
