@extends('layouts.suplay')
@section('content')

    <div class="container align-self-center">
        <form class="form-inline form-main-search d-flex justify-content-between"
              id="header-main-search-form" name="header-main-search-form"
              action="{{ route('search') }}" method="POST" data-search="/s%C3%B6k"
              role="search">
            @csrf
            <label for="header-main-search-text" class="sr-only">Sök på videos</label>
            <input class="form-control w-100 mx-auto" type="search"
                   id="header-main-search-text" name="q" autocomplete="off"
                   aria-haspopup="true"
                   placeholder="Sök på videos"
                   aria-labelledby="header-main-search-form">
        </form>
    </div>

    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <h1 class="word-wrap_xs-only">Latest videos</h1>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-0">

        <div class="d-flex mb-3 flex-wrap">
            @foreach ($latest as $video)
                <div class="col my-3">
                    <div class="card video m-auto">
                        <a href="{{ route('player', ['video' => $video]) }}">
                            <div class="card-header position-relative"
                                 style=" @if ($video->sources && json_decode($video->sources)[0]->poster) background-image: url({{ asset(json_decode($video->sources)[0]->poster)}}); @endif height:200px;">
                                <div class="title">{{ $video->title }}</div>
                                <p class="p-1"> {{$video->duration}} </p>
                            </div>
                        </a>
                        <div class="card-body p-1">
                            <p class="card-text">
                                @foreach($video->video_course as $vc) <a
                                        href="/course/{{$vc->course_id}}"
                                        class="badge badge-primary">{{\App\Course::find($vc->course_id)->designation}}</a> @endforeach
                            </p>
                            <p class="card-text">
                                <span class="badge badge-light">{{$video->category->category_name}}</span>
                            </p>
                            <p class="card-text">
                                @foreach($video->presenters() as $presenter) <span
                                        class="badge badge-light">{{$presenter->name}}</span> @endforeach</p>
                            <p class="card-text" id="tags">@foreach($video->tags() as $tag) <span
                                        class="badge badge-secondary">{{$tag->name}}</span> @endforeach</p>
                            <p class="card-text">
                        </div>
                    </div>
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

    </div><!-- /.container -->

@endsection