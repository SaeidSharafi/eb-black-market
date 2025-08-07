@props(['listings', 'stringsData'])

<section
    id="latest-listings"
    class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
>
    <header class="text-center mb-10">
        <h2 class="text-3xl font-bold">
            {{ $stringsData["latest_listings"] }}
        </h2>
        <p class="text-gray-400 mt-2">
            Discover the newest items available in our marketplace
        </p>
    </header>

    @if ($listings->isEmpty())
    <div class="text-center text-gray-400" role="status" aria-live="polite">
        <p>{{ $stringsData["no_listings"] }}</p>
        <p class="text-sm mt-2">
            Check back later for new items or
            <a
                href="/dashboard/login"
                class="text-yellow-400 hover:text-yellow-300 underline"
            >
                login to add your own listings
            </a>
        </p>
    </div>
    @else
    <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6"
        role="region"
        aria-label="Latest marketplace listings"
    >
        @foreach ($listings as $listing)
        <x-listing-card :listing="$listing" :strings-data="$stringsData" />
        @endforeach
    </div>
    @endif

    <footer class="text-center mt-12">
        <a
            href="{{ route('market-listings.index') }}"
            class="text-yellow-400 hover:text-yellow-300 font-semibold transition inline-flex items-center"
            aria-label="View all available listings in the marketplace"
        >
            {{ $stringsData["view_all_listings"] }}
            <svg
                class="w-4 h-4 ml-1"
                fill="currentColor"
                viewBox="0 0 20 20"
                aria-hidden="true"
            >
                <path
                    fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd"
                />
            </svg>
        </a>
    </footer>
</section>
