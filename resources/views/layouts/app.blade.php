<!DOCTYPE html>
<html class="overflow-x-hidden" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
        <title>@yield('title') {{ config('app.name') }}</title>

        <!-- Viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Optional/legacy: <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->

        <!-- Meta -->
        <meta name="description" content="#">
        <meta name="keywords" content="#">
        <!-- Set initial theme before paint to avoid FOUC -->
        <script>
            (function () {
                const storageKey = 'color-theme';
                const classList = document.documentElement.classList;
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                let stored;
                try { stored = localStorage.getItem(storageKey); } catch (_) {}

                const theme = stored || (prefersDark ? 'dark' : 'light');
                if (theme === 'dark') classList.add('dark'); else classList.remove('dark');
            })();
        </script>

        @livewireStyles
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite(['resources/css/site.css', 'resources/js/site.js'])
    </head>

    <body class="bg-dsvbg dark:bg-gray-800 overflow-x-hidden">
        <main class="min-h-screen">
            @yield('content')
        </main>

        @livewireScripts
        @include('footer.footer')
        @stack('scripts')
    </body>
</html>

