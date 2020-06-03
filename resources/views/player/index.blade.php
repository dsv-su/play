<!doctype html>
<html lang="se">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('./images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('./css/style.css') }}">
    <script src="https://kit.fontawesome.com/7dcdfcd515.js" crossorigin="anonymous" SameSite="none"></script>
    <!-- Development version: -->

    <title>DSVPlayer</title>
</head>
<body>
<div class="wrapper">

    <div class="head">
        <p class="dev">[Nu spelas: {{ $video->title }}]</p>&nbsp;&nbsp;&nbsp;<p> Player</p>&nbsp;&nbsp;&nbsp;<p class="dev">[width: <span id="width"></span></p>&nbsp;<p class="dev">height: <span id="height"></span>]</p>&nbsp;&nbsp; <p class="dev">[Streams: <span id="streams"></span>]</p>
        <button id="masterswitch" class="switch">Switch Master <i class="fas fa-sync"></i></button>
    </div>

    <div class="container">
        <div class="grid">

            <div class="master">
                <div class="mastervideo">
                    <video id="video1" src="{{$video->source1}}"></video>
                </div>

            </div>

            <div id="slave1" class="slave1">
                <button id="disable_slave1" class="disable_slave1"><i class="far fa-times-circle fa-2x"></i></button>
                <div class="slavevideo">
                    <video hidden muted  id="video2" src="{{$video->source2}}"></video>
                </div>

            </div>

            <div id="slave2" class="slave2">
                <button id="disable_slave2" class="disable_slave2"><i class="far fa-times-circle fa-2x"></i></button>
                <div class="slavevideo">
                    <video hidden muted  id="video3" src="{{$video->source3}}"></video>
                </div>

            </div>

            <div id="slave3" class="slave3">
                <button id="disable_slave3" class="disable_slave3"><i class="far fa-times-circle fa-2x"></i></button>
                <div class="slavevideo">
                    <video hidden muted  id="video4" src="{{$video->source4}}"></video>
                </div>

            </div>

        </div>
    </div>

    <div class="footer">
        <div class="controls">
            <div class="progressbar_container">
                <progress id="progress-bar" value="0"></progress>
                <input class="seek" id="seek" value="0" min="0" type="range" step="1">
                <div class="seek-tooltip" id="seek-tooltip">00:00</div>
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

            <div class="volumebuttons">
                <button data-title="Mute (m)" class="volume-button" id="volume-button">
                    <svg>
                        <use class="hidden" href="#volume-mute"></use>
                        <use class="hidden" href="#volume-low"></use>
                        <use href="#volume-high"></use>
                    </svg>
                </button>
                <input class="volume" id="volume" value="1" type="range" max="1" min="0" step="0.01">
            </div>
        </div>
    </div>
</div>
<svg style="display: none">
    <defs>
        <symbol id="volume-high" viewBox="0 0 24 24">
            <path d="M14.016 3.234q3.047 0.656 5.016 3.117t1.969 5.648-1.969 5.648-5.016 3.117v-2.063q2.203-0.656 3.586-2.484t1.383-4.219-1.383-4.219-3.586-2.484v-2.063zM16.5 12q0 2.813-2.484 4.031v-8.063q1.031 0.516 1.758 1.688t0.727 2.344zM3 9h3.984l5.016-5.016v16.031l-5.016-5.016h-3.984v-6z"></path>
        </symbol>

        <symbol id="volume-low" viewBox="0 0 24 24">
            <path d="M5.016 9h3.984l5.016-5.016v16.031l-5.016-5.016h-3.984v-6zM18.516 12q0 2.766-2.531 4.031v-8.063q1.031 0.516 1.781 1.711t0.75 2.32z"></path>
        </symbol>

        <symbol id="volume-mute" viewBox="0 0 24 24">
            <path d="M12 3.984v4.219l-2.109-2.109zM4.266 3l16.734 16.734-1.266 1.266-2.063-2.063q-1.547 1.313-3.656 1.828v-2.063q1.172-0.328 2.25-1.172l-4.266-4.266v6.75l-5.016-5.016h-3.984v-6h4.734l-4.734-4.734zM18.984 12q0-2.391-1.383-4.219t-3.586-2.484v-2.063q3.047 0.656 5.016 3.117t1.969 5.648q0 2.203-1.031 4.172l-1.5-1.547q0.516-1.266 0.516-2.625zM16.5 12q0 0.422-0.047 0.609l-2.438-2.438v-2.203q1.031 0.516 1.758 1.688t0.727 2.344z"></path>
        </symbol>
    </defs>
</svg>

<script>
    const heightOutput = document.querySelector('#height');
    const widthOutput = document.querySelector('#width');

    function reportWindowSize() {
        heightOutput.textContent = window.innerHeight;
        widthOutput.textContent = window.innerWidth;
    }

    reportWindowSize();
    window.onresize = reportWindowSize;
</script>
<script src="{{asset('./js/player.js')}}"></script>
</body>
</html>
