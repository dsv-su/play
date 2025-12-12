<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">-->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'DSV') }}</title>
        <!-- Include multiplayer.js -->
        <script src="{{ asset('js/multiplayer.js') }}" defer></script>
        <style>
            /* Reset margin and padding for body */
            body {
                margin: 0;
                padding: 0;
                width: 100vw;
                height: 100vh;
            }
        </style>
    </head>
    <body>
        <div id="player">
            <div class="container">
                <!-- Multiplayer Component -->
                <multi-player
                    style="width: 100vw; height: 100vh;"
                    play="/presentation/{{ $presentation }}"
                    @if(isset($playlist)) list="/playlist/{{ $playlist }}" @endif
                    @if(isset($s)) s="{{ $s }}" @endif>
                </multi-player>
            </div>
        </div>
    </body>
</html>



