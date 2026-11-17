<div>
    @if(count($myvideos) > 0)
        @include('home.partials.carousel', [
            'videos' => $myvideos,
            'heading' => __('My courses'),
            'libraryUrl' => route('my.presentations'),
        ])
    @endif
</div>
