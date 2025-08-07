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
                    <x-language-switcher />
                </div>
                <div class="flex items-center">
                    <div class="hidden md:flex items-center space-x-4">
                        <!-- All Listings Link -->
                        <a
                            href="{{ route('market-listings.index') }}"
                            class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                            >{{ __("resources.home.view_all_listings") }}</a
                        >

                        <!-- Buy me a coffee -->
                        <x-donation-dropdown />
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
                    <x-language-switcher :is-mobile="true" />
                    <x-mobile-menu-toggle />
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
                {{ __("resources.home.all_listings") }}
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

            <!-- Buy me a coffee mobile -->
            <x-donation-dropdown :is-mobile="true" />
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
