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
                    </div>
                    @auth
                        <a
                                href="/dashboard-url"
                                class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                        >
                            {{ __("resources.home.go_to_dashboard") }}
                        </a>
                    @else
                        <a
                                href="/login-url"
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

