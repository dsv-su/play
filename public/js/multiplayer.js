'use strict';
(function() {
    const style = document.createElement('template');
    style.innerHTML = `
    <style type="text/css">

/* global settings */

:host {
    display: block;
    --background: black;
    --background-other: rgba(255,255,255,0.15);
    --backdrop: rgba(0, 0, 0, 0.7);
    --foreground: white;
    --highlight: #9BB2CE;
    --spotlight: #EB7125;
    --fade: #a4a4a4;
    --fade-other: #ababab;

    --gap: 3px;
    --svg-size: calc(var(--gap) * 8);
    --controls-height: calc(var(--gap) * 10);
    --progress-height: calc(var(--gap) * 2);
    --controls-fullheight: calc(var(--progress-height)
                                + var(--gap) * 4
                                + var(--controls-height));

    --font: verdana, sans-serif;

    --range-size: calc(var(--gap) * 2);
    --range-corner: var(--gap);
}

svg {
    fill: var(--foreground);
}
#sidebar svg,
#controls svg {
    height: var(--svg-size);
    width: var(--svg-size);
}
#viewport svg {
    height: calc(var(--svg-size)*3);
    width: calc(var(--svg-size)*3);
}
button {
    background: none;
    border: none;
    color: var(--foreground);
}

/* passive element styles */

/** general layout **/

#player-root {
    margin: 0;
    padding: 0;
    height: 100%;
 /* min-height: 250px; */
    width: 100%;
 /* min-width: 550px; */
    background-color: var(--background);
    color: var(--foreground);
    font-family: var(--font);
    display: grid;
    overflow: hidden;
    position: relative;
    container: player-root / size;
}

#title {
    grid-area: title;
    z-index: 2;
}

#viewport {
    display: grid;
    gap: var(--gap);
    z-index: 1;
    grid-auto-rows: minmax(0, 1fr);
    grid-auto-columns: minmax(0, 1fr);
    max-height: 100cqh;
}

/** about box **/

#sidebar {
    position: absolute;
    top: 0;
    left: 0;
    display: grid;
    grid-template-columns: 3rem auto;
    grid-template-rows: 3rem;
    grid-template-areas: "button title" "playlist playlist";
    align-items: start;
    justify-items: start;
    background-color: var(--backdrop);
    z-index: 2;
    overflow-y: hidden;
}
#sidebar.open {
    height: calc(100% - var(--controls-height));
}
#playlist-button, #title, #playlist-title {
    padding: calc(var(--gap) * 4);
    margin: 0;
    font-size: 120%;
    place-self: stretch;
}
#playlist-button {
    grid-area: button;
    width: 3rem;
}
#title, #playlist-title {
    grid-area: title;
}
#playlist {
    grid-area: playlist;
    place-self: stretch;
    display: flex;
    flex-direction: column;
    list-style: none;
    margin: 0;
    padding: 0;
    overflow-y: auto;
    max-height: 100%;
    margin-bottom: calc(var(--progress-height)
                        + var(--gap) * 4);
}
.playlist-item a {
    padding: calc(var(--gap)*3);
    color: var(--foreground);
    display: grid;
    grid-template-areas: "thumb title" "thumb description";
    grid-template-columns: 290px auto;
    justify-items: start;
    text-decoration: none;
}
.playlist-item img {
    width: 100%;
    height: auto;
    margin: var(--gap);
    border: 1px solid var(--fade);
    grid-area: thumb;
}
.playlist-item span {
    margin: calc(var(--gap) * 3);
    max-width: 30vw;
}
.playlist-item span.title {
    grid-area: title;
    font-size: 110%;
}
.playlist-item span.desc {
    grid-area: description;
}
.current a {
    background-color: var(--background-other);
}

/** control box **/

#controls {
    position: absolute;
    width: 100%;
    bottom: 0;
    left: 0;
    display: grid;
    row-gap: var(--gap);
    grid-template-areas: "progress progress" "left right";
    grid-template-columns: 1fr 1fr;
    z-index: 2;
}
#controls button {
    padding: 0 calc(var(--gap) * 2);
}
#controls button,
#controls span {
    font-size: 100%;
}
#controls button,
#controls input {
    margin: 0;
    height: var(--controls-height);
}
#progress-container {
    position: relative;
    grid-area: progress;
    margin: 0 calc(var(--gap) * 3);
    height: calc(var(--progress-height) + var(--gap) * 2);
    opacity: 60%;
}
#buffer, #progress {
    position: absolute;
    top: 0;
    left: 0;
    height: var(--progress-height);
}
#buffer {
    background-color: var(--fade);
    width: 100%;
    z-index: 1;
}
#progress {
    background-color: var(--spotlight);
    z-index: 2;
}
#progress-popup {
    position: absolute;
    top: 0;
    left: 0;
    transform: translate(-50%, -150%);
    background: var(--background);
    border-radius: var(--gap);
    padding: var(--gap);
    visibility: hidden;
    opacity: 0;
    user-select: none;
}
#left-controls,
#right-controls {
    display: flex;
    align-items: stretch;
    height: var(--controls-height);
    background-color: var(--backdrop);
}
#left-controls > *,
#right-controls > * {
    display: flex;
    align-items: center;
    justify-content: center;
}
#left-controls {
    grid-area: left;
}
#right-controls {
    grid-area: right;
    justify-content: flex-end;
}
#loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0.5;
    background-color: black;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
}
#loading-overlay > svg {
    height: 50%;
}
.select {
    position: relative;
    user-select: none;
}
.list {
    visibility: hidden;
    opacity: 0;
    position: absolute;
    right: 0;
    bottom: 0;
    padding: 0;
    margin-top: 0;
    margin-bottom: var(--controls-height);
    padding-bottom: var(--gap);
    list-style: none;
    width: max-content;
}
.list li {
    background-color: var(--fade);
}
.list li:nth-child(2n) {
    background-color: var(--fade-other);
}
.list button {
    text-align: right;
    width: 100%;
}
#speed-select button::after {
    content: "x";
}
#resolution-select button::after {
    content: "p";
}
#volume {
    width: 0;
    visibility: hidden;
}
#elapsed,
#duration {
    padding: 0 var(--gap);
}

/** video streams **/

video {
    max-height: 100%;
    max-width: 100%;
}
.stream {
    display: grid;
    position: relative;
    grid-column-start: 4;
    place-items: stretch;
}
.stream.main {
    grid-row: 1 / 4;
    grid-column: 1 / 4;
}

@container player-root (max-aspect-ratio: 1.85) {
    /*
    this is the aspect ratio when the vertical
    stacking starts/stops fitting in the container
    */
    .stream {
        grid-column: auto;
    }
    .stream.main {
        grid-row: 2 / 5;
    }
}
@container player-root (width < 450px) {
    #of, #duration {
        display: none;
    }
}
.stream > video {
    grid-row: 1 / 4;
    grid-column: 1 / 4;
}
.stream > svg {
    grid-row: 2 / 3;
    grid-column: 2 / 3;
    place-self: center;
}
.fade {
    opacity: 0;
}

/** subtitles **/
video::cue {
    background-color: var(--backdrop);
}

/* dynamic changes */

:focus {
    outline: 2px solid var(--highlight);
}

/** element hiding **/

.hidden {
    display: none !important;
}
.nocursor {
    cursor: none;
}
.nocursor .fade {
    opacity: 0 !important;
}
.nocursor #sidebar,
.nocursor #controls {
    max-height: 0;
}

/** element showing **/

.stream:hover > .fade {
    opacity: 80%;
}
#progress-container:hover,
#progress-container:focus-within {
    opacity: 100%;
}
#progress-container:hover #progress-popup,
#progress-container:focus-within #progress-popup {
    visibility: visible;
    opacity: 100%;
}
#progress-container:hover #progress::after,
#progress-container:focus-within #progress::after {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    right: 0;
    transform: translate(50%, -25%);
    border: var(--progress-height) solid var(--spotlight);
    border-radius: var(--progress-height);
    pointer-events: none;
}
.select:focus-within .list,
.select:hover .list {
    visibility: initial;
    opacity: 100%;
}
#volume-button:hover + #volume,
#volume-button:focus + #volume,
#volume:hover,
#volume:focus-within {
    width: 5rem;
    visibility: initial;
}

/** highlighting **/

svg:hover,
svg:focus,
*:hover > svg,
*:focus > svg {
    fill: var(--highlight);
    display: initial;
}
/* override highlight for non-interactive icons */
.no-highlight:hover,
*:hover > .no-highlight {
    fill: var(--foreground);
}

.playlist-item a:hover {
    background-color: rgba(255,255,255,0.2);
    color: inherit;
}
.playlist-item a:hover img {
    border-color: var(--highlight);
}
.select:focus-within .current,
.select:hover .current {
    color: var(--highlight);
}
.list button:hover,
.list button:focus {
    background-color: var(--highlight);
}

/** transition settings **/

.fade {
    transition: opacity 0.5s;
}

#sidebar,
#controls {
    transition: max-height 0.5s;
    max-height: 100%;
}
#progress-container {
    transition: opacity 0.5s;
}
#progress-popup {
    transition: opacity 0.5s, visibility 0.5s;
}
.list {
    transition: opacity 0.5s, visibility 0.5s;
}
#volume {
    transition: width 0.5s, visibility 0.5s;
}

::-webkit-scrollbar {
    width: 10px;
    background-color: #424242
}

::-webkit-scrollbar {
    width: 15px;
}

::-webkit-scrollbar-track {
    background-color: #424242
}

::-webkit-scrollbar-thumb {
    background-color: #8e8e8e;
    border: 1px solid #424242;
    border-radius: 5px
}

::-webkit-scrollbar-thumb {
    border-radius: 8px;
}

/* Range styles, here be dragons */

/* make everything invisible */
input[type="range"] {
    background: transparent;
}
input[type="range"]::-moz-range-thumb {
    border: none;
}
input[type="range"]::-ms-track {
    background: transparent;
    border-color: transparent;
    color: transparent;
}

/* style the thumb */
#volume::-moz-range-thumb {
    height: var(--range-size);
    width: var(--range-size);
    border-radius: var(--range-corner);
    background-color: var(--foreground);
}
#volume:hover::-moz-range-thumb,
#volume:focus::-moz-range-thumb {
    border: var(--gap) solid var(--foreground);
}

#volume::-ms-thumb {
    height: var(--range-size);
    width: var(--range-size);
    border-radius: var(--range-corner);
    background-color: var(--foreground);
}
#volume:hover::-ms-thumb,
#volume:focus::-ms-thumb {
    background-color: var(--highlight);
    border: 1px solid var(--foreground);
}

/* style the track */
#volume::-moz-range-track {
    background-color: var(--fade-other);
    border-radius: var(--range-corner);
    height: var(--range-size);
}

#volume::-ms-track {
    background-color: var(--fade-other);
    border-radius: var(--range-corner);
    height: var(--range-size);
}

/* style the filled portion */

#volume::-moz-range-progress {
    background-color: var(--foreground);
    height: var(--range-size);
    border-radius: var(--range-corner);
}
#volume:hover::-moz-range-progress,
#volume:focus::-moz-range-progress {
    background-color: var(--highlight);
}

#volume::-ms-fill-lower {
    background-color: var(--foreground);
    height: var(--range-size);
    border-radius: var(--range-corner);
}
#volume:hover::-ms-fill-lower,
#volume:focus::-ms-fill-lower {
    background-color: var(--highlight);
}

/* chrome is an idiot */
@media screen and (-webkit-min-device-pixel-ratio:0) {
    #volume {
        -webkit-appearance: none;
    }
    #volume::-webkit-slider-thumb {
        -webkit-appearance: none;
        height: var(--range-size);
        width: var(--range-size);
        border-radius: var(--range-corner);
        background-color: var(--foreground);
        box-shadow: -100vw 0 0 calc(100vw - var(--range-corner)) var(--foreground);
    }
    #volume:hover::-webkit-slider-thumb,
    #volume:focus::-webkit-slider-thumb {
        border: 1px solid var(--foreground);
        box-shadow: -100vw 0 0 calc(100vw - var(--range-corner)) var(--highlight);
    }
    #volume::-webkit-slider-runnable-track {
        background-color: var(--fade-other);
        border-radius: var(--range-corner);
        overflow: hidden;
    }
}
    </style>
    `;

    const icons = document.createElement('template');
    icons.innerHTML = `
    <svg class="hidden">
      <defs>
        <symbol id="pause-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
        </symbol>

        <symbol id="play-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
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
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z"/>
        </symbol>

        <symbol id="previous-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"/>
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
          <path d="M0 0h24v24H0z" fill="none"/>
          <g transform="scale(0.8) translate(3,3)">
            <path d="M12 6v1.79c0 .45.54.67.85.35l2.79-2.79c.2-.2.2-.51 0-.71l-2.79-2.79c-.31-.31-.85-.09-.85.36V4c-4.42 0-8 3.58-8 8 0 1.04.2 2.04.57 2.95.27.67 1.13.85 1.64.34.27-.27.38-.68.23-1.04C6.15 13.56 6 12.79 6 12c0-3.31 2.69-6 6-6zm5.79 2.71c-.27.27-.38.69-.23 1.04.28.7.44 1.46.44 2.25 0 3.31-2.69 6-6 6v-1.79c0-.45-.54-.67-.85-.35l-2.79 2.79c-.2.2-.2.51 0 .71l2.79 2.79c.31.31.85.09.85-.35V20c4.42 0 8-3.58 8-8 0-1.04-.2-2.04-.57-2.95-.27-.67-1.13-.85-1.64-.34z"/>
          </g>
        </symbol>

        <symbol id="volume-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M14.016 3.234q3.047 0.656 5.016 3.117t1.969 5.648-1.969 5.648-5.016 3.117v-2.063q2.203-0.656 3.586-2.484t1.383-4.219-1.383-4.219-3.586-2.484v-2.063zM16.5 12q0 2.813-2.484 4.031v-8.063q1.031 0.516 1.758 1.688t0.727 2.344zM3 9h3.984l5.016-5.016v16.031l-5.016-5.016h-3.984v-6z"/>
        </symbol>

        <symbol id="mute-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M12 3.984v4.219l-2.109-2.109zM4.266 3l16.734 16.734-1.266 1.266-2.063-2.063q-1.547 1.313-3.656 1.828v-2.063q1.172-0.328 2.25-1.172l-4.266-4.266v6.75l-5.016-5.016h-3.984v-6h4.734l-4.734-4.734zM18.984 12q0-2.391-1.383-4.219t-3.586-2.484v-2.063q3.047 0.656 5.016 3.117t1.969 5.648q0 2.203-1.031 4.172l-1.5-1.547q0.516-1.266 0.516-2.625zM16.5 12q0 0.422-0.047 0.609l-2.438-2.438v-2.203q1.031 0.516 1.758 1.688t0.727 2.344z"/>
        </symbol>

        <symbol id="down-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <polygon points="6.23,20.23 8,22 18,12 8,2 6.23,3.77 14.46,12" transform="rotate(90, 12, 12)"/>
        </symbol>

        <symbol id="timelink-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="m 8,11 6.034644,0.0768 -1.779826,1.91574 L 8,13 Z m 12.211341,0.499144 h 1.9 C 22.111341,8.7391436 19.76,7 17,7 h -4 v 1.9 h 4 c 1.71,0 3.211341,0.8891436 3.211341,2.599144 z M 3.9,12 C 3.9,10.29 5.29,8.9 7,8.9 h 4 V 7 H 7 c -2.76,0 -5,2.24 -5,5 0,2.76 2.24,5 5,5 h 4 V 15.1 H 7 C 5.29,15.1 3.9,13.71 3.9,12 Z"/>
          <path d="M 11.99,2 C 6.47,2 2,6.48 2,12 2,17.52 6.47,22 11.99,22 17.52,22 22,17.52 22,12 22,6.48 17.52,2 11.99,2 Z M 15.29,16.71 11,12.41 V 7 h 2 v 4.59 l 3.71,3.71 z"
                transform="matrix(0.49567486,0,0,0.49567486,11.505292,10.652661)"/>
        </symbol>

        <symbol id="subtitles-off-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M20,4H6.83l8,8H19c0.55,0,1,0.45,1,1c0,0.55-0.45,1-1,1h-2.17l4.93,4.93C21.91,18.65,22,18.34,22,18V6C22,4.9,21.1,4,20,4 z"/><path d="M20,20l-6-6l-1.71-1.71L12,12L3.16,3.16c-0.39-0.39-1.02-0.39-1.41,0c-0.39,0.39-0.39,1.02,0,1.41l0.49,0.49 C2.09,5.35,2,5.66,2,6v12c0,1.1,0.9,2,2,2h13.17l2.25,2.25c0.39,0.39,1.02,0.39,1.41,0c0.39-0.39,0.39-1.02,0-1.41L20,20z M8,13 c0,0.55-0.45,1-1,1H5c-0.55,0-1-0.45-1-1c0-0.55,0.45-1,1-1h2C7.55,12,8,12.45,8,13z M14,17c0,0.55-0.45,1-1,1H5 c-0.55,0-1-0.45-1-1c0-0.55,0.45-1,1-1h8c0.08,0,0.14,0.03,0.21,0.04l0.74,0.74C13.97,16.86,14,16.92,14,17z"/>
        </symbol>

        <symbol id="subtitles-on-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM5 12h2c.55 0 1 .45 1 1s-.45 1-1 1H5c-.55 0-1-.45-1-1s.45-1 1-1zm8 6H5c-.55 0-1-.45-1-1s.45-1 1-1h8c.55 0 1 .45 1 1s-.45 1-1 1zm6 0h-2c-.55 0-1-.45-1-1s.45-1 1-1h2c.55 0 1 .45 1 1s-.45 1-1 1zm0-4h-8c-.55 0-1-.45-1-1s.45-1 1-1h8c.55 0 1 .45 1 1s-.45 1-1 1z"/>
        </symbol>

        <symbol id="fullscreen-enter-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M14.016 5.016h4.969v4.969h-1.969v-3h-3v-1.969zM17.016 17.016v-3h1.969v4.969h-4.969v-1.969h3zM5.016 9.984v-4.969h4.969v1.969h-3v3h-1.969zM6.984 14.016v3h3v1.969h-4.969v-4.969h1.969z"/>
        </symbol>

        <symbol id="fullscreen-exit-icon" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M15.984 8.016h3v1.969h-4.969v-4.969h1.969v3zM14.016 18.984v-4.969h4.969v1.969h-3v3h-1.969zM8.016 8.016v-3h1.969v4.969h-4.969v-1.969h3zM5.016 15.984v-1.969h4.969v4.969h-1.969v-3h-3z"/>
        </symbol>
      </defs>
    </svg>
    `;

    /*
     *  Parse the GET parameters in the URL bar into an Object, mapping keys
     *  to values. Will not behave properly on repeated keys.
     *
     *  Recognizes two nested levels of key-value pairs:
     *  key1=value1&key2=value2 (standard GET syntax)
     *  nestedKey1:nestedValue1;nestedKey2:nestedValue2 (custom extension)
     *
     *  This would be a full query string with a nested key-value mapping:
     *  key1=nestedkey1:nestedvalue1;nestedkey2:nestedvalue2&key2=value2
     *
     *  The Object has a toString() method which returns the parameters in the
     *  same format as `window.location.search`.
     */
    function parseGETParameters(presID) {
        const get = window.location.search.substring(1);
        const out = {};
        get.split('&').forEach((arg) => {
            if(arg === '') {
                return;
            }
            const split = arg.split('=');
            const name = split[0];
            var value = null;
            if(name === presID) {
                value = {};
                split[1].split(';').forEach((localarg) => {
                    const [localkey, localvalue] = localarg.split(':');
                    value[localkey] = localvalue;
                });
            } else if(split.length > 1) {
                value = split[1];
            }
            out[name] = value;
        });
        out.toString = function() {
            // Return a properly formatted search string
            const result = [];
            Object.keys(this).forEach((key) => {
                if(key === 'toString') {
                    return;
                }
                if(key === presID) {
                    const localresult = [];
                    Object.keys(this[key]).forEach((localkey) => {
                        localresult.push(localkey + ':'
                                         + this[key][localkey]);
                    });
                    result.push(key + '=' + localresult.join(';'));
                } else if(this[key]) {
                    result.push(key + '=' + this[key]);
                } else {
                    result.push(key);
                }
            });
            return '?' + result.join('&');
        }

        return out;
    }

    function createElementNS(ns, tagName, attributes={}, children=[]) {
        const elem = document.createElementNS(ns, tagName);
        Object.entries(attributes).forEach(([key, value]) => {
            elem.setAttribute(key, value);
        });
        if(children) {
            for(let i=0; i<children.length; ++i) {
                let child = children[i];
                if(typeof child === "string") {
                    child = document.createTextNode(child);
                }
                elem.appendChild(child);
            }
        }
        return elem;
    }

    function createElement(tagName, attributes={}, children=[]) {
        return createElementNS(
            'http://www.w3.org/1999/xhtml', tagName, attributes, children);
    }

    function createSVGElement(tagName, attributes={}, children=[]) {
        return createElementNS(
            'http://www.w3.org/2000/svg', tagName, attributes, children);
    }

    function createChild(tagName, attributes={}, children=[]) {
        const elem = createElement(tagName, attributes, children);
        this.appendChild(elem);
        return elem;
    }
    if(typeof HTMLElement.prototype.createChild === 'undefined') {
        HTMLElement.prototype.createChild = createChild;
    } else {
        throw new Error(
            "HTMLElement.prototype.createChild already exists. "
            + "This will require a patch.");
    }

    function createIcon(hrefs, attributes={}) {
        const alternatives = [];
        for(let i=0; i<hrefs.length; ++i) {
            const icon = createSVGElement('use',
                                          {'href': `#${hrefs[i]}-icon`});
            if(i>0) {
                icon.setAttribute('class', 'hidden');
            }
            alternatives.push(icon);
        }
        if(attributes.viewBox === undefined) {
            attributes.viewBox = "0 0 24 24";
        }
        return createSVGElement('svg', attributes, alternatives);
    }

    function createChoiceList(name, title,
                              choiceList=[], defaultIndex=0) {
        const wrapper = createElement('div', {'id': `${name}-select`,
                                              'class': 'select'});
        if(choiceList.length === 0) {
            return wrapper;
        }
        wrapper.createChild('button',
                            {'id': `${name}-current`,
                             'title': title},
                            [choiceList[defaultIndex]]);
        const list = wrapper.createChild('ul', {'id': `${name}-list`,
                                                'class': 'list'});
        for(let i=0; i<choiceList.length; ++i) {
            list.createChild('li')
                .createChild('button', {}, [choiceList[i]]);
        }
        return wrapper;
    }

    function randString(length) {
        let pool = 'abcdefghijklmnopqrstuvwxyz1234567890';
        let out = '';
        for(let i=0; i<length; ++i) {
            out += pool.charAt(Math.floor(Math.random() * pool.length));
        }
        return out;
}

    class MultiPlayer extends HTMLElement {
        static get observedAttributes() {
            return ['play', 'play-local', 'list', 'list-local',
                    'nomunge', 'timelink'];
        }

        attributeChangedCallback(name, oldValue, newValue) {
            switch(name) {
            case 'play':
                if(newValue === "" || newValue === null) {
                    return;
                }
                fetch(newValue)
                    .then((response) => response.json())
                    .then((data) => this.initPresentation(data));
                break;
            case 'list':
                if(newValue === "" || newValue === null) {
                    this.initPlaylist(null);
                }
                fetch(newValue)
                    .then((response) => response.json())
                    .then((data) => this.initPlaylist(data));
                break;
            case 'play-local':
                if(newValue === "" || newValue === null) {
                    return;
                }
                this.initPresentation(JSON.parse(newValue));
                break;
            case 'list-local':
                if(newValue === "" || newValue === null) {
                    this.initPlaylist(null);
                }
                this.initPlaylist(JSON.parse(newValue));
                break;
            case 'nomunge':
                if(newValue) {
                    this._mungeSources = false;
                } else {
                    this._mungeSources = true;
                }
                break;
            case 'timelink':
                this.toggleTimelink(newValue);
                break;
            }
        }

        constructor() {
            super();

            // Controls whether to prefix a random subdomain to each remote
            // source in order to work around the browser limit of ~6
            // connections per host. On by default.
            // Controlled by the 'nomunge' attribute on this element.
            this._mungeSources = true;

            // raw presentation json is stored here
            this._presentation = null;

            // all sources to be played back
            this._sources = [];

            // the controlling video element
            // other video elements will sync with this source
            this._controlSource = null;

            // the source that plays the audio
            this._audioSource = null;

            // the main playback source at any given time
            this._mainSource = null;

            // the element wrapping the playlist sidebar items
            this._playlist = null;

            // the playlist title element
            this._playlistTitle = null;

            // list of elements to show/hide based on playlist presence
            this._playlistUI = [];

            // list of stream overlay icons for play/pause
            this._overlayPlayIcons = [];

            // the container element for the progress bar
            this._progressContainer = null;

            // the element displaying buffer state
            this._progressBuffer = null;

            // the actual progress bar
            this._progressBar = null;

            // the popup displaying time information when hovering on
            // the progress bar
            this._progressPopup = null;

            // all subtitle selection buttons
            this._subtitleChoices = [];

            // all resolution selection buttons
            this._resolutionChoices = [];

            // the mute toggle
            this._volumeButton = null;

            // the volume slider
            this._volumeSlider = null;

            // the button to copy link to current time in the presentation
            this._timelinkButton = null;

            // the current UI language
            this._lang = 'en';
            const html = document.querySelector('html');
            if(html.lang) {
                this._lang = html.lang;
            }

            // localization strings
            this._i18n = {
                //all i18n keys are english already, no translations needed.
                'en': {},
                'sv': {
                    'Show playlist': 'Visa spellista',
                    'Hide playlist': 'Dölj spellista',
                    'Previous': 'Föregående',
                    'Next': 'Nästa',
                    'Play': 'Spela',
                    'Pause': 'Pausa',
                    'Speed selection': 'Välj hastighet',
                    'Resolution selection': 'Välj upplösning',
                    'Mute': 'Stäng av ljud',
                    'Unmute': 'Slå på ljud',
                    'Copy URL at current time':
                      'Kopiera länk till den här tidpunkten',
                    'Fullscreen': 'Helskärm',
                    'Leave fullscreen': 'Lämna helskärm',
                    'Subtitles are off': 'Undertexter är av',
                    'Subtitles are on': 'Undertexter är på',
                    'Off': 'Av'
                }
            };

            // prepare shadow root
            this.attachShadow({'mode': 'open'});
            this.shadowRoot.appendChild(style.content.cloneNode(true));
            this.shadowRoot.appendChild(icons.content.cloneNode(true));

            // initialize player skeleton
            this._root = createElement('div', {'id': 'player-root'});

            this._viewport = this._root.createChild('div', {'id': 'viewport'});
            const sidebar = this._root.createChild(
                'div', {'id': 'sidebar', 'class': 'hidden'});
            this.initSidebar(sidebar);
            this._playlistUI.push(sidebar);

            const controlRoot = this._root.createChild('div',
                                                       {'id': 'controls'});
            this._progressContainer = controlRoot.createChild(
                'div', {'id': 'progress-container'})
            this._progressBuffer = this._progressContainer.createChild(
                'canvas', {'id': 'buffer'});
            this._progressBar = this._progressContainer.createChild(
                'div', {'id': 'progress'});
            this._progressPopup = this._progressContainer.createChild(
                'div', {'id': 'progress-popup'});

            this.initLeftControls(controlRoot.createChild(
                'div', {'id': 'left-controls', 'class': 'control-box'}));
            this.initRightControls(controlRoot.createChild(
                'div', {'id': 'right-controls', 'class': 'control-box'}));

            this._spinner = this._root.createChild(
                'div', {'id': 'loading-overlay'},
                [createIcon(['loading'])]);

            // set up hiding of mouse pointer and controls
            const hide = () => {
                if(this._presTitle.classList.contains('hidden')) {
                    return;
                }
                if(!this._root.classList.contains('nocursor')) {
                    this._root.classList.add('nocursor');
                }
            }

            let timer = null;
            const reveal = () => {
                if(timer) {
                    window.clearTimeout(timer);
                }
                if(this._root.classList.contains('nocursor')) {
                    this._root.classList.remove('nocursor');
                }
                if(this._presTitle.classList.contains('hidden')) {
                    return;
                }
                const hover = this._root.querySelectorAll(
                    'button:hover, input:hover');
                if(hover.length > 0) {
                    return;
                }
                timer = window.setTimeout(hide, 2500);
            }

            this._root.addEventListener('mousemove', reveal);
            this._root.addEventListener('mouseleave', hide);
            this._root.addEventListener('keyup', (event) => {
                if(event.key === 'Tab') {
                    reveal();
                }
            });

            this.initKeyboard();

            // attach the shadow root
            this.shadowRoot.append(this._root);
        }

        /*
         *  Get the appropriate translation of key for the language
         *  stored in this._lang.
         */
        i18n(key) {
            // Since the keys are in english, the key is simply returned if
            // this._lang is 'en'.
            if(this._lang == 'en') {
                return key;
            }

            // If we don't have a translation for the language, use english
            if(!(this._lang in this._i18n)) {
                return key;
            }

            return this._i18n[this._lang][key];
        }

        /*
         *  Prepare the sidebar for playlist info
         */
        initSidebar(parent) {
            const listButton = parent.createChild(
                'button',
                {'id': 'playlist-button',
                 'title': this.i18n('Show playlist'),
                 'data-title_alt': this.i18n('Hide playlist')},
                [createIcon(['playlist', 'close'])]);
            this._presTitle = parent.createChild('h1', {'id': 'title'});

            this._playlistTitle = parent.createChild(
                'h1', {'id': 'playlist-title', 'class': 'playlist hidden'});
            this._playlist = parent.createChild(
                'ul', {'id': 'playlist', 'class': 'playlist hidden'});

            listButton.addEventListener('click', (event) => {
                const elems = [this._playlist,
                               this._presTitle,
                               this._playlistTitle];
                elems.forEach((elem) => elem.classList.toggle('hidden'));
                parent.classList.toggle('open');
                this.toggleButtonState(listButton);
            });

            return parent;
        }

        /*
         *  Prepare controls anchored to the left part of the viewport
         */
        initLeftControls(parent) {
            const switchPresentation = (event) => {
                const current = this._playlist.querySelector('.current');
                let other = null;
                if(event.currentTarget.id === 'previous') {
                    other = current.previousElementSibling;
                } else {
                    other = current.nextElementSibling;
                }

                // this will require refactoring for local playback
                this.setAttribute('play', other.querySelector('a').href);
            }

            const prevButton = parent.createChild(
                'button', {'id': 'previous',
                           'class': 'playlist hidden',
                           'title': this.i18n('Previous')},
                [createIcon(['previous'])]);
            prevButton.addEventListener('click', switchPresentation);
            this._playlistUI.push(prevButton);

            this._playButton = parent.createChild(
                'button', {'id': 'play-button',
                           'title': this.i18n('Play'),
                           'data-title_alt': this.i18n('Pause')},
                [createIcon(['play', 'pause'])]);
            this._playButton.addEventListener('click', (event) => {
                // since the main stream may overlap the play button
                event.stopPropagation();
                this.togglePlayback();
            });

            const nextButton = parent.createChild(
                'button', {'id': 'next',
                           'class': 'playlist hidden',
                           'title': this.i18n('Next')},
                [createIcon(['next'])]);
            nextButton.addEventListener('click', switchPresentation);
            this._playlistUI.push(nextButton);

            const speedSelect = parent.appendChild(
                createChoiceList('speed',
                                 this.i18n('Speed selection'),
                                 ['2',
                                  '1.75',
                                  '1.5',
                                  '1.25',
                                  '1',
                                  '0.75'],
                                 4));
            const currentSpeed = speedSelect.querySelector('#speed-current');
            const speedButtons = speedSelect.querySelectorAll(
                '#speed-list button');
            speedButtons.forEach((button) => {
                button.addEventListener('click', (event) => {
                    const speed = event.currentTarget.textContent;
                    if(speed === currentSpeed.textContent) {
                        return;
                    }
                    currentSpeed.textContent = speed;
                    this._sources.forEach((source) => {
                        source.playbackRate = speed;
                    });
                });
            });
            this._volumeButton = parent.createChild(
                'button',
                {'id': 'volume-button',
                 'title': this.i18n('Mute'),
                 'data-title_alt': this.i18n('Unmute')},
                [createIcon(['volume', 'mute'])]);

            this._volumeSlider = parent.createChild('input',
                                                    {'id': 'volume',
                                                     'type': 'range',
                                                     'min': '0',
                                                     'max': '1',
                                                     'step': '0.01'});
            this._volumeSlider.value = 1;

            this._volumeButton.addEventListener('click', (event) => {
                const audio = this._audioSource;
                if(!audio.muted) {
                    this._volumeSlider.value = 0;
                    audio.muted = true;
                    localStorage.setItem('multi-player-muted', true);
                } else {
                    this._volumeSlider.value = audio.volume;
                    audio.muted = false;
                    localStorage.removeItem('multi-player-muted');
                }
                this.toggleButtonState(this._volumeButton);
            });
            this._volumeSlider.addEventListener('input', (event) => {
                const volume = this._volumeSlider.valueAsNumber;
                this._audioSource.volume = volume;
                if(this._audioSource.muted === true) {
                    this._volumeButton.click();
                }
                localStorage.setItem('multi-player-volume', volume);
            });

            this._elapsed = parent.createChild('span', {'id': 'elapsed'});
            parent.createChild('span', {'id': 'of'}, ['/']);
            this._duration = parent.createChild('span', {'id': 'duration'});
        }

        /*
         *  Prepare controls anchored to the right part of the viewport
         */
        initRightControls(parent) {
            this._timelinkButton = parent.createChild(
                'button',
                {'id': 'timelink-button',
                 'title': this.i18n('Copy URL at current time')},
                [createIcon(['timelink'])]);

            this._timelinkButton.addEventListener('click', (event) => {
                const params = parseGETParameters(this._presentation.id);
                if(!params[this._presentation.id]) {
                    params[this._presentation.id] = {};
                }
                const localargs = params[this._presentation.id];

                // Add time argument
                const time = this._mainSource.currentTime;
                localargs['t'] = time.toFixed(1);

                // Save to clipboard
                const url = window.location.href.split('?', 1)
                      + params.toString()
                navigator.clipboard.writeText(url);
            });

            // setSubtitles() requires this._subtitlesSelect to
            // be in the correct position in the DOM already,
            // so creating a dummy
            this._subtitlesSelect = parent.createChild('button',
                                                       {'class': 'hidden'},
                                                       ['placeholder']);

            // setResolutions() requires this._resolutionSelect to
            // be in the correct position in the DOM already,
            // so creating a dummy
            this._resolutionSelect = parent.createChild('button',
                                                        {},
                                                        ['placeholder']);

            const fullscreenButton = parent.createChild(
                'button',
                {'id': 'fullscreen-button',
                 'title': this.i18n('Fullscreen'),
                 'data-title_alt': this.i18n('Leave fullscreen')},
                [createIcon(['fullscreen-enter',
                             'fullscreen-exit'])]);
            fullscreenButton.addEventListener('click', (event) => {
                if(document.fullscreenElement) {
                    document.exitFullscreen()
                } else {
                    this._root.requestFullscreen();
                }
                this.toggleButtonState(fullscreenButton);
            });
        }

        /*
         *  Finalize setup for playback based on presentation data.
         */
        initPresentation(presentation) {
            const parent = this._viewport;

            //clear out any existing streams
            while(parent.hasChildNodes()) {
                parent.removeChild(parent.firstChild());
            }
            this._sources = [];
            this._overlayPlayIcons = [];

            // initialize UI elements
            this._presentation = presentation;
            this._presTitle.textContent = presentation.title;
            this._elapsed.textContent = this.formatTime(0);
            this._duration.textContent = this.formatTime(
                presentation.duration);
            const streams = presentation.sources;
            const sourcenames = Object.keys(streams);
            // sorting the source names so they get a predictable ordering
            sourcenames.sort();
            const resolutions = Object.keys(streams[sourcenames[0]].video);
            const defaultRes = 0;
            const token = presentation.token;
            this.setResolutions(resolutions, defaultRes);

            // create streams
            for(var i = 0; i < sourcenames.length; ++i) {
                const key = sourcenames[i];
                const stream = streams[key];
                // skip setting up the stream if it is explicitly
                // configured to be hidden.
                if(stream['enabled'] === false) {
                    continue;
                }
                const streamRoot = parent.createChild('div',
                                                      {'class': 'stream'});
                const video = streamRoot.createChild(
                    'video',
                    {'playsinline': 1,
                     'preload': 'auto',
                     'crossorigin': 'anonymous'});

                // append token to each resolution and save it in the
                // video element's dataset
                Object.entries(stream.video).forEach(([resolution, src]) => {
                    let tokenized = `${src}?token=${token}`;
                    if(this._mungeSources) {
                        // In order to work around the browser's limit of ~6
                        // simultaneous connections per server, prepend a
                        // random subdomain to the source if it is remote.
                        const prefix = randString(6);
                        tokenized = tokenized.replace(/^(https?:\/\/)(.*)/,
                                                      `$1${prefix}.$2`);
                    }
                    video.dataset[resolution] = tokenized;
                });

                // pick the default resolution from the dataset and use it
                // as initial src
                video.src = video.dataset[resolutions[defaultRes]];

                // subs, if present
                if(presentation.subtitles) {
                    for(const key in presentation.subtitles) {
                        const file = presentation.subtitles[key];
                        video.createChild(
                            'track',
                            {'kind': 'subtitles',
                             'label': key,
                             'src': `${file}?token=${token}`});
                    }
                }

                //misc details
                video.muted = !stream.playAudio;
                video.poster = stream.poster;
                video.load();
                this._sources.push(video);

                // set up overlay icons
                const switchIcon = streamRoot.appendChild(
                    createIcon(['switch'], {'class': 'switch fade'}));
                const playIcon = streamRoot.appendChild(
                    createIcon(['play', 'pause'], {'class': 'play fade'}));
                if(stream.playAudio) {
                    streamRoot.classList.add('main');
                    switchIcon.classList.add('hidden');

                    // kepp a reference to the control source around
                    this._controlSource = video;
                    // keep a reference to the main source around
                    this._mainSource = video;
                    // keep a reference to the source that plays audio
                    this._audioSource = video;
                } else {
                    playIcon.classList.add('hidden');
                }

                // set up stream listeners
                streamRoot.addEventListener('click', (event) => {
                    if(event.currentTarget.classList.contains('main')) {
                        // this is the main source, toggle playback
                        this.togglePlayback();
                    } else {
                        // this is a secondary source, switch it to main
                        this.switchMainSource(
                            event.currentTarget.querySelector('video'));
                    }
                });
            }

            if(presentation.subtitles) {
                this.setSubtitles(Object.keys(presentation.subtitles));
            } else {
                this._subtitlesSelect.classList.add('hidden');
            }

            this.setActivePlaylistItem();
            this.autoBlurControls();
            this.initProgressContainer();
            this.initBuffer();
            this.initSpinner();

            this.recallSettings();
        }

        /*
         *  Populate playlist UI based on playlist data.
         */
        initPlaylist(list) {
            const playlist = this._playlist;

            // clean up first
            this._playlistTitle.textContent = '';
            while(playlist.hasChildNodes()) {
                playlist.removeChild(playlist.lastChild);
            }
            this.showPlaylistUI(false);

            // is there even a playlist?
            if(list === null) {
                return;
            }

            // set up
            this._playlistTitle.textContent = list.title;

            for(let i=0; i<list.items.length; ++i) {
                const item = list.items[i];
                const link = playlist.createChild(
                    'li', {'class': 'playlist-item', 'data-id': item.id})
                      .createChild('a', {'href': item.link});
                link.createChild('img', {'src': item.thumb});
                link.createChild('span', {'class': 'title'}, [item.title]);
                link.createChild('span',
                                 {'class': 'desc'},
                                 [item.description]);
            }
            this.showPlaylistUI(true);
            this.setActivePlaylistItem();
            this.autoBlurControls();
        }

        /*
         *  Set up progress container with progress tracking, seeking etc.
         */
        initProgressContainer() {
            // Initialize hover timestamp popup
            const popup = this._progressContainer.querySelector(
                '#progress-popup');
            this._progressContainer.addEventListener('mousemove', (event) => {
                const bounds =
                      this._progressContainer.getBoundingClientRect();
                const xRel = event.clientX - bounds.x;
                const fraction = xRel / this._progressContainer.clientWidth;
                const time = fraction * this._controlSource.duration;
                popup.textContent = this.formatTime(time);

                const margin = popup.clientWidth / 2;
                const xmax = this._progressContainer.clientWidth - margin;
                let pos = xRel;
                if(pos < margin) {
                    pos = margin;
                } else if(pos > xmax) {
                    pos = xmax;
                }
                popup.style.left = pos + 'px';
            });

            // Enable seeking
            this._progressContainer.addEventListener('click', (event) => {
                const bounds =
                      this._progressContainer.getBoundingClientRect();
                const xRel = event.clientX - bounds.x;
                const fraction = xRel / this._progressContainer.clientWidth;
                const time = fraction * this._controlSource.duration;
                this.setTime(time);
            });

            // Initialize progressbar
            this._controlSource.addEventListener('timeupdate', (event) => {
                const elapsed = this._controlSource.currentTime;
                this._elapsed.textContent = this.formatTime(elapsed);
                const progressWidth = (
                    elapsed
                        / this._controlSource.duration
                        * this._progressContainer.clientWidth);
                this._progressBar.style.width = progressWidth + 'px';
            });
        }

        /*
         *  Initialize display of buffered segments in the progress bar.
         */
        initBuffer() {
            const color = window.getComputedStyle(this._root)
                  .getPropertyValue('--foreground');
            const buffer = this._progressBuffer;
            const control = this._controlSource;
            let needsUpdate = false;

            function paintBuffer() {
                if(needsUpdate) {
                    buffer.width = buffer.clientWidth;
                    buffer.height = buffer.clientHeight;

                    const context = buffer.getContext('2d');
                    context.clearRect(0, 0, buffer.width, buffer.height);
                    context.fillStyle = color;
                    context.strokeStyle = color;

                    const inc = buffer.width / control.duration;
                    const buffered = control.buffered;
                    for(let i = 0; i < buffered.length; ++i) {
                        const start = buffered.start(i) * inc;
                        const end = buffered.end(i) * inc;
                        const width = end - start;
                        context.fillRect(start, 0, width, buffer.height);
                    }
                    needsUpdate = false;
                }
                requestAnimationFrame(paintBuffer);
            }

            function flagUpdate(event) {
                needsUpdate = true;
            }

            control.addEventListener('progress', flagUpdate);
            window.addEventListener('resize', flagUpdate);
            window.requestAnimationFrame(paintBuffer);
        }

        /*
         *  Initialize dynamic showing of spinner based on buffering state
         */
        initSpinner() {
            let buffering = new Set();
            let tryHiding = () => {
                // hide the spinner when all streams are done buffering
                if(buffering.size === 0) {
                    this._spinner.classList.add('hidden');
                    // modifying z-index so controls are still usable when
                    // buffering mid-playback
                    this._spinner.style.zIndex = 1;
                }
            }
            this._sources.forEach((source) => {
                // show the spinner when playback is stalled
                source.addEventListener('waiting', (event) => {
                    buffering.add(source);
                    this._spinner.classList.remove('hidden');
                });
                source.addEventListener('canplay', (event) => {
                    buffering.delete(source);
                    tryHiding();
                });
            });
        }

        /*
         *  Set up keyboard bindings.
         */
        initKeyboard() {
            this._root.addEventListener('keydown', (event) => {
                switch(event.key) {
                case " ":
                    this.togglePlayback();
                    break;
                case "ArrowRight":
                    if(event.target === this._volumeSlider) {
                        break;
                    }
                    let ahead = this._controlSource.currentTime + 5;
                    if(ahead > this._controlSource.duration) {
                        ahead = this._controlSource.duration;
                    }
                    this.setTime(ahead);
                    break;
                case "ArrowLeft":
                    if(event.target === this._volumeSlider) {
                        break;
                    }
                    let back = this._controlSource.currentTime - 5;
                    if(back < 0) {
                        back = 0;
                    }
                    this.setTime(back);
                    break;
                }
            });
        }

        /*
         *  Apply any saved settings from previous usage
         */
        recallSettings() {
            // Set subtitles state
            const savedState = localStorage.getItem(
                'multi-player-subs-state');
            if(savedState === 'showing') {
                const savedTrack = localStorage.getItem(
                    'multi-player-subs-track');
                let found = false;
                this._subtitleChoices.forEach((button) => {
                    if(savedTrack === button.textContent) {
                        button.click();
                        found = true;
                    }
                });
                if(!found && this._subtitleChoices.length != 0) {
                    this._subtitleChoices[0].click();
                }
            }

            // Apply saved volume
            const savedLevel = localStorage.getItem('multi-player-volume');
            if(savedLevel !== null) {
                this._volumeSlider.value = savedLevel;
                this._audioSource.volume = savedLevel;
            }

            // Apply saved mute state
            const muted = localStorage.getItem('multi-player-muted');
            if(muted) {
                this._volumeButton.click();
            }

            // Apply saved resolution choice
            const savedResolution = localStorage.getItem(
                'multi-player-resolution');
            if(savedResolution) {
                this._resolutionChoices.forEach((button) => {
                    if(button.textContent === savedResolution) {
                        button.click();
                    }
                });
            }

            // Apply start time if applicable
            const args = parseGETParameters(this._presentation.id);
            if(args[this._presentation.id]) {
                const localargs = args[this._presentation.id];
                if(localargs['t']) {
                    this._controlSource.currentTime = localargs['t'];
                }
            }
        }

        /*
         *  Update the playlist to reflect which item is playing
         *
         *  Playlist data and the active item are pulled from this._playlist
         *  and this._presentation respectively.
         */
        setActivePlaylistItem() {
            if(this._presentation === null) {
                return;
            }
            this._playlist.childNodes.forEach((item) => {
                if(item.dataset.id === this._presentation.id
                   && !item.classList.contains('current')) {
                    item.classList.add('current');
                }
                if(item.classList.contains('current')
                   && item.dataset.id !== this._presentation.id) {
                    item.classList.remove('current');
                }
            });
        }

        /*
         *  Show/hide playlist UI
         *
         *  The desired state is given by the boolean arg 'visible'.
         */
        showPlaylistUI(visible) {
            this._playlistUI.forEach((element) => {
                if(visible && element.classList.contains('hidden')) {
                    element.classList.remove('hidden');
                } else if(!visible && !element.classList.contains('hidden')) {
                    element.classList.add('hidden');
                }
            });
        }

        /*
         *  Populate the list of resolution choices.
         *
         *  The available resolutions are passed in the 'resolutions' arg,
         *  and a default may optionally be specified.
         */
        setResolutions(resolutions, defaultIndex=0) {
            const select = createChoiceList(
                'resolution',
                this.i18n('Resolution selection'),
                resolutions.reverse(),
                resolutions.length - defaultIndex - 1);
            const current = select.querySelector('#resolution-current');
            this._resolutionChoices = select.querySelectorAll(
                '#resolution-list button');
            this._resolutionChoices.forEach((button) => {
                button.addEventListener('click', (event) => {
                    const res = event.currentTarget.textContent;
                    const time = this._mainSource.currentTime;
                    const paused = this._mainSource.paused;
                    if(res === current.textContent) {
                        return;
                    }
                    // temporarily pause playback for the switch
                    if(!paused) {
                        this.togglePlayback();
                    }
                    current.textContent = res;
                    this._sources.forEach((source) => {
                        source.src = source.dataset[res];
                        source.currentTime = time;
                    });
                    // unpause again if we paused before
                    if(!paused) {
                        this.togglePlayback();
                    }
                    localStorage.setItem('multi-player-resolution', res);
                });
            });

            this._resolutionSelect.replaceWith(select);
            this._resolutionSelect = select;
            return select;
        }

        /*
         *  Populate the list of subtitle choices.
         *
         *  The available subtitles are passed in the 'subtitles' arg.
         *
         *  If there is only one subtitle track, the menu is eliminated
         *  and it becomes a button toggle instead.
         */
        setSubtitles(subtitles) {
            let select = null;
            if(subtitles.length === 1) {
                select = createElement(
                    'button',
                    {'id': 'subtitles-select',
                     'title': this.i18n('Subtitles are off'),
                     'data-title_alt': this.i18n('Subtitles are on')},
                    [createIcon(['subtitles-off',
                                 'subtitles-on'])]);
                select.addEventListener('click', (event) => {
                    const track = this._mainSource.textTracks[0];
                    if(track.mode === 'disabled') {
                        track.mode = 'showing';
                    } else {
                        track.mode = 'disabled';
                    }
                    localStorage.setItem('multi-player-subs-state',
                                         track.mode);
                    this.toggleButtonState(select);
                });

                const savedState = localStorage.getItem(
                    'multi-player-subs-state');
                if(savedState === 'showing') {
                    select.click();
                }
            } else {
                select = createElement('div', {'id': 'subtitles-select',
                                               'class': 'select'});
                const current = select.createChild(
                    'button',
                    {'id': 'subtitles-current',
                     'title': this.i18n('Subtitles are off'),
                     'data-title-off': this.i18n('Subtitles are off'),
                     'data-subtitles-state': 'off'},
                    [createIcon(['subtitles-off',
                                 'subtitles-on'])]);
                const onIcon = current.querySelector(
                    'svg use[href="#subtitles-on-icon"]');
                const offIcon = current.querySelector(
                    'svg use[href="#subtitles-off-icon"]');
                const list = select.createChild('ul', {'id': 'subtitles-list',
                                                       'class': 'list'});
                for(let i=0; i<subtitles.length; ++i) {
                    list.createChild('li')
                        .createChild('button',
                                     {'data-choice': subtitles[i]},
                                     [subtitles[i]]);
                }
                list.createChild('li').createChild(
                    'button',
                    {'data-choice': 'off'},
                    [this.i18n('Off')]);

                this._subtitleChoices = list.querySelectorAll('button');
                this._subtitleChoices.forEach((button) => {
                    button.addEventListener('click', (event) => {
                        const choice = event.currentTarget.dataset.choice;
                        if(choice === current.dataset.subtitlesState) {
                            return;
                        }
                        current.dataset.subtitlesState = choice;
                        const length = this._mainSource.textTracks.length;
                        for(let i=0; i<length; ++i) {
                            const track = this._mainSource.textTracks[i];
                            if(choice !== 'off' && track.label === choice) {
                                track.mode = 'showing';
                            } else {
                                track.mode = 'disabled';
                            }
                        }
                        if(choice === 'off') {
                            current.title = current.dataset.titleOff;
                            onIcon.classList.add('hidden');
                            offIcon.classList.remove('hidden');
                            localStorage.setItem('multi-player-subs-state',
                                                 'disabled');
                            localStorage.removeItem('multi-player-subs-track');
                        } else {
                            current.title = choice;
                            offIcon.classList.add('hidden');
                            onIcon.classList.remove('hidden');
                            localStorage.setItem('multi-player-subs-state',
                                                 'showing');
                            localStorage.setItem('multi-player-subs-track',
                                                 choice);
                        }
                    });
                });
            }
            this._subtitlesSelect.replaceWith(select);
            this._subtitlesSelect = select;
            return select;
        }

        /*
         *  Set the visibility of the time link button.
         */
        toggleTimelink(visible) {
            if(visible) {
                this._timelinkButton.classList.remove('hidden');
            } else {
                this._timelinkButton.classList.add('hidden');
            }
        }

        /*
         *  Return a consistently formatted time string.
         *
         *  The arg 'time' should be a number of seconds.
         */
        formatTime(time) {
            const hours = (Math.floor(time / 3600) + '').padStart(2, '0');
            const minutes = (Math.floor((time % 3600) / 60)
                             + '').padStart(2, '0');
            const seconds = (Math.round(time % 60) + '').padStart(2, '0');
            if(this._presentation.duration > 3600) {
                return hours +':'+ minutes +':'+ seconds;
            } else {
                return minutes +':'+ seconds;
            }
        }

        /*
         *  Jump in the presentation.
         *
         *  The arg 'time' gives the time to jump to as a number of seconds
         *  since start.
         */
        setTime(time) {
            this._sources.forEach((source) => {
                source.currentTime = time;
            });
        }

        /*
         *  Switch icon and text on a button to its alternative text/icon.
         *
         *  'button' is the button to be acted upon.
         */
        toggleButtonState(button) {
            const alt = button.dataset['title_alt'];
            button.dataset['title_alt'] = button.title;
            button.title = alt;
            const icon = button.querySelector('svg');
            if(icon) {
                this.toggleIconState(icon);
            }
        }

        /*
         *  Switch the glyph dispayed on an icon to its alternative.
         *
         *  'icon' is the icon to be acted upon. Does nothing if there is
         *  no alternate glyph.
         */
        toggleIconState(icon) {
            const glyphs = icon.querySelectorAll('use');
            if(glyphs.length === 0) {
                return;
            }
            glyphs.forEach((glyph) => {
                glyph.classList.toggle('hidden');
            });
        }

        /*
         *  Set selection popups to lose focus immediately on click.
         */
        autoBlurControls() {
            const blurrables = this.shadowRoot.querySelectorAll(
                '.select button');
            blurrables.forEach((candidate) => {
                if(candidate.autoblur === undefined) {
                    candidate.addEventListener('click', (event) => {
                        event.currentTarget.blur();
                    });
                    candidate.autoblur = true;
                }
            });
        }

        /*
         *  Start or stop playback.
         *
         *  Toggles Playback button states and synchronizes sources.
         */
        togglePlayback() {
            this.toggleButtonState(this._playButton);
            const paused = this._controlSource.paused;
            this._sources.forEach((source) => {
                if(paused) {
                    source.play();
                } else {
                    source.pause();
                }
                this.toggleIconState(
                    source.parentNode.querySelector('.play'));
            });
            this.syncSources();
        }

        /*
         *  Synchronize all secondary sources to the current main source.
         */
        syncSources() {
            this._sources.forEach((source) => {
                if(source === this._controlSource) {
                    return;
                }
                source.currentTime = this._controlSource.currentTime;
            });
        }

        /*
         *  Switch the main playback source to the one passed in newMain.
         */
        switchMainSource(newMain) {
            function switchIcons(elem) {
                elem.querySelectorAll('svg').forEach((icon) => {
                    icon.classList.toggle('hidden');
                });
            }
            const oldMainParent = this._mainSource.parentNode;
            oldMainParent.classList.remove('main');
            switchIcons(oldMainParent);

            const newMainParent = newMain.parentNode;
            newMainParent.classList.add('main');
            switchIcons(newMainParent);

            let oldTrackLabel = null;
            for(let i=0; i<this._mainSource.textTracks.length; ++i) {
                const track = this._mainSource.textTracks[i];
                if(track.mode === "showing") {
                    track.mode = "disabled";
                    oldTrackLabel = track.label;
                    break;
                }
            }
            if(oldTrackLabel !== null) {
                for(let i=0; i<newMain.textTracks.length; ++i) {
                    const track = newMain.textTracks[i];
                    if(track.label === oldTrackLabel) {
                        track.mode = "showing";
                        break;
                    }
                }
            }
            this._mainSource = newMain;
            this.syncSources();
        }
    }

    customElements.define('multi-player', MultiPlayer);
})();
