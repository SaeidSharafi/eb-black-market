@extends('layouts.app') @section('title', __('telegram.auth.success_title'))
@section('description', __('telegram.auth.success_message')) @push('head')
<meta name="robots" content="noindex, nofollow" />
<script>
    // Auto-refresh to check if user can close window
    setTimeout(() => {
        if (window.opener) {
            window.close();
        }
    }, 3000);
</script>
@endpush @section('content')
<div
    class="min-h-screen flex items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8"
>
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <!-- Success Icon -->
            <div
                class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6"
            >
                <svg
                    class="h-12 w-12 text-green-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                    ></path>
                </svg>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-white mb-4">
                {{ __("telegram.auth.success_title") }}
            </h1>

            <!-- Message -->
            <p class="text-lg text-gray-300 mb-6">
                {{ __("telegram.auth.success_message") }}
            </p>

            <!-- Description -->
            <p class="text-gray-400 mb-8">
                {{ __("telegram.auth.success_description") }}
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            <button
                onclick="window.close()"
                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
            >
                <svg
                    class="w-5 h-5 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"
                    ></path>
                </svg>
                {{ __("telegram.auth.return_to_telegram") }}
            </button>

            <a
                href="{{ route('filament.dashboard.pages.custom-dashboard') }}"
                class="group relative w-full flex justify-center py-3 px-4 border border-gray-600 text-sm font-medium rounded-md text-gray-300 bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out"
            >
                <svg
                    class="w-5 h-5 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"
                    ></path>
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m7 7l5 5l5-5"
                    ></path>
                </svg>
                {{ __("telegram.auth.manage_account") }}
            </a>
        </div>

        <!-- What's Next Section -->
        <div class="mt-8 p-6 bg-gray-800 rounded-lg border border-gray-700">
            <h2 class="text-lg font-semibold text-white mb-4">
                {{ __("telegram.auth.what_next") }}
            </h2>
            <ul class="space-y-3 text-gray-300">
                <li class="flex items-start">
                    <svg
                        class="w-5 h-5 text-green-400 mr-3 mt-0.5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                    {{ __("telegram.auth.start_trading") }}
                </li>
                <li class="flex items-start">
                    <svg
                        class="w-5 h-5 text-green-400 mr-3 mt-0.5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                    {{ __("telegram.auth.explore_market") }}
                </li>
            </ul>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">
                <svg
                    class="w-4 h-4 inline mr-1"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                    ></path>
                </svg>
                {{ __("telegram.auth.security_notice") }}
            </p>
        </div>
    </div>
</div>
@endsection
