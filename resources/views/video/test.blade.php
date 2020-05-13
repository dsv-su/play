@extends('layouts.master')
@section('content')
    <h2>Play ladda upp</h2>
    @if($upload == 0)
    <h3> Ladda upp video eller textfil med länkar:</h3>
    <div class="searchrequest">
    <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input name="file" id="poster" type="file" class="form-control">
            <br>
            <button type="submit" name="submit" value="upload">Ladda upp</button>
        </div>
    </form>
    </div>
    @endif

    @if($upload == 1)
    @foreach($url as $stream)
    <div class="row">
        <video id="video1" class="video-js vjs-default-skin" controls autoplay preload="auto" width="auto" height="300" data-setup="{}">
            <source src="{{asset($stream)}}" type='video/mp4' />
            <track kind="captions" src="captions.vtt" srclang="en" label="English" />
            <p class="vjs-no-js">
                To view this video please enable JavaScript, and consider upgrading to a
                web browser that
                <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
            </p>
        </video>

    </div>
    @endforeach
    @endif
<!--
    <div class="row">

        <video id="video3" class="video-js vjs-default-skin vjs-big-play-centered" preload width="480" height="300" poster="" data-setup='{"fluid": false, "playbackRates": [0.5, 1, 2], "html5": {"nativeTextTracks": false}}'>
            <source src="//vjs.zencdn.net/v/oceans.mp4" type="video/mp4">
            <track kind="captions" src="captions.vtt" srclang="en" label="English" />
        </video>

        <video id="video4" class="video-js vjs-default-skin vjs-big-play-centered" preload width="480" height="300" poster="" data-setup='{"fluid": false, "playbackRates": [0.5, 1, 2], "html5": {"nativeTextTracks": false}}'>
            <source src="//vjs.zencdn.net/v/oceans.mp4" type="video/mp4">
            <track kind="captions" src="captions.vtt" srclang="en" label="English" />
        </video>

    </div>
-->


<script>
    var medias = Array.prototype.slice.apply(document.querySelectorAll('audio,video'));
    medias.forEach(function(media) {
        media.addEventListener('play', function(event) {
            medias.forEach(function(media) {
                if(event.target != media) media.play();
            });
        });
        media.addEventListener('pause', function(event) {
            medias.forEach(function(media) {
                if(event.target != media) media.pause();
            });
        });
    });

</script>
@endsection
