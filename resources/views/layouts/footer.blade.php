<footer class="bg-gray-800 border-t border-gray-700/50 mt-12">
    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-gray-500 text-sm"
    >
        <p>
            &copy; {{ date("Y") }} Empires Black Market.
            {{ __("resources.home.footer_disclaimer") }}
        </p>
        <div class="mt-4">
            <p class="text-gray-400">
                {{ __("Support the project with a small donation") }}:
            </p>
            <div class="flex flex-wrap md:flex-nowrap justify-center items-center space-x-4 mt-2">
                <div
                        x-data="copyToClipboard()"
                        class="w-full max-w-md"
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
                        class="w-full max-w-md"
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
</footer>
