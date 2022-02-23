<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('./images/favicon.ico') }}">
    <link rel="stylesheet" href="{{asset('/css/dsvplay.css')}}">
    <script src="{{asset('./js/dsvplay.js')}}"></script>
    <!-- Laravel Livewire -->
    @livewireStyles
    @livewireScripts
    <title>DSVPlay</title>
    @include('layouts.partials.custom-js')
</head>
<body>
@include('layouts.partials.header')
<main id="main-content" class="pl-pr-sm-down-0">
    <div class="container-fluid pl-pr-sm-down-0 my-5 pb-5">
        @yield('content')
    </div>
</main>
@include('layouts.partials.footer')
</body>
</html>
