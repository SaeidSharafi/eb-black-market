<?php

namespace App\Livewire;

use App\Enum\ItemRarityEnum;
use App\Enum\ItemTypeEnum;
use App\Models\MarketListing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class MarketListingTable extends PowerGridComponent
{
    public string $tableName = 'market-listing-table-kbja9x-table';
    public bool $showFilters = true;
    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';
    public bool $measurePerformance = true;
    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),

        ];
    }

    public function datasource(): Builder
    {
        $tonPrice = (float) cache()->get('ton_usdt_price', 0);
        $qrkPrice = (float) cache()->get('qrk_usdt_price', 0);
        $notPrice = (float) cache()->get('not_usdt_price', 0);
        $usdPrice = 1.0; // USD to USDT is 1:1

        return MarketListing::query()
            ->with(['item', 'user'])
            ->join('items', 'market_listings.item_id', '=', 'items.id')
            ->join('users', 'market_listings.user_id', '=', 'users.id')
            ->select(
                'market_listings.*',
                'users.telegram_username',
                DB::raw("
            (
                (COALESCE(price_ton, 0) * {$tonPrice}) +
                (COALESCE(price_qrk, 0) * {$qrkPrice}) +
                (COALESCE(price_not, 0) * {$notPrice}) +
                (COALESCE(price_usd, 0) * {$usdPrice})
            )
            /
            NULLIF(
                (CASE WHEN price_ton > 0 THEN 1 ELSE 0 END) +
                (CASE WHEN price_qrk > 0 THEN 1 ELSE 0 END) +
                (CASE WHEN price_not > 0 THEN 1 ELSE 0 END) +
                (CASE WHEN price_usd > 0 THEN 1 ELSE 0 END),
                0
            )
             as avg_price_usdt")
            );
    }

    public function relationSearch(): array
    {
        return [
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('item_name', function (MarketListing $listing) {
                $name = $listing->item->getTranslation('name', app()->getLocale());
                return Blade::render(<<<HTML
                        <span class="whitespace-break-spaces">{$name}</span>
                    HTML
                );
            })
            ->add('item_type', fn(MarketListing $listing) => __('enums.ItemTypeEnum.'.$listing->item->type))
            ->add('created_at_formatted', fn(MarketListing $listing) => $listing->created_at->diffForHumans())
            ->add('item_image', function (MarketListing $listing) {
                $itemName = e($listing->item->getTranslation('name', app()->getLocale()));
                $hideRarityTag = ItemTypeEnum::tryFrom($listing->item->type)?->isEquipment() ? 'inline-block' : 'hidden';

                if ($listing->item->image) {
                    $imageUrl = asset('storage/'.$listing->item->image);
                    return Blade::render(<<<HTML
                    <div class="{$listing->item->rarity->getRarityColor()} w-16 h-16 p-2 rounded-lg relative overflow-hidden">
                    <span class="text-xs absolute bottom-0 left-0 w-full text-center bg-black/75 text-white {$hideRarityTag} px-1">{$listing->item->rarity->translate()}</span>
                        <img src="{$imageUrl}" alt="{$itemName}" class="object-fill h-full w-full ">
                    </div>
                    HTML
                    );
                }
                return Blade::render(<<<HTML
                <div class="{$listing->item->rarity->getRarityColor()} w-16 h-16 p-2 rounded-lg relative overflow-hidden">
                    <span class="text-xs absolute bottom-0 left-0 w-full text-center bg-black/75 text-white px-1 {$hideRarityTag}">{$listing->item->rarity->translate()}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 18" /></svg>
                    </div>
                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded shadow flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 18" /></svg>
                    </div>
                HTML
                );
            })
            ->add('prices', function (MarketListing $listing) {
                $startDiv = '<div class="flex flex-col">';
                $prices = "";
                if ($listing->price_qrk) {
                    $prices .= $this->formatPrice('QRK', $listing->price_qrk);
                }
                if ($listing->price_not) {
                    $prices .= $this->formatPrice('NOT', $listing->price_qrk);
                };
                if ($listing->price_ton) {
                    $prices .= $this->formatPrice('TON', $listing->price_ton);
                };
                if ($listing->price_usd) {
                    $prices .= $this->formatPrice('USD', $listing->price_qrk);
                }
                $endDiv = '</div>';

                if (!$prices) {
                    return $startDiv.'<span class="text-gray-400">'.__('resources.home.na').'</span>'.$endDiv;
                }
                return $startDiv.$prices.$endDiv;
            })
            ->add('avg_prices', function (MarketListing $listing) {
                $avgPrice = (float) $listing->avg_price_usdt;
                if ($avgPrice <= 0) {
                    return '<span class="text-gray-400">'.__('resources.home.na').'</span>';
                }

                return "<span>".number_format($avgPrice, 2)
                    ."<span class='font-bold text-green-400'> USDT</span></span>";
            })
            ->add('seller', function (MarketListing $listing) {
                if ($listing->user && $listing->user->telegram_username) {
                    $username = e($listing->user->telegram_username);
                    $contactSeller = __('resources.home.contact_seller');
                    return Blade::render(<<<HTML
                        <a rel="noopener noreferrer"
                                    class="w-full text-center block bg-yellow-600 hover:bg-yellow-700 text-black font-bold py-1 px-1 rounded-lg transition text-sm"
                                    href="https://t.me/{$username}" target="_blank" >{$contactSeller}</a>
                    HTML
                    );
                }
                return '<span class="text-gray-400">'.__('resources.home.na').'</span>';
            });
    }

    public function columns(): array
    {
        return [
            Column::make('', 'seller', 'users.telegram_username')
                ->searchable(),
            Column::make(__('resources.items.fields.rarity'), 'item_image')
                ->bodyAttribute('w-20'),

            Column::make(__('resources.home.item_name'), 'item_name', 'items.name')
                ->sortable()
                ->searchableRaw("JSON_SEARCH(LOWER(JSON_EXTRACT(items.name, '$.*')), 'one', LOWER(?)) IS NOT NULL"),
            Column::make(__('resources.home.item_type'), 'item_type', 'items.type')
                ->sortable(),
            Column::make(__('resources.market_listings.fields.quantity'), 'quantity', 'quantity'),
            Column::make(__('resources.market_listings.fields.quantity_per_bundle'), 'quantity_per_bundle',
                'quantity_per_bundle')
            ,
            Column::make(__('resources.home.prices'), 'prices', 'price_qrk'),
            Column::make(__('resources.home.avg_prices'), 'avg_prices', 'avg_price_usdt')
                ->sortable(),

            Column::make(__('resources.home.listed'), 'created_at_formatted', 'created_at')
                ->bodyAttribute('text-xs text-gray-500')
                ->enableSort()
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('item_type','items.type' )
                ->dataSource(ItemTypeEnum::getValueLabel())
                ->optionLabel('label')
                ->optionValue('value'),
            Filter::select('item_image','items.rarity' )
                ->dataSource(ItemRarityEnum::getValueLabel())
                ->optionLabel('label')
                ->optionValue('value'),
        ];
    }

    private function getAveragePriceInUSDT(MarketListing $listing): string
    {
        $pricesHtml = '<div class="flex flex-col">';
        $prices['ton'] = $listing->price_ton ? cache()->get('ton_usdt_price', 0.0) * $listing->price_ton : 0.0;
        $prices['qrk'] = $listing->price_qrk ? cache()->get('qrk_usdt_price', 0.0) * $listing->price_qrk : 0.0;
        $prices['not'] = $listing->price_not ? cache()->get('not_usdt_price', 0.0) * $listing->price_not : 0.0;
        $prices['udst'] = $listing->price_usd;
        //calculate average price in USD (sum all avaliable prices dived by nimber of them)
        $avgprice = 0.0;
        $count = 0;
        foreach ($prices as $price) {
            if ($price > 0) {
                $avgprice += $price;
                $count++;
            }
        }
        if ($count > 0) {
            $avgprice /= $count;
        }
        $pricesHtml .= "<span>".number_format($avgprice, 2)
            ."<span class='font-bold text-green-400'> USDT</span></span>";
        $pricesHtml .= '</div>';

        if (!str_contains($pricesHtml, '<span>')) {
            return '<span class="text-gray-400">'.__('resources.home.na').'</span>';
        }
        return $pricesHtml;
    }

    private function formatPrice(string $symbol, mixed $price): string
    {
        $label = match ($symbol) {
            'QRK' => "<span class='font-bold text-purple-400'>QRK: </span>",
            'NOT' => "<span class='font-bold text-green-400'>NOT: </span>",
            'TON' => "<span class='font-bold text-blue-400'>TON: </span>",
            default => "<span class='font-bold text-yellow-400'>USD</span>",
        };
        $lowerSymbol = strtolower($symbol);
        $toUsd = $symbol !== "USD" ?
            " <span class='text-xs text-gray-500'>"
            .number_format(cache()->get("{$lowerSymbol}_usdt_price", 0.0) * $price, 2)
            ." USDT</span>" : "";
        return '<div class="inline-block">'
            .$label
            .number_format($price, 2)
            .$toUsd
            ."</div>";

    }

}
