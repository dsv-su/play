@extends('layouts.suplay')
@section('content')
    @if(session()->has('message'))
        <div class="alert {{session('alert') ?? 'alert-info'}}">
            {{ session('message') }}
        </div>
    @endif
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
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header mb-4">
                        <span class="far fa-clock fa-icon-border mr-2" aria-hidden="true"></span>
                        Senast tillagt @if (isset($course))
                            från <i>{{$course}}</i>  @elseif (isset($tag)) efter taggen: <i>{{$tag}}</i> @elseif (isset($presenter))  <i>{{$presenter}}</i>> @endif
                    </h3>

                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-0">

        <div class="d-flex mb-3 flex-wrap">
            @foreach ($latest as $video)
                <div class="col my-3">
                    <div class="card video m-auto" >
                        <a href="{{ route('player', ['video' => $video]) }}">
                            <div class="card-header position-relative"
                                 style="background-image: url({{ asset($video->thumb)}}); height:200px;">
                                <div class="title">{{ $video->title }}</div>
                                <!-- For testing permission handling -->
                                @if($video->permission == 'true')
                                <div class="permission">Privat</div>
                                @endif
                                <!-- end permission handling -->
                                <p class="p-1"> {{$video->duration}} </p>
                            </div>
                        </a>
                        <div class="card-body p-1">
                            <p class="card-text">
                                @foreach($video->video_course as $vc) <a
                                        href="/course/{{$vc->course_id}}"
                                        class="badge badge-primary">{{\App\Course::find($vc->course_id)->designation}}</a> @endforeach
                            </p>
                        <!--  <p class="card-text">
                                <span class="badge badge-light">{{$video->category->category_name}}</span>
                            </p> -->
                            <p class="card-text">
                                @foreach($video->presenters() as $presenter) <a href="/presenter/{{$presenter->id}}"
                                        class="badge badge-light">{{$presenter->name}}</a> @endforeach</p>
                            <p class="card-text" id="tags">@foreach($video->tags() as $tag) <a href="/tag/{{$tag->id}}"
                                        class="badge badge-secondary">{{$tag->name}}</a> @endforeach</p>
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
