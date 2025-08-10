@props(['isMobile' => false])

<div
    class="relative {{ $isMobile ? 'pt-2' : '' }}"
    @click.away="{{ $isMobile ? 'coffeeOpenMobile' : 'coffeeOpen' }} = false"
>
    <button
        @click="{{ $isMobile ? 'coffeeOpenMobile' : 'coffeeOpen' }} = !{{
            $isMobile ? 'coffeeOpenMobile' : 'coffeeOpen'
        }}"
        class="{{
            $isMobile ? 'w-full ' : ''
        }}flex items-center text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 mr-1"
            fill="currentColor"
            viewBox="0 0 20 20"
        >
            <path
                fill-rule="evenodd"
                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                clip-rule="evenodd"
            />
        </svg>
        {{ __("resources.home.help_project") }}
        @if (!$isMobile)
        <svg
            class="w-4 h-4 ml-1"
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
        @else
        <svg
            class="w-4 h-4 ml-auto"
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
        x-show="{{ $isMobile ? 'coffeeOpenMobile' : 'coffeeOpen' }}"
        style="display: none"
        class="{{
            $isMobile ? 'mt-2 w-full px-2' : 'absolute right-0 mt-2 w-64'
        }} py-1 z-50"
        x-transition
    >
        <div class="bg-gray-700 rounded-md shadow-lg">
            <div class="px-4 py-3">
                <p class="text-sm text-gray-200 font-semibold">
                    {{ __("resources.home.help_project_title") }}
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    {{ __("resources.home.help_project_description") }}
                </p>
            </div>
            <div class="border-t border-gray-600"></div>
            <x-crypto-address
                label="TON"
                address="UQDNirn4dqMkeSzwU_tSi3vmUgPlX-9RtkDEou9mG9RL3oVw"
                :is-mobile="$isMobile"
            />
            <x-crypto-address
                label="EVM"
                address="0xfb0093224143574f98edb7bd6fc86726a18918d9"
                :is-mobile="$isMobile"
            />
        </div>
    </div>
</div>
