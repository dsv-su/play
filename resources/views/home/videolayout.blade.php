<div wire:ignore.self class="row mx-3">
    @switch($videoformat)
        @case('grid')
            @foreach ($videos as $key => $video)
                <div class="col my-3">
                    @include('home.video')
                    @include('layouts.partials.videomodals')
                </div>
            @endforeach
            <div class="col">
                <div class="card video my-0 mx-auto"></div>
            </div>
            <div class="col">
                <div class="card video my-0 mx-auto"></div>
            </div>
            <div class="col">
                <div class="card video my-0 mx-auto"></div>
            </div>
            @break
        @case('list')
            @foreach ($videos as $key => $video)
                @include('home.video_list')
                @include('layouts.partials.videomodals')
            @endforeach
            @break
        @case('table')
            @foreach ($videos as $key => $video)
                @include('home.video_table')
                @include('layouts.partials.videomodals')
            @endforeach
        @break
    @endswitch
</div>

