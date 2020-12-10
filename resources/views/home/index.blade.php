@extends('layouts.suplay')
@section('content')

    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <h1 class="word-wrap_xs-only">Latest videos</h1>
                </div>

            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container">

        <div class="d-flex mb-3 flex-wrap">
            @foreach ($latest as $video)
                <div class="col my-3">
                    <div class="card video m-auto">
                        <a href="{{ route('player', ['video' => $video]) }}">
                            <div class="card-header position-relative"
                                 style="background-image: url({{ asset(json_decode($video->presentation)->sources[0]->poster)}}); height:200px;">
                                <div class="title">{{ $video->title }}</div>
                                <i class="fas fa-play-circle"></i>
                                <p class="p-1"> {{$video->duration}} </p>
                            </div>
                        </a>
                        <div class="card-body p-1">
                            <p class="card-text">
                                Kurs: @foreach($video->video_course as $vc) <a
                                        href="/course/{{$vc->course_id}}">{{\App\Course::find($vc->course_id)->course_name}}</a> @endforeach
                                <br>
                                Kategori: {{$video->category->category_name}}
                            </p>
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