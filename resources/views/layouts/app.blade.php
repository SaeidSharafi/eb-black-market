<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config("app.name", "Laravel") }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=titillium-web:400,600,700&display=swap"
            rel="stylesheet"
        />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js']) @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-900 text-gray-200 dark">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
            <header class="bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endif

            <!-- Page Content -->
            <main>@yield('content')</main>
        </div>
        @livewireScripts
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const button = document.getElementById("lang-switcher-button");
                const dropdown = document.getElementById(
                    "lang-switcher-dropdown"
                );

                button.addEventListener("click", function (event) {
                    event.stopPropagation();
                    dropdown.classList.toggle("hidden");
                });

                document.addEventListener("click", function (event) {
                    if (
                        !button.contains(event.target) &&
                        !dropdown.contains(event.target)
                    ) {
                        dropdown.classList.add("hidden");
                    }
                });
            });
        </script>
    </body>
</html>
