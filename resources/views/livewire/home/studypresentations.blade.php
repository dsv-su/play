<div>
    @if(count($studyvideos) > 0)
        @include('home.partials.carousel', [
            'videos' => $studyvideos,
            'heading' => __('Study information'),
            'libraryUrl' => route('study.presentations'),
        ])
    @endif
</div>
