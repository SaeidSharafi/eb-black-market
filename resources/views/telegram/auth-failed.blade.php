@extends('layouts.app') @section('title', __('telegram.auth.failed_title'))
@section('description', __('telegram.auth.failed_description')) @push('head')
<meta name="robots" content="noindex, nofollow" />
@endpush @section('content')
<div
    class="min-h-screen flex items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8"
>
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <!-- Error Icon -->
            <div
                class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-100 mb-6"
            >
                <svg
                    class="h-12 w-12 text-red-600"
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
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-white mb-4">
                {{ __("telegram.auth.failed_title") }}
            </h1>

            <!-- Description -->
            <p class="text-lg text-gray-300 mb-6">
                {{ __("telegram.auth.failed_description") }}
            </p>

            <!-- Error Message -->
            @if(isset($message) && $message)
            <div
                class="mb-6 p-4 bg-red-900 bg-opacity-50 border border-red-700 rounded-lg"
            >
                <p class="text-red-200 text-sm">
                    <svg
                        class="w-4 h-4 inline mr-2"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                    {{ $message }}
                </p>
            </div>
            @endif
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

            <button
                onclick="window.location.reload()"
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
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                    ></path>
                </svg>
                {{ __("telegram.auth.try_again") }}
            </button>
        </div>

        <!-- Troubleshooting Section -->
        <div class="mt-8 p-6 bg-gray-800 rounded-lg border border-gray-700">
            <h2 class="text-lg font-semibold text-white mb-4">
                <svg
                    class="w-5 h-5 inline mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                </svg>
                Troubleshooting
            </h2>
            <ul class="space-y-2 text-gray-300 text-sm">
                <li class="flex items-start">
                    <span class="text-gray-500 mr-2">•</span>
                    Make sure you're using the latest version of Telegram
                </li>
                <li class="flex items-start">
                    <span class="text-gray-500 mr-2">•</span>
                    Check your internet connection
                </li>
                <li class="flex items-start">
                    <span class="text-gray-500 mr-2">•</span>
                    Try refreshing the page and authenticating again
                </li>
                <li class="flex items-start">
                    <span class="text-gray-500 mr-2">•</span>
                    Contact support if the problem persists
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
