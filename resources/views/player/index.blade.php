<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/images/favicon.ico">
    <title>DevPlay</title>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Source+Sans+Pro:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style-main.css" type="text/css" media="all">
    <script src="https://kit.fontawesome.com/7dcdfcd515.js" crossorigin="anonymous"></script>
    <script src="player.js" defer></script>

</head>

<body class="site">

<header class="head">
    <h1>Player</h1>
</header>

<section class="playlist">
    <button class="trigger" aria-expanded="false">Spellista</button>
    <!-- This will be rendered serverside -->
    <nav>
        <ul>
            <li>
                <a href="">Introduktion</a>
            </li>
            <li><a href="#">Föreläsning 2</a></li>
            <li><a href="#">Föreläsning 3</a></li>
            <li><a href="#">Föreläsning 4</a></li>
            <li><a href="#">Föreläsning 5</a></li>
        </ul>
    </nav>
    <!-- end -->
</section>

<main id="content" class="main-area">

    <video id="video1" class="video-4-3"></video>

</main>

<section class="sidebar">

    <div class="stream">
        <div class="video-container-4-3">
            <video hidden id="video2" muted class="video-4-3" ></video>
        </div>
    </div>
    <div class="stream">
        <div class="video-container-4-3">
            <video hidden id="video3" muted class="video-4-3" ></video>
        </div>
    </div>
    <div class="stream">
        <div class="video-container-4-3">
            <video hidden id="video4" muted class="video-4-3" ></video>
        </div>
    </div>

</section>


<footer class="controllbar">

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

</footer>




</body>

</html>
