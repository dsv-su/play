<!DOCTYPE html>
<html class="overflow-x-hidden" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
        <title>@yield('title') {{ config('app.name') }}</title>

        <!-- Viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Helps UA pick default form controls correctly for themes -->
        <meta name="color-scheme" content="light dark" />

        <!-- Prevent FOUC for Alpine -->
        <style>[x-cloak]{display:none !important}</style>

        <!-- Set initial theme *before* any paint -->
        <script>
            (function () {
                try {
                    var storageKey = 'color-theme';
                    var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    var stored = localStorage.getItem(storageKey);
                    var theme = stored || (prefersDark ? 'dark' : 'light');
                    if (theme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                } catch (_) { /* no-op */ }
            })();
        </script>

        <!-- Meta -->
        <meta name="description" content="#" />
        <meta name="keywords" content="#" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- Vite -->
        @vite(['resources/css/site.css', 'resources/js/site.js'])

    </head>


<body class="bg-dsvbg dark:bg-gray-800 overflow-x-hidden">
<main class="min-h-screen">
    @include('dsvheader')
    @include('navbar.navbar')
    {{ $slot }}
    @include('layouts.darktoggler')
</main>

@stack('scripts')
{{-- @include('footer.footer') --}}
</body>
</html>
