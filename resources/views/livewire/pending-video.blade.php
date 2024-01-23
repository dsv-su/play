<div wire:poll.visible class="row mx-1 mt-2">
    @foreach ($pending as $key => $video)
        <div class="col my-3">
            @include('home.pending_video')
        </div>
    @endforeach
    @include('home.partials.placeholder-videos', ['count' => 4])
</div>
