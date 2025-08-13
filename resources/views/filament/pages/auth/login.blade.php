@php
$botUsername = config('services.telegram-bot-api.username');
$authUrl = url('/telegram/auth');
$origin = url('/');
@endphp

<x-filament-panels::page.simple>
    @if (filament()->hasRegistration())
    <x-slot name="subheading">
        {{ __("filament-panels::pages/auth/login.actions.register.before") }}

        {{ $this->registerAction }}
    </x-slot>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.before') }}

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    <!-- Telegram OAuth Section -->
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div
                    class="w-full border-t border-gray-300 dark:border-gray-600"
                ></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span
                    class="px-2 bg-white text-gray-500 dark:bg-gray-900 dark:text-gray-400"
                >
                    {{ __("auth.telegram.or_continue_with") }}
                </span>
            </div>
        </div>

        <div class="mt-6">
            @if($botUsername)
            <script
                async
                src="https://telegram.org/js/telegram-widget.js?22"
                data-telegram-login="{{ $botUsername }}"
                data-size="large"
                data-auth-url="{{ $authUrl }}"
                data-request-access="write"
                data-userpic="true"
                data-radius="8"
            ></script>
            @else
            <div
                class="bg-yellow-50 border border-yellow-200 rounded-md p-4 dark:bg-yellow-900/50 dark:border-yellow-700"
            >
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg
                            class="h-5 w-5 text-yellow-400"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3
                            class="text-sm font-medium text-yellow-800 dark:text-yellow-200"
                        >
                            {{ __("auth.telegram.not_configured") }}
                        </h3>
                        <div
                            class="mt-2 text-sm text-yellow-700 dark:text-yellow-300"
                        >
                            <p>{{ __("auth.telegram.contact_admin") }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Info about Telegram Login -->
        @if($botUsername)
        <div class="mt-4 text-center">
            <div class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
                <p>🔒 {{ __("auth.telegram.secure_authentication") }}</p>
                <p>✨ {{ __("auth.telegram.no_password_required") }}</p>
                <p>🚀 {{ __("auth.telegram.auto_registration") }}</p>
            </div>
        </div>
        @endif
    </div>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.after') }}

    {{-- Custom styling and scripts --}}
    <style>
        /* Custom styling for Telegram login widget */
        iframe[src*="oauth.telegram.org"] {
            display: block !important;
            margin: 0 auto !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
            transition: all 0.2s ease-in-out !important;
        }

        iframe[src*="oauth.telegram.org"]:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            transform: translateY(-1px) !important;
        }

        /* Dark mode adjustments */
        .dark iframe[src*="oauth.telegram.org"] {
            border: 1px solid rgba(55, 65, 81, 0.5) !important;
        }
    </style>

    <script>
        // Enhanced error handling for Telegram widget
        window.addEventListener("message", function (event) {
            if (event.origin !== "https://oauth.telegram.org") return;

            try {
                const data = JSON.parse(event.data);
                if (data.event === "auth_user") {
                    // Show loading state
                    const widget = document.querySelector(
                        'iframe[src*="oauth.telegram.org"]'
                    );
                    if (widget) {
                        widget.style.opacity = "0.5";
                        widget.style.pointerEvents = "none";
                    }

                    // Add a loading indicator
                    const loadingDiv = document.createElement("div");
                    loadingDiv.className = "text-center mt-2 text-sm text-gray-500";
                    loadingDiv.innerHTML =
                        '⏳ {{ __("auth.telegram.authenticating") }}';
                    if (widget && widget.parentNode) {
                        widget.parentNode.appendChild(loadingDiv);
                    }
                }
            } catch (e) {
                console.log("Telegram widget message:", event.data);
            }
        });
    </script>
</x-filament-panels::page.simple>
