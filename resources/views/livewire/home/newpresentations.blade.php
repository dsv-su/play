<div>
    @if(count($newvideos) > 0)
        @include('home.partials.carousel', [
            'videos' => $newvideos,
            'heading' => __('New on play'),
            'libraryUrl' => null,
        ])
    @endif
</div>
