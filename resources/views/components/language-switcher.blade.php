@props(['isMobile' => false])

<div
    class="relative {{ $isMobile ? 'md:hidden' : 'hidden md:block' }}"
    @click.away="langOpen = false"
>
    <button
        @click="langOpen = !langOpen"
        class="flex items-center text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
    >
        <svg
            class="w-5 h-5 {{ $isMobile ? '' : 'mr-1' }}"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h5.25M5.25 6.75L9.75 3M18.75 6.75l-4.5-3.75"
            />
        </svg>
        @if (!$isMobile)
        <span
            class="hidden sm:inline"
            >{{ strtoupper(app()->getLocale()) }}</span
        >
        <svg
            class="w-4 h-4 ml-1 hidden sm:inline"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M19.5 8.25l-7.5 7.5-7.5-7.5"
            />
        </svg>
        @endif
    </button>
    <div
        x-show="langOpen"
        style="display: none"
        class="absolute right-0 mt-2 w-24 bg-gray-700 rounded-md shadow-lg py-1 z-50"
        x-transition
    >
        <a
            href="{{ route('lang.switch', 'en') }}"
            class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-600"
            >EN</a
        >
        <a
            href="{{ route('lang.switch', 'ru') }}"
            class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-600"
            >RU</a
        >
    </div>
</div>
