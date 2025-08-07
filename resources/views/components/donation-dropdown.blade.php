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
            viewBox="0 0 20 20"
            fill="currentColor"
        >
            <path
                fill-rule="evenodd"
                d="M10 3a1 1 0 011 1v1.065l1.357-.678a1 1 0 011.286 1.286L12.286 7.03a1 1 0 01-1.286-1.286L11 5.065V4a1 1 0 01-1-1zM5 8a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm2 3a1 1 0 00-1 1v1a1 1 0 102 0v-1a1 1 0 00-1-1zm8-1a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1z"
                clip-rule="evenodd"
            />
            <path
                d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H4zm12 14H4V4h12v12z"
            />
        </svg>
        {{ __("resources.home.buy_me_a_coffee") }}
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
        <div class="bg-gray-700 rounded-md shadow-lg ">
        <div class="px-4 py-3">
            <p class="text-sm text-gray-200 font-semibold">
                {{ __("resources.home.support_the_project") }}
            </p>
            <p class="text-xs text-gray-400 mt-1">
                {{
                    __(
                        "resources.home.donation"
                    )
                }}
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
