<div wire:poll.visible class="row mx-1 mt-2">
    @foreach ($pending as $key => $video)
        <div class="col my-3">
            @include('home.pending_video')
        </div>
    @endforeach
        <div class="col my-3">
            <div class="card video my-0 mx-auto"></div>
        </div>
        <div class="col my-3">
            <div class="card video my-0 mx-auto"></div>
        </div>
        <div class="col my-3">
            <div class="card video my-0 mx-auto"></div>
        </div>
        <div class="col my-3">
            <div class="card video my-0 mx-auto"></div>
        </div>
</div>
