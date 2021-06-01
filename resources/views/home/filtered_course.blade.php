<h3 class="col mt-4">
    <a class="link @if ($videos->first() !== $videocourse) collapsed @endif" data-toggle="collapse"
       href="#collapse{{$key}}" role="button" aria-expanded="false"
       aria-controls="collapse{{$key}}"><i class="fa mr-2"></i>@if($designation ?? '') {{$designation}} @endif {{$key}} ({{count($videocourse)}} st)
    </a>
</h3>

<div class="collapse @if ($videos->first() == $videocourse) show @endif" id="collapse{{$key}}">
    <div class="d-flex flex-wrap">
        @foreach ($videocourse as $video)
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
