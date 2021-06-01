@extends('layouts.suplay')
@section('content')
    @include('layouts.partials.searchbox')
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header">
                        @if($term ?? '' and $year ?? '')
                            <span class="fas fa-layer-group fa-icon-border mr-2" aria-hidden="true"></span>
                            {{ __("presentations from") }} {{$term}}{{$year}}
                        @elseif($designation ?? '')
                            <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                            @lang('lang.course'):
                            <i>{{\App\Course::where('designation', $designation)->latest()->first()->name}}</i>
                        @elseif($category ?? '')
                            <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                            @lang('lang.category'): <i>{{$category}}</i>
                        @endif
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-0">
        @if(count($videos) > 0)
            @foreach ($videos as $key => $videocourse)
                <h3 class="col mt-4">
                    <a class="link @if ($videos->first() !== $videocourse) collapsed @endif" data-toggle="collapse" href="#collapse{{$key}}" role="button" aria-expanded="false"
                       aria-controls="collapse{{$key}}"><i class="fa mr-2"></i>
                        @if($designation ?? '') {{$designation}} @elseif($category ?? '') {{$category}} @endif {{$key}}
                        ({{count($videocourse)}} st)
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
            @endforeach
        @else
            <h3 class="col mt-4">{{ __("No presentations") }}</h3>
        @endif
    </div><!-- /.container -->
@endsection
