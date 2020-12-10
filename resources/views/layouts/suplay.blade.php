<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('./images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('./css/fontawesome/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('/css/su.css')}}">
    <script src="{{asset('./js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap-4.5.3-dist/js/bootstrap.bundle.js')}}"></script>
    <script src="{{asset('js/su.js')}}"></script>
    <title>DSVPlay</title>
</head>
<body>
@include('layouts.partials.header')
<main id="main-content" class="pl-pr-sm-down-0">
    <div class="container-fluid pl-pr-sm-down-0 my-5 pb-5">
        @yield('content')
    </div>
</main>
@include('layouts.partials.footer')
@include('layouts.partials.footer-js')
</body>
</html>
