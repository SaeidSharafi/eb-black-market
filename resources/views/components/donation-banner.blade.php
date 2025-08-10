@props(['class' => ''])

<div
    x-data="{ donationBarOpen: true, donationDropdownOpen: false }"
    x-show="donationBarOpen"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-full"
    class="bg-gradient-to-r from-yellow-600 to-yellow-500 border-b border-yellow-400/30 {{
        $class
    }}"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-2">
            <div class="flex items-center flex-1">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-white mr-2 flex-shrink-0"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                        clip-rule="evenodd"
                    />
                </svg>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-medium">
                        <span class="hidden sm:inline">{{
                            __("resources.home.help_project_banner")
                        }}</span>
                        <span class="sm:hidden">{{
                            __("resources.home.help_project_banner_mobile")
                        }}</span>
                    </p>
                </div>
            </div>

            <div class="flex items-center space-x-2 ml-4">
                <div
                    class="relative"
                    @click.away="donationDropdownOpen = false"
                >
                    <button
                        @click="donationDropdownOpen = !donationDropdownOpen"
                        class="inline-flex items-center px-3 py-1 border border-white/30 text-sm font-medium rounded-md text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50 transition"
                    >
                        <span class="hidden sm:inline">{{
                            __("resources.home.donate_now")
                        }}</span>
                        <span class="sm:hidden">{{
                            __("resources.home.donate")
                        }}</span>
                        <svg
                            class="w-4 h-4 ml-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            ></path>
                        </svg>
                    </button>

                    <div
                        x-show="donationDropdownOpen"
                        style="display: none"
                        class="absolute right-0 mt-2 w-72 py-1 z-50"
                        x-transition
                    >
                        <div
                            class="bg-gray-800 rounded-md shadow-lg border border-gray-600"
                        >
                            <div class="px-4 py-3">
                                <p
                                    class="text-sm text-yellow-400 font-semibold"
                                >
                                    {{
                                        __("resources.home.help_project_title")
                                    }}
                                </p>
                                <p class="text-xs text-gray-300 mt-1">
                                    {{
                                        __(
                                            "resources.home.help_project_description"
                                        )
                                    }}
                                </p>
                            </div>
                            <div class="border-t border-gray-600"></div>
                            <x-crypto-address
                                label="TON"
                                address="UQDNirn4dqMkeSzwU_tSi3vmUgPlX-9RtkDEou9mG9RL3oVw"
                                :is-mobile="false"
                            />
                            <x-crypto-address
                                label="EVM"
                                address="0xfb0093224143574f98edb7bd6fc86726a18918d9"
                                :is-mobile="false"
                            />
                        </div>
                    </div>
                </div>

                <button
                    @click="donationBarOpen = false"
                    class="flex-shrink-0 p-1 text-white/70 hover:text-white transition"
                    aria-label="{{ __('resources.home.dismiss') }}"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        ></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
