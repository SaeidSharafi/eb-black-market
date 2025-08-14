<x-filament-widgets::widget>
    <x-filament::section>
        @if($connectUrl)
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div>
                        <svg
                                class="h-6 w-6 text-blue-500"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                        >
                            <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
                            />
                        </svg>
                    </div>
                    <div class="text-sm">
                        <p class="font-medium">
                            {{
                                __(
                                    "resources.filament-widgets.connect-telegram-banner.title"
                                )
                            }}
                        </p>
                        <p class="text-gray-500">
                            {{
                                __(
                                    "resources.filament-widgets.connect-telegram-banner.description"
                                )
                            }}
                        </p>
                    </div>
                </div>

                <div class="telegram-widget-container">
                    <div id="telegram-login-widget" class="telegram-login-widget-container"  x-data="{
    openTelegramPopup(url) {
        const popup = window.open(url, '_blank', 'width=500,height=600');
        const poll = setInterval(() => {
            if (popup.closed) {
                clearInterval(poll);
                window.location.reload();
            }
        }, 500);
    }
}">
                        <button
                                @click="openTelegramPopup('{{ $connectUrl }}?manual=true')"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-lg shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Connect with Telegram
                            <svg class="mx-1  h-5 w-5" id="Livello_1"
                                 data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 240 240"><defs><linearGradient id="linear-gradient" x1="120" y1="240" x2="120" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#1d93d2"/><stop offset="1" stop-color="#38b0e3"/></linearGradient></defs><title>Telegram_logo</title><circle cx="120" cy="120" r="120" fill="url(#linear-gradient)"/><path d="M81.229,128.772l14.237,39.406s1.78,3.687,3.686,3.687,30.255-29.492,30.255-29.492l31.525-60.89L81.737,118.6Z" fill="#c8daea"/><path d="M100.106,138.878l-2.733,29.046s-1.144,8.9,7.754,0,17.415-15.763,17.415-15.763" fill="#a9c6d8"/><path d="M81.486,130.178,52.2,120.636s-3.5-1.42-2.373-4.64c.232-.664.7-1.229,2.1-2.2,6.489-4.523,120.106-45.36,120.106-45.36s3.208-1.081,5.1-.362a2.766,2.766,0,0,1,1.885,2.055,9.357,9.357,0,0,1,.254,2.585c-.009.752-.1,1.449-.169,2.542-.692,11.165-21.4,94.493-21.4,94.493s-1.239,4.876-5.678,5.043A8.13,8.13,0,0,1,146.1,172.5c-8.711-7.493-38.819-27.727-45.472-32.177a1.27,1.27,0,0,1-.546-.9c-.093-.469.417-1.05.417-1.05s52.426-46.6,53.821-51.492c.108-.379-.3-.566-.848-.4-3.482,1.281-63.844,39.4-70.506,43.607A3.21,3.21,0,0,1,81.486,130.178Z" fill="#fff"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="flex items-center justify-center gap-3 p-4">
                <div>
                    <svg
                            class="h-6 w-6 text-gray-400"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                    >
                        <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                        />
                    </svg>
                </div>
                <p class="text-sm text-gray-500">
                    Telegram bot configuration is missing. Please contact an
                    administrator.
                </p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
