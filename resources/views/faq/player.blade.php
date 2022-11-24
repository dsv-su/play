<h2 id="lang">{{__("The player")}}</h2>
<span class="su-theme-anchor mb-4"></span>
<article class="main-article webb2021-article main-column-left js-anchor-links-headers-container col-12 col-lg-8 main-column-padding-right">
    <p>{{__("The player will open automatically once you click on the presentation thumbnail. Up to four windows will be displayed, one big window and three smaller ones, displaying different streams for the same presentation (depending on the recording cameras in the recording room). Switch between the windows by clicking on the stream that you want to display in the big window.")}}</p>
    <br>
    @if(App::isLocale('en'))
        <img class="w-75" src="{{asset('images/manual/player.png')}}" alt="The player">
    @else
        <img class="w-75" src="{{asset('images/manual/player_swe.png')}}" alt="Spelaren">
    @endif
    <br><br><br>
    <p class="lead-light">{{__("Playlist menu")}}</p>
    <p>{{__("On the top left you will find a playlist menu. Click on it to see a list of related presentations. Click on the matching thumbnail to play one of the presentations from the list.")}}</p>
    <br>
    <img class="w-50" src="{{asset('images/manual/player2.png')}}" alt="Playlist icon">
    <br><br>
    <p>{{__("Click on the icon to expand the playlist")}}</p>
    <br>
    <img class="w-50" src="{{asset('images/manual/player3.png')}}" alt="Playlist">
    <br><br>
    <p class="lead-light">{{__("Player controls")}}</p>
    <p>{{__("Controls to play, fast forward, rewind, change playback speed, adjust volume, resolution and full screen mode can be found at the bottom of the screen.")}}</p>
    <p class="lead-light">{{__("Timecode button")}}</p>
    <p>{{__("The time code button can be used to copy a specific time in a playback to share with others. By clicking on the button, the time in the presentation is saved to the clipboard, which can then be shared. The shared presentation will be played from the chosen time point.")}}</p>
    <p class="lead-light">{{__("Resolution switcher")}}</p>
    <p>{{__("Button to change resolution. Normally, each recording is available in two resolutions, 720p and 1080p.")}}</p>
    <p class="lead-light">{{__("Fullscreen")}}</p>
    <p>{{__("Button to switch to Fullscreen mode.")}}</p>
</article>
