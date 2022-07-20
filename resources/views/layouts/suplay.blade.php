<!doctype html>
@if(app()->getLocale() == 'swe')
<html lang="sv">
@else
<html lang="en">
@endif
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
<!-- Bulk editing -->
<div class="position-fixed w-100 text-center" style="left: 0; right: 0; z-index: 999; top: 15%;">
    <form class="form-inline mx-3" id="bulkediting" method="post" action="{{route('edit.bulk.show')}}">
        @csrf
        @method('GET')
        <input type="submit" class="btn btn-sm btn-primary m-auto" style="display: none;" value="Download"/><br/><br/>
    </form>
</div>
<!-- -->
<main id="main-content" class="pl-pr-sm-down-0">
    <div class="container-fluid pl-pr-sm-down-0 my-5 pb-5">
        @yield('content')
    </div>
</main>
@include('layouts.partials.footer')
</body>
</html>
