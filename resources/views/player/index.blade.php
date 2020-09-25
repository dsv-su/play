<!doctype html>
<html lang="se">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('./images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('./css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('./css/style.css') }}">
    <link rel="stylesheet" href="{{asset('./css/fontawesome/css/all.css')}}" >

    <title>{{ $video->title }}</title>
</head>
<body>
<div class="wrapper">

   <div class="container">
    <!-- Container -->
        <!-- Playlist toggle -->
        <button id="playlist_btn" class="transparent_btn playlist_btn"><i class="fas fa-list-ul fa-2x"></i></button>
        <!-- Ease in video-title -->
        <div class="transparent_txt videotitle">{{ $video->title }} från kursen <i>{{ $course->course_name }}</i></div>

           <section class="playlist">
               <!-- This will be rendered serverside -->
               <nav>
                   <ul>
                       <li><strong>Spellista</strong></li>
                       @foreach($playlist as $play)
                           <li>
                               <a href="{{route('player', $play )}}">{{ $play->title }} [{{$play->length}}]</a>
                           </li>
                       @endforeach
                   </ul>
               </nav>

           </section>
        <!--Grid -->
        <div class="grid" id="videocontainer">
            <div id="master" class="master">
                <div id="master_switcher" class="master_switcher"><i class="fas fa-sync fa-3x"></i></div>
                <div class="mastervideo">
                    <video id="video1" src="{{asset($video->source1)}}"></video>
                </div>
            </div>
            @if(!$video->source2 == '')
            <div id="slave1" class="slave1">
                <div id="slave1_switcher" class="slave1_switcher"><i class="fas fa-sync fa-3x"></i></div>
                <div class="slavevideo">
                    <video hidden muted  id="video2" src="{{asset($video->source2)}}"></video>
                </div>

            </div>
            @endif
            @if(!$video->source3 == '')
            <div id="slave2" class="slave2">
                <div id="slave2_switcher" class="slave2_switcher"><i class="fas fa-sync fa-2x"></i></div>
                <div class="slavevideo">
                    <video hidden muted  id="video3" src="{{asset($video->source3)}}"></video>
                </div>

            </div>
            @endif
            @if(!$video->source4 == '')
            <div id="slave3" class="slave3">
                <div id="slave3_switcher" class="slave3_switcher"><i class="fas fa-sync fa-2x"></i></div>
                <div class="slavevideo">
                    <video hidden muted  id="video4" src="{{asset($video->source4)}}"></video>
                </div>

            </div>
            @endif
        <!-- end Grid -->
        </div>
            <div id="controls" class="controls">
                <!-- Controlls -->

                <div  class="video-buffer">
                    <span id="progress-buffer"></span>
                </div>

                <div class="video-progress">
                    <progress id="progress-bar" value="0" min="0"></progress>
                    <input class="seek" id="seek" value="0" min="0" type="range" step="1">
                    <div class="seek-tooltip" id="seek-tooltip">00:00</div>
                </div>

                <div class="bottom-controls">
                    <div class="left-controls">

                        <button data-title="Spela (s)" id="play-pause">
                            <svg class="playback-icons">
                                <use href="#play-icon"></use>
                                <use class="hidden" href="#pause"></use>
                            </svg>
                        </button>

                            <div class="dropdown">
                                <button id="fast-forward">
                                    <svg class="fastforward-icons">
                                        <use href="#icon-forward3"></use>
                                        <use class="hidden" href="#icon-undo"></use>
                                    </svg>
                                </button>
                                <div class="dropdown-content">
                                    <button id="ff">1  X</button>
                                    <button id="ff15">1.5X</button>
                                    <button id="ff3">3  X</button>
                                    <button id="ff4">4  X</button>
                                    <button id="ff5">5  X</button>
                                    <button id="ff6">6  X</button>
                                </div>
                            </div>

                        <div class="volume-controls">
                            <button data-title="Stäng av ljud (l)" class="volume-button" id="volume-button">
                                <svg>
                                    <use class="hidden" href="#volume-mute"></use>
                                    <use class="hidden" href="#volume-low"></use>
                                    <use href="#volume-high"></use>
                                </svg>
                            </button>

                            <input class="volume" id="volume" value="1"
                                   data-mute="0.5" type="range" max="1" min="0" step="0.01">
                        </div>

                        <div class="time">
                            <time id="time-elapsed">00:00</time>
                            <span> / </span>
                            <time id="duration">00:00</time>
                        </div>
                    </div>

                    <div class="right-controls">
                        <div class="dsvplay">DSVPlay</div>
                        <button data-title="[Bitrate: Normal]" class="bitrate" id="bitrate">
                            <svg class="icon icon-sort-amount-asc">
                                <use href="#icon-sort-amount-asc"></use>
                            </svg>

                        </button>
                        <button data-title="[Undertexter: Av]" class="subtitles" id="subtitles">
                            <svg class="icon icon-profile">
                                <use href="#icon-profile"></use>
                            </svg>

                        </button>
                        <button data-title="Helskärm (h)" class="fullscreen-button" id="fullscreen-button">
                            <svg>
                                <use href="#fullscreen"></use>
                                <use href="#fullscreen-exit" class="hidden"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
                <!-- end Controlls -->
            </div>
       <!-- </div>-->
     <!--container end-->
   </div>


