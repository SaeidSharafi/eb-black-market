<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700">
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
                </div>
                <div class="flex items-center">
                    <div class="hidden md:flex items-center space-x-4">
                        <a
                            href="{{ route('market-listings.index') }}"
                            class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                            >{{ __("resources.home.view_all_listings") }}</a
                        >
                        <!-- Language Switcher -->
                        <div class="relative">
                            <button
                                id="lang-switcher-button"
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
                                {{ strtoupper(app()->getLocale()) }}
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
                                id="lang-switcher-dropdown"
                                class="hidden absolute right-0 mt-2 w-24 bg-gray-700 rounded-md shadow-lg py-1"
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
                        <!-- Buy me a coffee -->
                        <div class="relative">
                            <button
                                id="coffee-button"
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
                                id="coffee-dropdown"
                                class="hidden absolute right-0 mt-2 w-64 bg-gray-700 rounded-md shadow-lg py-1 z-50"
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
                                <div class="px-4 py-3">
                                    <p
                                        class="text-xs font-semibold text-gray-300"
                                    >
                                        TON:
                                    </p>
                                    <div class="relative mt-1">
                                        <input
                                            type="text"
                                            readonly
                                            id="ton-address-nav"
                                            value="UQDNirn4dqMkeSzwU_tSi3vmUgPlX-9RtkDEou9mG9RL3oVw"
                                            class="w-full bg-gray-800 border-gray-600 text-gray-200 text-xs rounded-md shadow-sm pr-8"
                                        />
                                        <button
                                            onclick="copyToClipboard('ton-address-nav', 'ton-copy-icon-nav')"
                                            class="absolute inset-y-0 right-0 flex items-center pr-2"
                                        >
                                            <svg
                                                id="ton-copy-icon-nav"
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
                                <div class="px-4 py-3">
                                    <p
                                        class="text-xs font-semibold text-gray-300"
                                    >
                                        EVM:
                                    </p>
                                    <div class="relative mt-1">
                                        <input
                                            type="text"
                                            readonly
                                            id="evm-address-nav"
                                            value="0xfb0093224143574f98edb7bd6fc86726a18918d9"
                                            class="w-full bg-gray-800 border-gray-600 text-gray-200 text-xs rounded-md shadow-sm pr-8"
                                        />
                                        <button
                                            onclick="copyToClipboard('evm-address-nav', 'evm-copy-icon-nav')"
                                            class="absolute inset-y-0 right-0 flex items-center pr-2"
                                        >
                                            <svg
                                                id="evm-copy-icon-nav"
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
                    <a
                        href="/dashboard"
                        class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                    >
                        {{ __("resources.home.go_to_dashboard") }}
                    </a>
                    @else
                    <a
                        href="/dashboard/login"
                        class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        {{ __("resources.home.login") }}
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a
                class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-gray-700 focus:border-gray-300 transition"
                href="{{ route('market-listings.index') }}"
            >
                {{ __("All Listings") }}
            </a>
        </div>
    </div>
</nav>
