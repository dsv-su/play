<!doctype html>
<html lang="se">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./images/favicon.ico">
    <link rel="stylesheet" href="{{ asset('./css/style.css') }}">
    <script src="https://kit.fontawesome.com/7dcdfcd515.js" crossorigin="anonymous" SameSite="none"></script>
    <!-- Development version: -->
    <script src="{{asset('./js/player.js')}}"></script>
    <title>Document</title>
</head>
<body>
<div class="wrapper">

    <div class="head">
        <p>Player</p>
    </div>

    <div class="container">
        <div class="grid">

            <div class="master">
                <button class="switch">Switch Master <i class="fas fa-sync"></i></button>
                <video id="video1" ></video>
            </div>

            <div class="slave1">
                <video hidden muted  id="video2" ></video>
            </div>

            <div class="slave2">
                <video hidden muted  id="video3" ></video>
            </div>

            <div class="slave3">
                <video hidden muted  id="video4" ></video>
            </div>

        </div>
    </div>

    <div class="footer">
        <div class="controls">
            <div class="progressbar_container">
                <div class="progress">
                </div>
            </div>

            <div class="buttons">
                <button id="play-pause"></button>
                <button id="fast-forward"></button>
                <button id="fullscreen"></button>
            </div>
            <div class="time">
                <time id="time-elapsed">00:00</time>
                <span> / </span>
                <time id="duration">00:00</time>
            </div>

        </div>
    </div>

</div>
</body>
</html>
