<div class="row mx-1">
    @switch(Cookie::get('videoformat') ?? 'grid')
        @case('grid')
            @foreach ($videos as $key => $video)
                <div class="col my-3">
                    @include('home.video')
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
            @endforeach
            @break
        @case('table')
            @break
    @endswitch
</div>