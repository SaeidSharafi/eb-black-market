@props(['listing', 'stringsData'])

<article
    class="bg-gray-800 rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 ease-in-out"
    itemscope
    itemtype="https://schema.org/Product"
>
    <div class="relative">
        <img
            src="{{ $listing->item->image ? asset('storage/' . $listing->item->image) : asset('images/placeholder.png') }}"
            alt="{{ $listing->item->getTranslation('name', app()->getLocale()) ?? $stringsData['unknown'] }} - {{
                __('resources.home.item_image_alt')
            }}"
            class="h-40 w-full object-cover"
            itemprop="image"
            loading="lazy"
        />
        @if ($listing->item->type)
        <span
            class="absolute top-2 left-2 bg-yellow-400 text-gray-900 text-xs font-semibold px-2 py-1 rounded"
        >
            {{ $listing->item->type }}
        </span>
        @endif
    </div>
    <div class="p-4 flex flex-col justify-between">
        <div>
            <h3 class="text-lg font-bold mb-2 truncate" itemprop="name">
                {{ $listing->item->getTranslation('name', app()->getLocale()) ?? $stringsData['unknown'] }}
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
                <meta itemprop="priceCurrency" content="TON" />
            </div>
            <time
                class="text-xs text-gray-500 mb-3 block"
                datetime="{{ $listing->created_at->format('Y-m-d') }}"
                itemprop="datePublished"
            >
                {{ $stringsData["listed"] }}:
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
            {{ $stringsData["contact_seller"] }}
        </a>
        @else
        <span
            class="w-full text-center block bg-gray-700 text-gray-400 font-bold py-2 px-3 rounded-lg text-sm"
            aria-label="Contact information not available"
        >
            {{ $stringsData["na"] }}
        </span>
        @endif
    </div>
</article>
