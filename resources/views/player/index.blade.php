<!doctype html>
<html lang="se">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="shortcut icon" href="{{ asset("./css/player/favicon.ico") }}">
<link rel="stylesheet" href="{{ asset("./css/player/style.css?a")}}">
<title></title>
<script src="{{asset("./js/player.js")}}" defer></script>
</head>
  <body>
    <div id="wrapper">
      <div class="stream main">
        <video playsinline="1" preload="auto"></video>
        <svg class="fade">
          <use href="#play-icon"></use>
          <use href="#pause-icon" class="hidden"></use>
        </svg>
        <svg id="loading">
          <use href="#loading-icon"></use>
        </svg>
      </div>
      <div id="about">
        <button id="playlist-button" class="playlist hidden"
                title="Visa spellista"
                data-title_alt="Dölj spellista"
                data-title_en="Show playlist"
                data-title_alt_en="Hide playlist">
          <svg>
            <use href="#playlist-icon"></use>
            <use href="#close-icon" class="hidden"></use>
          </svg>
        </button>
        <h1 id="title"></h1>
        <h2 id="playlist-title" class="hidden"></h2>
        <ul id="playlist" class="collapse"></ul>
      </div>
      <div id="controls">
        <div id="progress-container">
          <canvas id="buffer"></canvas>
          <div id="progress">
            <div id="progress-popup"></div>
          </div>
        </div>
        <div id="left-controls" class="control-box">
          <button id="previous" class="playlist hidden"
                  title="Föregående"
                  data-title_en="Previous">
            <svg>
              <use href="#previous-icon"></use>
            </svg>
          </button>
          <button id="play-button"
                  title="Spela"
                  data-title_alt="Pausa"
                  data-title_en="Play"
                  data-title_alt_en="Pause">
            <svg>
              <use href="#play-icon"></use>
              <use href="#pause-icon" class="hidden"></use>
            </svg>
          </button>
          <button id="next" class="playlist hidden"
                  title="Nästa"
                  data-title_en="Next">
            <svg>
              <use href="#next-icon"></use>
            </svg>
          </button>
          <div class="select" id="speed-select">
            <button id="speed-current"
                    title="Välj hastighet"
                    data-title_en="Speed selection">1</button>
            <ul class="list" id="speed-list">
              <li>
                <button>2</button>
              </li>
              <li>
                <button>1.75</button>
              </li>
              <li>
                <button>1.5</button>
              </li>
              <li>
                <button>1.25</button>
              </li>
              <li>
                <button>1</button>
              </li>
              <li>
                <button>0.75</button>
              </li>
            </ul>
          </div>
          <button id="volume-button"
                  title="Stäng av ljud"
                  data-title_alt="Slå på ljud"
                  data-title_en="Mute"
                  data-title_alt_en="Unmute">
            <svg>
              <use href="#volume-icon"></use>
              <use href="#mute-icon" class="hidden"></use>
            </svg>
          </button>
          <input type="range" id="volume"
                 min="0" max="1" step="0.01" value="1">
          <span id="elapsed"></span>
          <span id="of">/</span>
          <span id="duration"></span>
        </div>
        <div id="center-controls" class="control-box">
          <svg id="more-indicator" class="no-highlight hidden">
            <use href="#down-icon"></use>
          </svg>
        </div>
        <div id="right-controls" class="control-box">
          <button id="timelink-button"
                  title="Kopiera länk till den här tidpunkten"
                  data-title_en="Copy URL at current time">
            <svg>
              <use href="#timelink-icon">
            </svg>
          </button>
          <button id="subtitles-button"
                  title="Undertexter är av"
                  data-title_alt="Undertexter är på"
                  data-title_en="Subtitles are off"
                  data-title_alt_en="Subtitles are on">
            <svg>
              <use href="#subtitles-off-icon"></use>
              <use href="#subtitles-on-icon" class="hidden"></use>
            </svg>
          </button>
          <div class="select" id="resolution-select">
            <button id="resolution-current"
                    title="Välj upplösning"
                    data-title_en="Resolution selection"></button>
            <ul class="list" id="resolution-list">
            </ul>
          </div>
          <button id="fullscreen-button"
                  title="Helskärm"
                  data-title_en="Fullscreen">
            <svg>
              <use href="#fullscreen-enter-icon"></use>
              <use href="#fullscreen-exit-icon" class="hidden"></use>
            </svg>
          </button>
        </div>
      </div>
    </div>
    <template id="stream-template">
      <div class="stream secondary">
        <video playsinline="1" preload="auto"></video>
        <svg class="fade">
          <use href="#switch-icon"></use>
        </svg>
      </div>
    </template>
    <template id="resolution-template">
      <li>
        <button></button>
      </li>
    </template>
    <template id="listitem-template">
      <li class="playlist-item">
        <a>
          <img/>
          <span></span>
        </a>
      </li>
    </template>
    <svg class="hidden">
      <defs>
        <symbol id="pause-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
        </symbol>

        <symbol id="play-icon" viewBox="0 0 24 24">
          <path d="M8.016 5.016l10.969 6.984-10.969 6.984v-13.969z"/>
        </symbol>

        <symbol id="loading-icon" viewBox="0 0 24 24" opacity="0.8">
          <path d="M12,2 a10,10 0 0,1 10,10 a2,2 0 0,1 -4,0 a6,6 0 0,0 -6,-6 a2,2 0 0,1 0,-4 z">
            <animateTransform attributeName="transform"
                              type="rotate"
                              from="0 12 12"
                              to="360 12 12"
                              dur="1800ms"
                              repeatCount="indefinite"/>
          </path>
          <path d="M12,2 a10,10 0 0,1 10,10 a2,2 0 0,1 -4,0 a6,6 0 0,0 -6,-6 a2,2 0 0,1 0,-4 z"
                transform="rotate(120 12 12)">
            <animateTransform attributeName="transform"
                              type="rotate"
                              from="0 12 12"
                              to="360 12 12"
                              dur="2400ms"
                              repeatCount="indefinite"/>
          </path>
          <path d="M12,2 a10,10 0 0,1 10,10 a2,2 0 0,1 -4,0 a6,6 0 0,0 -6,-6 a2,2 0 0,1 0,-4 z"
                transform="rotate(240 12 12)">
            <animateTransform attributeName="transform"
                              type="rotate"
                              from="0 12 12"
                              to="360 12 12"
                              dur="3000ms"
                              repeatCount="indefinite"/>
          </path>
        </symbol>

        <symbol id="next-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/><path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z"/>
        </symbol>

        <symbol id="previous-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/><path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"/>
        </symbol>

        <symbol id="playlist-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/>
        </symbol>

        <symbol id="close-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
        </symbol>
        <symbol id="switch-icon" viewBox="0 0 24 24">
          <path d="M12 6v1.79c0 .45.54.67.85.35l2.79-2.79c.2-.2.2-.51 0-.71l-2.79-2.79c-.31-.31-.85-.09-.85.36V4c-4.42 0-8 3.58-8 8 0 1.04.2 2.04.57 2.95.27.67 1.13.85 1.64.34.27-.27.38-.68.23-1.04C6.15 13.56 6 12.79 6 12c0-3.31 2.69-6 6-6zm5.79 2.71c-.27.27-.38.69-.23 1.04.28.7.44 1.46.44 2.25 0 3.31-2.69 6-6 6v-1.79c0-.45-.54-.67-.85-.35l-2.79 2.79c-.2.2-.2.51 0 .71l2.79 2.79c.31.31.85.09.85-.35V20c4.42 0 8-3.58 8-8 0-1.04-.2-2.04-.57-2.95-.27-.67-1.13-.85-1.64-.34z"/>
        </symbol>

        <symbol id="volume-icon" viewBox="0 0 24 24">
          <path d="M14.016 3.234q3.047 0.656 5.016 3.117t1.969 5.648-1.969 5.648-5.016 3.117v-2.063q2.203-0.656 3.586-2.484t1.383-4.219-1.383-4.219-3.586-2.484v-2.063zM16.5 12q0 2.813-2.484 4.031v-8.063q1.031 0.516 1.758 1.688t0.727 2.344zM3 9h3.984l5.016-5.016v16.031l-5.016-5.016h-3.984v-6z"/>
        </symbol>

        <symbol id="mute-icon" viewBox="0 0 24 24">
          <path d="M12 3.984v4.219l-2.109-2.109zM4.266 3l16.734 16.734-1.266 1.266-2.063-2.063q-1.547 1.313-3.656 1.828v-2.063q1.172-0.328 2.25-1.172l-4.266-4.266v6.75l-5.016-5.016h-3.984v-6h4.734l-4.734-4.734zM18.984 12q0-2.391-1.383-4.219t-3.586-2.484v-2.063q3.047 0.656 5.016 3.117t1.969 5.648q0 2.203-1.031 4.172l-1.5-1.547q0.516-1.266 0.516-2.625zM16.5 12q0 0.422-0.047 0.609l-2.438-2.438v-2.203q1.031 0.516 1.758 1.688t0.727 2.344z"/>
        </symbol>

        <symbol id="down-icon" viewBox="0 0 24 24">
          <polygon points="6.23,20.23 8,22 18,12 8,2 6.23,3.77 14.46,12" transform="rotate(90, 12, 12)"/>
        </symbol>

        <symbol id="timelink-icon" viewBox="0 0 24 24">
          <path d="m 8,11 6.034644,0.0768 -1.779826,1.91574 L 8,13 Z m 12.211341,0.499144 h 1.9 C 22.111341,8.7391436 19.76,7 17,7 h -4 v 1.9 h 4 c 1.71,0 3.211341,0.8891436 3.211341,2.599144 z M 3.9,12 C 3.9,10.29 5.29,8.9 7,8.9 h 4 V 7 H 7 c -2.76,0 -5,2.24 -5,5 0,2.76 2.24,5 5,5 h 4 V 15.1 H 7 C 5.29,15.1 3.9,13.71 3.9,12 Z"/>
          <path d="M 11.99,2 C 6.47,2 2,6.48 2,12 2,17.52 6.47,22 11.99,22 17.52,22 22,17.52 22,12 22,6.48 17.52,2 11.99,2 Z M 15.29,16.71 11,12.41 V 7 h 2 v 4.59 l 3.71,3.71 z"
                transform="matrix(0.49567486,0,0,0.49567486,11.505292,10.652661)"/>
        </symbol>

        <symbol id="subtitles-off-icon" viewBox="0 0 24 24">
          <path d="M20,4H6.83l8,8H19c0.55,0,1,0.45,1,1c0,0.55-0.45,1-1,1h-2.17l4.93,4.93C21.91,18.65,22,18.34,22,18V6C22,4.9,21.1,4,20,4 z"/><path d="M20,20l-6-6l-1.71-1.71L12,12L3.16,3.16c-0.39-0.39-1.02-0.39-1.41,0c-0.39,0.39-0.39,1.02,0,1.41l0.49,0.49 C2.09,5.35,2,5.66,2,6v12c0,1.1,0.9,2,2,2h13.17l2.25,2.25c0.39,0.39,1.02,0.39,1.41,0c0.39-0.39,0.39-1.02,0-1.41L20,20z M8,13 c0,0.55-0.45,1-1,1H5c-0.55,0-1-0.45-1-1c0-0.55,0.45-1,1-1h2C7.55,12,8,12.45,8,13z M14,17c0,0.55-0.45,1-1,1H5 c-0.55,0-1-0.45-1-1c0-0.55,0.45-1,1-1h8c0.08,0,0.14,0.03,0.21,0.04l0.74,0.74C13.97,16.86,14,16.92,14,17z"/>
        </symbol>

        <symbol id="subtitles-on-icon" viewBox="0 0 24 24">
          <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM5 12h2c.55 0 1 .45 1 1s-.45 1-1 1H5c-.55 0-1-.45-1-1s.45-1 1-1zm8 6H5c-.55 0-1-.45-1-1s.45-1 1-1h8c.55 0 1 .45 1 1s-.45 1-1 1zm6 0h-2c-.55 0-1-.45-1-1s.45-1 1-1h2c.55 0 1 .45 1 1s-.45 1-1 1zm0-4h-8c-.55 0-1-.45-1-1s.45-1 1-1h8c.55 0 1 .45 1 1s-.45 1-1 1z"/>
        </symbol>

        <symbol id="fullscreen-enter-icon" viewBox="0 0 24 24">
          <path d="M14.016 5.016h4.969v4.969h-1.969v-3h-3v-1.969zM17.016 17.016v-3h1.969v4.969h-4.969v-1.969h3zM5.016 9.984v-4.969h4.969v1.969h-3v3h-1.969zM6.984 14.016v3h3v1.969h-4.969v-4.969h1.969z"/>
        </symbol>

        <symbol id="fullscreen-exit-icon" viewBox="0 0 24 24">
          <path d="M15.984 8.016h3v1.969h-4.969v-4.969h1.969v3zM14.016 18.984v-4.969h4.969v1.969h-3v3h-1.969zM8.016 8.016v-3h1.969v4.969h-4.969v-1.969h3zM5.016 15.984v-1.969h4.969v4.969h-1.969v-3h-3z"/>
        </symbol>
      </defs>
    </svg>
  </body>
</html>
