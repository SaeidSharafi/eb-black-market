@props(['listing'])
@php
    $typeEnum = $listing->item->type;
    $lsitingTypeEnum = \App\Enum\ListingTypeEnum::tryFrom($listing->listing_type);
    $typeClass = $lsitingTypeEnum === \App\Enum\ListingTypeEnum::SELL ? 'bg-green-500' : 'bg-red-500';
@endphp
<article
        class="bg-gray-800 rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 ease-in-out"
        itemscope
        itemtype="https://schema.org/Product"
>
    <div class="{{$listing->item->rarity->getRarityColor()}} relative overflow-hidden flex items-center justify-center">
        <span class="absolute top-2 left-2 {{$typeClass}} text-black text-xs font-semibold px-2 py-1 rounded"
        >
            {{$lsitingTypeEnum->translate()}}
        </span>
        <img
                src="{{ $listing->item->image ? asset('storage/' . $listing->item->image) : asset('images/placeholder.png') }}"
                alt="{{ $listing->item->getTranslation('name', app()->getLocale()) ?? __("resources.home.unknown") }} - {{
                __('resources.home.item_image_alt')
            }}"
                class="h-40 object-fill max-w-36"
                itemprop="image"
                loading="lazy"
        />
    </div>
    <div class="p-4 flex flex-col justify-between">
        <div class="flex gap-2">
                <span
                        class="bg-yellow-400 text-gray-900 text-xs font-semibold px-2 py-1 rounded"
                >
            {{ $typeEnum->translate() }}
        </span>
            @if ($typeEnum->isEquipment())
                <span class=" text-gray-900 text-xs font-semibold px-2 py-1 rounded {{$listing->item->rarity->getRarityColor()}} px-1">{{$listing->item->rarity->translate()}}</span>
            @endif
        </div>
        <div>
            <h3 class="text-lg font-bold mb-2 truncate" itemprop="name">
                {{ $listing->item->getTranslation('name', app()->getLocale()) ?? 'unknown' }}
            </h3>
            <div
                    class="space-y-1 text-xs text-gray-300 mb-3"
                    itemprop="offers"
                    itemscope
                    itemtype="https://schema.org/AggregateOffer"
            >
                @if ($listing->price_qrk)
                    <p>
                        <span class="font-semibold text-yellow-400">QRK:</span>
                        <span
                                itemprop="lowPrice"
                        >{{ number_format($listing->price_qrk, 2) }}</span
                        >
                    </p>
                @endif @if ($listing->price_not)
                    <p>
                        <span class="font-semibold text-yellow-400">NOT:</span>
                        <span>{{ number_format($listing->price_not, 2) }}</span>
                    </p>
                @endif @if ($listing->price_ton)
                    <p>
                        <span class="font-semibold text-yellow-400">TON:</span>
                        <span
                                itemprop="highPrice"
                        >{{ number_format($listing->price_ton, 2) }}</span
                        >
                    </p>
                @endif
                <meta itemprop="priceCurrency" content="TON"/>
            </div>
            <time
                    class="text-xs text-gray-500 mb-3 block"
                    datetime="{{ $listing->created_at->format('Y-m-d') }}"
                    itemprop="datePublished"
            >
                {{ __('resources.home.listed') }}:
                {{ $listing->created_at->diffForHumans() }}
            </time>
        </div>
        @if ($listing->user && $listing->user->telegram_username)
            <a
                    href="https://t.me/{{ $listing->user->telegram_username }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-full text-center block bg-yellow-600 hover:bg-yellow-700 text-black font-bold py-2 px-3 rounded-lg transition text-sm"
                    aria-label="Contact {{ $listing->user->name ?? 'seller' }} on Telegram"
            >
                {{ __('resources.home.contact_seller') }}
            </a>
        @else
            <span
                    class="w-full text-center block bg-gray-700 text-gray-400 font-bold py-2 px-3 rounded-lg text-sm"
                    aria-label="Contact information not available"
            >
            {{ __('resources.home.na') }}
        </span>
        @endif
    </div>
</article>
