<footer
    class="bg-gray-800 border-t border-gray-700/50 mt-12"
    role="contentinfo"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- About Section -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">
                    {{ config("app.name", "Empires Market") }}
                </h3>
                <p class="text-gray-400 text-sm mb-4">
                    {{ __("resources.home.subtitle") }}
                </p>
                <p class="text-xs text-yellow-300/80">
                    {{ __("resources.home.disclaimer") }}
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">
                    Quick Links
                </h3>
                <nav aria-label="Footer navigation">
                    <ul class="space-y-2">
                        <li>
                            <a
                                href="{{ route('home') }}"
                                class="text-gray-400 hover:text-white text-sm transition"
                            >
                                {{ __('resources.home.home') }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route('market-listings.index') }}"
                                class="text-gray-400 hover:text-white text-sm transition"
                            >
                                {{ __("resources.home.view_all_listings") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="/dashboard"
                                class="text-gray-400 hover:text-white text-sm transition"
                            >
                                {{ __('resources.home.dashboard') }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="/sitemap.xml"
                                class="text-gray-400 hover:text-white text-sm transition"
                            >
                            {{ __('resources.home.sitemap') }}
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Support Section -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">
                    {{ __("Support the project") }}
                </h3>
                <p class="text-gray-400 text-sm mb-4">
                    {{
                        __(
                            "If you find this project helpful, consider a small donation."
                        )
                    }}
                </p>
                <div class="space-y-3">
                    <!-- TON Address -->
                    <div x-data="copyToClipboard()" class="w-full">
                        <p class="text-xs font-semibold text-gray-300 mb-1">
                            TON:
                        </p>
                        <div class="relative">
                            <input
                                type="text"
                                readonly
                                x-ref="ton_address"
                                value="UQDNirn4dqMkeSzwU_tSi3vmUgPlX-9RtkDEou9mG9RL3oVw"
                                class="w-full bg-gray-700 border-gray-600 text-gray-200 text-xs rounded-md shadow-sm pr-8 py-2 px-3"
                            />
                            <button
                                @click="copy('ton_address', 'ton_icon')"
                                class="absolute inset-y-0 right-0 flex items-center pr-2"
                                aria-label="Copy TON address"
                            >
                                <svg
                                    x-ref="ton_icon"
                                    class="h-4 w-4 text-gray-400 hover:text-white transition"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- EVM Address -->
                    <div x-data="copyToClipboard()" class="w-full">
                        <p class="text-xs font-semibold text-gray-300 mb-1">
                            EVM:
                        </p>
                        <div class="relative">
                            <input
                                type="text"
                                readonly
                                x-ref="evm_address"
                                value="0xfb0093224143574f98edb7bd6fc86726a18918d9"
                                class="w-full bg-gray-700 border-gray-600 text-gray-200 text-xs rounded-md shadow-sm pr-8 py-2 px-3"
                            />
                            <button
                                @click="copy('evm_address', 'evm_icon')"
                                class="absolute inset-y-0 right-0 flex items-center pr-2"
                                aria-label="Copy EVM address"
                            >
                                <svg
                                    x-ref="evm_icon"
                                    class="h-4 w-4 text-gray-400 hover:text-white transition"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-700 pt-6">
            <div
                class="flex flex-col sm:flex-row justify-between items-center text-sm text-gray-400"
            >
                <p>
                    &copy; {{ date("Y") }}
                    {{ config("app.name", "Empires Market") }}.
                    {{ __("resources.home.footer_disclaimer") }}
                </p>
                <div class="flex space-x-4 mt-4 sm:mt-0">
                    <span>{{ __('resources.home.footer_made_with') }}</span>
                </div>
            </div>
        </div>
    </div>
</footer>
