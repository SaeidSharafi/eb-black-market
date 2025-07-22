@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.app')
@section('content')
        <!-- Hero Section -->
        <header
            class="relative text-white text-center py-24 md:py-32 bg-gray-800"
        >
            <div
                class="absolute top-0 left-0 w-full h-full bg-cover bg-center opacity-20"
                style="background-image: url('{{ asset('images/hero-bg.webp') }}');"
            ></div>
            <div
                class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-gray-900/75 to-transparent"
            ></div>
            <div class="relative z-10 max-w-4xl mx-auto px-4">
                <h1
                    class="text-4xl md:text-6xl font-extrabold mb-4 text-shadow-lg"
                >
                    {{ __("resources.home.title") }}
                </h1>
                <p class="text-lg md:text-xl mb-8 text-gray-300">
                    {{ __("resources.home.subtitle") }}
                </p>
                <a
                    href="#latest-listings"
                    class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-3 px-8 rounded-full transition text-lg transform hover:scale-105"
                >
                    {{ __("resources.home.explore_listings") }}
                </a>
            </div>
        </header>

        <!-- Disclaimer -->
        <section class="bg-gray-800 py-3 border-t border-b border-gray-700/50">
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-yellow-300/80"
            >
                <p>{{ __("resources.home.disclaimer") }}</p>
            </div>
        </section>

        <!-- Latest Listings Section -->
        <main
            id="latest-listings"
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
        >
            <h2 class="text-3xl font-bold text-center mb-10">
                {{ __("resources.home.latest_listings") }}
            </h2>

            @if($listings->isEmpty())
            <p class="text-center text-gray-400">
                {{ __("resources.home.no_listings") }}
            </p>
            @else
            <div
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6"
            >
                @foreach($listings as $listing)
                <div
                    class="bg-gray-800 rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 ease-in-out"
                >
                    <img
                        src="{{ asset('storage/'.$listing->item->image) ?? '/images/placeholder.png' }}"
                        alt="{{ __('resources.home.item_image_alt') }}"
                        class="h-40 object-fit mx-auto"
                    />
                    <div class="p-4 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold mb-2 truncate">
                                {{ $listing->item->getTranslation('name', app()->getLocale()) ?? __('resources.home.unknown') }}
                            </h3>
                            <div class="space-y-1 text-xs text-gray-300 mb-3">
                                @if($listing->price_qrk)
                                <p>
                                    <span class="font-semibold text-yellow-400"
                                        >QRK:</span
                                    >
                                    {{ number_format($listing->price_qrk, 2) }}
                                </p>
                                @endif @if($listing->price_not)
                                <p>
                                    <span class="font-semibold text-yellow-400"
                                        >NOT:</span
                                    >
                                    {{ number_format($listing->price_not, 2) }}
                                </p>
                                @endif @if($listing->price_ton)
                                <p>
                                    <span class="font-semibold text-yellow-400"
                                        >TON:</span
                                    >
                                    {{ number_format($listing->price_ton, 2) }}
                                </p>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 mb-3">
                                {{ __("resources.home.listed") }}:
                                {{ $listing->created_at->diffForHumans() }}
                            </div>
                        </div>
                        @if($listing->user && $listing->user->telegram_username)
                        <a
                            href="https://t.me/{{ $listing->user->telegram_username }}"
                            target="_blank"
                            class="w-full text-center block bg-yellow-600 hover:bg-yellow-700 text-black font-bold py-2 px-3 rounded-lg transition text-sm"
                        >
                            {{ __("resources.home.contact_seller") }}
                        </a>
                        @else
                        <span
                            class="w-full text-center block bg-gray-700 text-gray-400 font-bold py-2 px-3 rounded-lg text-sm"
                        >
                            {{ __("resources.home.na") }}
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="text-center mt-12">
                <a
                    href="/listing-page-url"
                    class="text-yellow-400 hover:text-yellow-300 font-semibold transition"
                >
                    {{ __("resources.home.view_all_listings") }} &rarr;
                </a>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 border-t border-gray-700/50 mt-12">
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-gray-500 text-sm"
            >
                <p>
                    &copy; {{ date("Y") }} Empires Market.
                    {{ __("resources.home.footer_disclaimer") }}
                </p>
            </div>
        </footer>
@endsection
