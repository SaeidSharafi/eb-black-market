@props(['heroData'])

<section
    class="relative text-white text-center py-24 md:py-32 bg-gray-800"
    role="banner"
>
    <div
        class="absolute top-0 left-0 w-full h-full bg-cover bg-center opacity-20"
        style="background-image: url('{{ asset('/images/hero-bg.webp') }}');"
        aria-hidden="true"
    ></div>
    <div
        class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-gray-900/75 to-transparent"
        aria-hidden="true"
    ></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-4 text-shadow-lg">
            {{ $heroData["title"] }}
        </h1>
        <p class="text-lg md:text-xl mb-8 text-gray-300">
            {{ $heroData["subtitle"] }}
        </p>
        <nav
            class="flex justify-center items-center space-x-4"
            aria-label="Primary actions"
        >
            <a
                href="#latest-listings"
                class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-3 px-8 rounded-full transition text-sm md:text-lg transform hover:scale-105"
                aria-describedby="explore-description"
            >
                {{ $heroData["explore_listings"] }}
            </a>
            <span id="explore-description" class="sr-only"
                >Browse the latest gaming items available for trade</span
            >
            @auth
            <a
                href="/dashboard"
                class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-full transition text-sm md:text-lg transform hover:scale-105"
            >
                {{ $heroData["go_to_dashboard"] }}
            </a>
            @endauth @guest
            <a
                href="/dashboard/login"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition text-lg transform hover:scale-105"
            >
                {{ $heroData["login"] }}
            </a>
            @endguest
        </nav>
    </div>
</section>
