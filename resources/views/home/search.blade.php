@extends('layouts.suplay')
@section('content')

    @include('layouts.partials.searchbox')

    <!-- Header message section -->
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header mb-4">
                        <span class="far fa-clock fa-icon-border mr-2" aria-hidden="true"></span>
                        Search results
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-0">
        @if(count($videos) > 0)
            <h2 class="col mt-4"><a class="link collapsed" data-toggle="collapse" href="#collapseVideo"
                                    role="button" aria-expanded="false"
                                    aria-controls="collapseVideo"><i class="fa mr-2"></i>Presentations
                    ({{count($videos)}})</a>
            </h2>
            <div class="collapse" id="collapseVideo">
                <div class="d-flex flex-wrap">
                    @foreach ($videos as $key => $video)
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
        @endif
        @if(count($courses) > 0)
            <h2 class="col my-4"><a class="link collapsed" data-toggle="collapse" href="#collapseCourse"
                                    role="button" aria-expanded="false"
                                    aria-controls="collapseCourse"><i class="fa mr-2"></i>Courses ({{count($courses)}})</a>
            </h2>
            <div class="collapse" id="collapseCourse">
                @foreach ($courses as $key => $course)
                    <h3 class="col">
                        <a class="link" href="/designation/{{$course->designation}}" role="button">
                            {{$course->name}} ({{$course->designation}})
                        </a>
                    </h3>
                @endforeach
            </div>
        @endif
        @if(count($tags) > 0)
            <h2 class="col my-4"><a class="link collapsed" data-toggle="collapse" href="#collapseTag"
                                    role="button" aria-expanded="false"
                                    aria-controls="collapseTag"><i class="fa mr-2"></i>Tags ({{count($tags)}})</a></h2>
            <div class="collapse" id="collapseTag">
                @foreach ($tags as $key => $tag)
                    <h3 class="col">
                        <a class="link" href="/tag/{{$tag->name}}" role="button">
                            {{$tag->name}}
                        </a>
                    </h3>
                @endforeach
            </div>
        @endif
        @if(count($presenters) > 0)
            <h2 class="col my-4"><a class="link collapsed" data-toggle="collapse" href="#collapsePresenter"
                                    role="button" aria-expanded="false"
                                    aria-controls="collapsePresenter"><i class="fa mr-2"></i>Presenters
                    ({{count($presenters)}})</a></h2>
            <div class="collapse" id="collapsePresenter">
                @foreach ($presenters as $key => $presenter)
                    <h3 class="col">
                        <a class="link" href="/presenter/{{$presenter->username}}" role="button">
                            {{$presenter->name}} ({{$presenter->username}})
                        </a>
                    </h3>
                @endforeach
            </div>
        @endif
    </div><!-- /.container -->

@endsection