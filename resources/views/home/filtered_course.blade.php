<h3 class="col mt-4">
    <a class="link collapsed " data-toggle="collapse"
       href="#collapse{{str_replace(' ', '', $key)}}" role="button" aria-expanded="false"
       aria-controls="collapse{{str_replace(' ', '', $key)}}"><i class="fa mr-2"></i>@if(isset($designation)) {{$designation}} @endif {{$key}}
        ({{count($coursevideos)}} st)
    </a>
</h3>

<div class="collapse" id="collapse{{str_replace(' ', '', $key)}}">
    <div class="d-flex flex-wrap">
        @foreach ($coursevideos as $video)
            <div class="col my-3">
                @include('home.video')
            </div>
        @endforeach
        <div class="col">
            <div class="card video my-0 mx-auto border-0"></div>
        </div>
        <div class="col">
            <div class="card video my-0 mx-auto border-0"></div>
        </div>
        <div class="col">
            <div class="card video my-0 mx-auto border-0"></div>
        </div>
    </div>
</div>
