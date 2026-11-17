<div>
    @if(count($nextilearnvideos) > 0)
        <div wire:ignore>
            @include('home.partials.carousel', [
                'videos' => $nextilearnvideos,
                'heading' => __('NextIlearn Tutorials'),
                'libraryUrl' => route('nextilearn.presentations'),
            ])
        </div>
    @endif
</div>
