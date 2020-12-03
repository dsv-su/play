<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('./images/favicon.ico') }}">
    <link rel="stylesheet" href="{{asset('./css/fontawesome/css/all.css')}}" >
    <link rel="stylesheet" href="{{asset('/css/su.css')}}">
    <link rel="stylesheet" href="{{asset('/css/navhead.css')}}">
    <link rel="stylesheet" href="{{asset('/css/navmenu.css')}}">
    <link rel="stylesheet" href="{{asset('/css/search.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css')}}"/>
    <script src="{{asset('./js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap-4.5.3-dist/js/bootstrap.bundle.js')}}"></script>
    <script src="{{asset('js/su.js')}}"></script>
    <title>DSVPlay</title>
</head>
<body>
@yield('content')
</body>
</html>