<!-- end Wrapper -->
</div>
<!--svg-->
<svg style="display: none">
    <defs>
        <symbol id="pause" viewBox="0 0 24 24">
            <path d="M14.016 5.016h3.984v13.969h-3.984v-13.969zM6 18.984v-13.969h3.984v13.969h-3.984z"></path>
        </symbol>

        <symbol id="play-icon" viewBox="0 0 24 24">
            <path d="M8.016 5.016l10.969 6.984-10.969 6.984v-13.969z"></path>
        </symbol>

        <symbol id="volume-high" viewBox="0 0 24 24">
            <path d="M14.016 3.234q3.047 0.656 5.016 3.117t1.969 5.648-1.969 5.648-5.016 3.117v-2.063q2.203-0.656 3.586-2.484t1.383-4.219-1.383-4.219-3.586-2.484v-2.063zM16.5 12q0 2.813-2.484 4.031v-8.063q1.031 0.516 1.758 1.688t0.727 2.344zM3 9h3.984l5.016-5.016v16.031l-5.016-5.016h-3.984v-6z"></path>
        </symbol>

        <symbol id="volume-low" viewBox="0 0 24 24">
            <path d="M5.016 9h3.984l5.016-5.016v16.031l-5.016-5.016h-3.984v-6zM18.516 12q0 2.766-2.531 4.031v-8.063q1.031 0.516 1.781 1.711t0.75 2.32z"></path>
        </symbol>

        <symbol id="volume-mute" viewBox="0 0 24 24">
            <path d="M12 3.984v4.219l-2.109-2.109zM4.266 3l16.734 16.734-1.266 1.266-2.063-2.063q-1.547 1.313-3.656 1.828v-2.063q1.172-0.328 2.25-1.172l-4.266-4.266v6.75l-5.016-5.016h-3.984v-6h4.734l-4.734-4.734zM18.984 12q0-2.391-1.383-4.219t-3.586-2.484v-2.063q3.047 0.656 5.016 3.117t1.969 5.648q0 2.203-1.031 4.172l-1.5-1.547q0.516-1.266 0.516-2.625zM16.5 12q0 0.422-0.047 0.609l-2.438-2.438v-2.203q1.031 0.516 1.758 1.688t0.727 2.344z"></path>
        </symbol>

        <symbol id="fullscreen" viewBox="0 0 24 24">
            <path d="M14.016 5.016h4.969v4.969h-1.969v-3h-3v-1.969zM17.016 17.016v-3h1.969v4.969h-4.969v-1.969h3zM5.016 9.984v-4.969h4.969v1.969h-3v3h-1.969zM6.984 14.016v3h3v1.969h-4.969v-4.969h1.969z"></path>
        </symbol>

        <symbol id="fullscreen-exit" viewBox="0 0 24 24">
            <path d="M15.984 8.016h3v1.969h-4.969v-4.969h1.969v3zM14.016 18.984v-4.969h4.969v1.969h-3v3h-1.969zM8.016 8.016v-3h1.969v4.969h-4.969v-1.969h3zM5.016 15.984v-1.969h4.969v4.969h-1.969v-3h-3z"></path>
        </symbol>

        <symbol id="icon-forward3" viewBox="0 0 32 32">
            <path d="M16 27v-10l-10 10v-22l10 10v-10l11 11z"></path>
        </symbol>

        <symbol id="icon-undo" viewBox="0 0 32 32">
            <path d="M16 2c-4.418 0-8.418 1.791-11.313 4.687l-4.686-4.687v12h12l-4.485-4.485c2.172-2.172 5.172-3.515 8.485-3.515 6.627 0 12 5.373 12 12 0 3.584-1.572 6.801-4.063 9l2.646 3c3.322-2.932 5.417-7.221 5.417-12 0-8.837-7.163-16-16-16z"></path>
        </symbol>

        <symbol id="icon-sort-amount-asc" viewBox="0 0 32 32">
            <path d="M10 24v-24h-4v24h-5l7 7 7-7h-5z"></path>
            <path d="M14 18h18v4h-18v-4z"></path>
            <path d="M14 12h14v4h-14v-4z"></path>
            <path d="M14 6h10v4h-10v-4z"></path>
            <path d="M14 0h6v4h-6v-4z"></path>
        </symbol>

        <symbol id="icon-file-text" viewBox="0 0 32 32">
            <path d="M27 0h-24c-1.65 0-3 1.35-3 3v26c0 1.65 1.35 3 3 3h24c1.65 0 3-1.35 3-3v-26c0-1.65-1.35-3-3-3zM26 28h-22v-24h22v24zM8 14h14v2h-14zM8 18h14v2h-14zM8 22h14v2h-14zM8 10h14v2h-14z"></path>
        </symbol>

        <symbol id="icon-profile" viewBox="0 0 32 32">
            <path d="M27 0h-24c-1.65 0-3 1.35-3 3v26c0 1.65 1.35 3 3 3h24c1.65 0 3-1.35 3-3v-26c0-1.65-1.35-3-3-3zM26 28h-22v-24h22v24zM8 18h14v2h-14zM8 22h14v2h-14zM10 9c0-1.657 1.343-3 3-3s3 1.343 3 3c0 1.657-1.343 3-3 3s-3-1.343-3-3zM15 12h-4c-1.65 0-3 0.9-3 2v2h10v-2c0-1.1-1.35-2-3-2z"></path>
        </symbol>
    </defs>
</svg>

<script src="{{asset('./js/player.js')}}" defer></script>
</body>
</html>
