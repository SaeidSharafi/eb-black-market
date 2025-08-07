@php
    use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative text-white text-center py-24 md:py-32 bg-gray-800" role="banner">
        <div class="absolute top-0 left-0 w-full h-full bg-cover bg-center opacity-20"
            style="background-image: url('{{ asset('/images/hero-bg.webp') }}');" aria-hidden="true"></div>
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-gray-900/75 to-transparent" aria-hidden="true">
        </div>
        <div class="relative z-10 max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 text-shadow-lg">
                {{ __('resources.home.title') }}
            </h1>
            <p class="text-lg md:text-xl mb-8 text-gray-300">
                {{ __('resources.home.subtitle') }}
            </p>
            <nav class="flex justify-center items-center space-x-4" aria-label="Primary actions">
                <a href="#latest-listings"
                    class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-3 px-8 rounded-full transition text-sm md:text-lg transform hover:scale-105"
                    aria-describedby="explore-description">
                    {{ __('resources.home.explore_listings') }}
                </a>
                <span id="explore-description" class="sr-only">Browse the latest gaming items available for trade</span>
                @auth
                    <a href="/dashboard"
                        class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-full transition text-sm md:text-lg transform hover:scale-105">
                        {{ __('resources.home.go_to_dashboard') }}
                    </a>
                @endauth
                @guest
                    <a href="/dashboard/login"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition text-lg transform hover:scale-105">
                        {{ __('resources.home.login') }}
                    </a>
                @endguest
            </nav>
        </div>
    </section>

    <!-- Disclaimer -->
    <section class="bg-gray-800 py-3 border-t border-b border-gray-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-yellow-300/80">
            <p>{{ __('resources.home.disclaimer') }}</p>
        </div>
    </section>

    <!-- Latest Listings Section -->
    <section id="latest-listings" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <header class="text-center mb-10">
            <h2 class="text-3xl font-bold">
                {{ __('resources.home.latest_listings') }}
            </h2>
            <p class="text-gray-400 mt-2">
                Discover the newest items available in our marketplace
            </p>
        </header>

        @if ($listings->isEmpty())
            <div class="text-center text-gray-400" role="status" aria-live="polite">
                <p>{{ __('resources.home.no_listings') }}</p>
                <p class="text-sm mt-2">
                    Check back later for new items or
                    <a href="/dashboard/login" class="text-yellow-400 hover:text-yellow-300 underline">
                        login to add your own listings
                    </a>
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6" role="region"
                aria-label="Latest marketplace listings">
                @foreach ($listings as $listing)
                    <article
                        class="bg-gray-800 rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 ease-in-out"
                        itemscope itemtype="https://schema.org/Product">
                        <div class="relative">
                            <img src="{{ $listing->item->image ? asset('storage/' . $listing->item->image) : asset('images/placeholder.png') }}"
                                alt="{{ $listing->item->getTranslation('name', app()->getLocale()) ?? __('resources.home.unknown') }} - {{ __('resources.home.item_image_alt') }}"
                                class="h-40 w-full object-cover" itemprop="image" loading="lazy" />
                            @if ($listing->item->type)
                                <span
                                    class="absolute top-2 left-2 bg-yellow-400 text-gray-900 text-xs font-semibold px-2 py-1 rounded">
                                    {{ $listing->item->type }}
                                </span>
                            @endif
                        </div>
                        <div class="p-4 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold mb-2 truncate" itemprop="name">
                                    {{ $listing->item->getTranslation('name', app()->getLocale()) ?? __('resources.home.unknown') }}
                                </h3>
                                <div class="space-y-1 text-xs text-gray-300 mb-3" itemprop="offers" itemscope
                                    itemtype="https://schema.org/AggregateOffer">
                                    @if ($listing->price_qrk)
                                        <p>
                                            <span class="font-semibold text-yellow-400">QRK:</span>
                                            <span itemprop="lowPrice">{{ number_format($listing->price_qrk, 2) }}</span>
                                        </p>
                                    @endif
                                    @if ($listing->price_not)
                                        <p>
                                            <span class="font-semibold text-yellow-400">NOT:</span>
                                            <span>{{ number_format($listing->price_not, 2) }}</span>
                                        </p>
                                    @endif
                                    @if ($listing->price_ton)
                                        <p>
                                            <span class="font-semibold text-yellow-400">TON:</span>
                                            <span itemprop="highPrice">{{ number_format($listing->price_ton, 2) }}</span>
                                        </p>
                                    @endif
                                    <meta itemprop="priceCurrency" content="TON" />
                                </div>
                                <time class="text-xs text-gray-500 mb-3 block"
                                    datetime="{{ $listing->created_at->format('Y-m-d') }}" itemprop="datePublished">
                                    {{ __('resources.home.listed') }}:
                                    {{ $listing->created_at->diffForHumans() }}
                                </time>
                            </div>
                            @if ($listing->user && $listing->user->telegram_username)
                                <a href="https://t.me/{{ $listing->user->telegram_username }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-full text-center block bg-yellow-600 hover:bg-yellow-700 text-black font-bold py-2 px-3 rounded-lg transition text-sm"
                                    aria-label="Contact {{ $listing->user->name ?? 'seller' }} on Telegram">
                                    {{ __('resources.home.contact_seller') }}
                                </a>
                            @else
                                <span
                                    class="w-full text-center block bg-gray-700 text-gray-400 font-bold py-2 px-3 rounded-lg text-sm"
                                    aria-label="Contact information not available">
                                    {{ __('resources.home.na') }}
                                </span>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        <footer class="text-center mt-12">
            <a href="{{ route('market-listings.index') }}"
                class="text-yellow-400 hover:text-yellow-300 font-semibold transition inline-flex items-center"
                aria-label="View all available listings in the marketplace">
                {{ __('resources.home.view_all_listings') }}
                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </footer>
    </section>

    <!-- FAQ Section for SEO -->
    <section class="bg-gray-800/50 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <header class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">
                    {{ __('resources.home.faq.title') }}
                </h2>
                <p class="text-gray-400">
                    {{ __('resources.home.faq.subtitle') }}
                </p>
            </header>

            <div class="space-y-6" itemscope itemtype="https://schema.org/FAQPage">
                @foreach (__('resources.home.faq.questions') as $faq)
                    <div class="bg-gray-800 rounded-lg p-6" itemscope itemprop="mainEntity"
                        itemtype="https://schema.org/Question">
                        <h3 class="text-lg font-semibold text-white mb-3" itemprop="name">
                            {{ $faq['question'] }}
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <p class="text-gray-300 leading-relaxed" itemprop="text">
                                {{ $faq['answer'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
