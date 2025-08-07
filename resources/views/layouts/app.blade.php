@php
    $viewHas = View::hasSection('structured_data');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- SEO Meta Tags -->
    <title>
        @yield('title', __('resources.home.title') . ' - ' . config('app.name', 'Empires Market'))
    </title>
    <meta name="description" content="@yield('description', __('resources.home.subtitle'))" />
    <meta name="keywords" content="@yield('keywords', 'Empires Battle, Black Market, NFT Trading, Gaming Marketplace, Crypto Gaming, TON, QRK, NOT tokens')" />
    <meta name="author" content="Empires Market Community" />
    <meta name="robots" content="@yield('robots', 'index, follow')" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="@yield('og_title', __('resources.home.title'))" />
    <meta property="og:description" content="@yield('og_description', __('resources.home.subtitle'))" />
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.png'))" />
    <meta property="og:site_name" content="{{ config('app.name', 'Empires Market') }}" />
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{ url()->current() }}" />
    <meta property="twitter:title" content="@yield('twitter_title', __('resources.home.title'))" />
    <meta property="twitter:description" content="@yield('twitter_description', __('resources.home.subtitle'))" />
    <meta property="twitter:image" content="@yield('twitter_image', asset('images/og-image.png'))" />

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', url()->current())" />

    <!-- Hreflang tags for internationalization -->
    @stack('hreflang')
    @if (!View::hasSection('hreflang'))
        <link rel="alternate" hreflang="en" href="{{ url()->current() }}" />
        <link rel="alternate" hreflang="ru" href="{{ url()->current() }}" />
        <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}" />
    @endif

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}" />

    <!-- Theme Color -->
    <meta name="theme-color" content="#374151" />
    <meta name="msapplication-TileColor" content="#374151" />

    <!-- Performance Optimization -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link rel="dns-prefetch" href="https://fonts.bunny.net" />

    <!-- Preload critical resources -->
    @stack('preload')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=titillium-web:400,600,700&display=swap" rel="stylesheet" />

    <!-- Additional performance hints -->
    <meta http-equiv="x-dns-prefetch-control" content="on" />

    <!-- Additional SEO Meta Tags -->
    @stack('head')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
     @livewireStyles

    <!-- Structured Data -->
    @stack('structured_data')
</head>

<body class="font-sans antialiased bg-gray-900 text-gray-200 dark">
    <!-- Skip to main content for accessibility -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-yellow-400 text-gray-900 px-4 py-2 rounded-md z-50">
        Skip to main content
    </a>

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
        <main id="main-content">@yield('content')</main>
        @include('layouts.footer')
    </div>
    @livewireScripts @stack('scripts')

    <!-- Default Structured Data -->
    @if (!$viewHas)
     @php
             $structure =    json_encode([
                "@context" => "https://schema.org",
                "@type" => "WebSite",
                "name" => config('app.name', 'Empires Market'),
                "url" => url('/'),
                "description" => __('resources.home.subtitle'),
                "potentialAction" => [
                    "@type" => "SearchAction",
                    "target" => url('/market-listings') . '?search={search_term_string}',
                    "query-input" => "required name=search_term_string"
                ]
            ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
            @endphp
        <script type="application/ld+json">
{!! $structure !!}
        </script>
    @endif
</body>

</html>
