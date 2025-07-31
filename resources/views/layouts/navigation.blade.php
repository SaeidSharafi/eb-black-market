<nav
    x-data="{ open: false, langOpen: false, coffeeOpen: false, coffeeOpenMobile: false }"
    class="bg-gray-800 border-b border-gray-700"
>
    <!-- Primary Navigation Menu -->
    <nav
        class="bg-gray-800/60 backdrop-blur-lg sticky top-0 z-50 border-b border-gray-700/50"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a
                        href="{{ route('home') }}"
                        class="text-2xl font-bold text-yellow-400"
                    >
                        Empires Market
                    </a>
                    <div class="relative" @click.away="langOpen = false">
                        <button
                                @click="langOpen = !langOpen"
                                class="flex items-center text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                        >
                            <svg
                                    class="w-5 h-5 mr-1"
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
                </div>
                <div class="flex items-center">
                    <div class="hidden md:flex items-center space-x-4">
                        <!-- Language Switcher -->
                        <a
                            href="{{ route('market-listings.index') }}"
                            class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                            >{{ __("resources.home.view_all_listings") }}</a
                        >
                        <!-- Buy me a coffee -->
                        <div class="relative" @click.away="coffeeOpen = false">
                            <button
                                @click="coffeeOpen = !coffeeOpen"
                                class="flex items-center text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
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
                                {{ __("Buy me a coffee") }}
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
                            </button>
                            <div
                                x-show="coffeeOpen"
                                style="display: none"
                                class="absolute right-0 mt-2 w-64 bg-gray-700 rounded-md shadow-lg py-1 z-50"
                                x-transition
                            >
                                <div class="px-4 py-3">
                                    <p
                                        class="text-sm text-gray-200 font-semibold"
                                    >
                                        {{ __("Support the project") }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{
                                            __(
                                                "If you find this project helpful, consider a small donation."
                                            )
                                        }}
                                    </p>
                                </div>
                                <div class="border-t border-gray-600"></div>
                                <div
                                    x-data="copyToClipboard()"
                                    class="px-4 py-3"
                                >
                                    <p
                                        class="text-xs font-semibold text-gray-300"
                                    >
                                        TON:
                                    </p>
                                    <div class="relative mt-1">
                                        <input
                                            type="text"
                                            readonly
                                            x-ref="ton_address"
                                            value="UQDNirn4dqMkeSzwU_tSi3vmUgPlX-9RtkDEou9mG9RL3oVw"
                                            class="w-full bg-gray-800 border-gray-600 text-gray-200 text-xs rounded-md shadow-sm pr-8"
                                        />
                                        <button
                                            @click="copy('ton_address', 'ton_icon')"
                                            class="absolute inset-y-0 right-0 flex items-center pr-2"
                                        >
                                            <svg
                                                x-ref="ton_icon"
                                                class="h-4 w-4 text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                                                ></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div
                                    x-data="copyToClipboard()"
                                    class="px-4 py-3"
                                >
                                    <p
                                        class="text-xs font-semibold text-gray-300"
                                    >
                                        EVM:
                                    </p>
                                    <div class="relative mt-1">
                                        <input
                                            type="text"
                                            readonly
                                            x-ref="evm_address"
                                            value="0xfb0093224143574f98edb7bd6fc86726a18918d9"
                                            class="w-full bg-gray-800 border-gray-600 text-gray-200 text-xs rounded-md shadow-sm pr-8"
                                        />
                                        <button
                                            @click="copy('evm_address', 'evm_icon')"
                                            class="absolute inset-y-0 right-0 flex items-center pr-2"
                                        >
                                            <svg
                                                x-ref="evm_icon"
                                                class="h-4 w-4 text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                                                ></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @auth
                    <div class="hidden md:block">
                        <a
                            href="/dashboard"
                            class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                        >
                            {{ __("resources.home.go_to_dashboard") }}
                        </a>
                    </div>
                    @else
                    <div class="hidden md:block">
                        <a
                            href="/dashboard/login"
                            class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            {{ __("resources.home.login") }}
                        </a>
                    </div>
                    @endauth
                </div>
                <div class="-mr-2 flex items-center md:hidden">
                    <div
                        class="relative md:hidden"
                        @click.away="langOpen = false"
                    >
                        <button
                            @click="langOpen = !langOpen"
                            class="flex items-center text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                        >
                            <svg
                                class="w-5 h-5"
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
                    <div class="md:hidden">
                        <button
                            @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition"
                        >
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{'hidden': open, 'inline-flex': ! open }"
                                    class="inline-flex"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{'hidden': ! open, 'inline-flex': open }"
                                    class="hidden"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a
                class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-gray-700 focus:border-gray-300 transition"
                href="{{ route('market-listings.index') }}"
            >
                {{ __("All Listings") }}
            </a>
            @auth
            <a
                href="/dashboard"
                class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-gray-700 focus:border-gray-300 transition"
            >
                {{ __("resources.home.go_to_dashboard") }}
            </a>
            @else
            <a
                href="/dashboard/login"
                class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-gray-700 focus:border-gray-300 transition"
            >
                {{ __("resources.home.login") }}
            </a>
            @endauth
            <!-- Buy me a coffee -->
            <div class="relative px-4 pt-2">
                <button
                    @click="coffeeOpenMobile = !coffeeOpenMobile"
                    class="w-full flex items-center text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
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
                    {{ __("Buy me a coffee") }}
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
                </button>
                <div
                    x-show="coffeeOpenMobile"
                    style="display: none"
                    class="mt-2 w-full bg-gray-700 rounded-md shadow-lg py-1 z-50"
                    x-transition
                >
                    <div class="px-4 py-3">
                        <p class="text-sm text-gray-200 font-semibold">
                            {{ __("Support the project") }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{
                                __(
                                    "If you find this project helpful, consider a small donation."
                                )
                            }}
                        </p>
                    </div>
                    <div class="border-t border-gray-600"></div>
                    <div x-data="copyToClipboard()" class="px-4 py-3">
                        <p class="text-xs font-semibold text-gray-300">TON:</p>
                        <div class="relative mt-1">
                            <input
                                type="text"
                                readonly
                                x-ref="ton_address_mobile"
                                value="UQDNirn4dqMkeSzwU_tSi3vmUgPlX-9RtkDEou9mG9RL3oVw"
                                class="w-full bg-gray-800 border-gray-600 text-gray-200 text-xs rounded-md shadow-sm pr-8"
                            />
                            <button
                                @click="copy('ton_address_mobile', 'ton_icon_mobile')"
                                class="absolute inset-y-0 right-0 flex items-center pr-2"
                            >
                                <svg
                                    x-ref="ton_icon_mobile"
                                    class="h-4 w-4 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div x-data="copyToClipboard()" class="px-4 py-3">
                        <p class="text-xs font-semibold text-gray-300">EVM:</p>
                        <div class="relative mt-1">
                            <input
                                type="text"
                                readonly
                                x-ref="evm_address_mobile"
                                value="0xfb0093224143574f98edb7bd6fc86726a18918d9"
                                class="w-full bg-gray-800 border-gray-600 text-gray-200 text-xs rounded-md shadow-sm pr-8"
                            />
                            <button
                                @click="copy('evm_address_mobile', 'evm_icon_mobile')"
                                class="absolute inset-y-0 right-0 flex items-center pr-2"
                            >
                                <svg
                                    x-ref="evm_icon_mobile"
                                    class="h-4 w-4 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    function copyToClipboard() {
        return {
            copy(inputRef, iconRef) {
                const input = this.$refs[inputRef];
                input.select();
                input.setSelectionRange(0, 99999); // For mobile

                try {
                    document.execCommand("copy");
                } catch (err) {
                    navigator.clipboard.writeText(input.value);
                }

                const icon = this.$refs[iconRef];
                if (icon) {
                    const originalColor = icon.style.color;
                    icon.style.color = "#facc15"; // yellow-400
                    setTimeout(() => {
                        icon.style.color = originalColor;
                    }, 700);
                }
            },
        };
    }
</script>
@endpush
