@extends('layouts.suplay')
@section('content')
    <!-- Header message section -->
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <span class="su-theme-anchor"></span>
                <h3 class="su-theme-header mb-4">
                    <i class="fas fa-edit fa-icon mr-2"></i> {{__('Manage presentations')}} ({{count($videos)}})
                </h3>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container">
        @foreach($courselist as $year => $list)
            <h3 class="su-theme-header mb-4"><span style="color: blue;">{{$year}}</span></h3>
            @foreach($list as $courseId => $course)
            <div class="card mt-5 pt-2 pb-0 px-3" style="background-color: #DADADA;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">
                                <b>{{$course}}</b>
                                <div class="container text-right">
                                    <p class="d-inline">{{__("Course settings")}}</p>
                                    <a class="btn btn-outline-primary" role="button" href="{{ route('course_edit', $courseId) }}"><span style="color: blue;"><i class="fas fa-cog fa-3x"></i></span></a>
                                </div>

                            </h4>
                        </div>

                        <div class="container px-0">
                            @if(count($videos) > 0)
                                <div id="collapseVideo">

                                    <div class="d-flex flex-wrap">
                                        @foreach ($videos as $key => $video)
                                            @foreach($video->courses()->toArray() as $course)
                                                @if($courseId == $course['id'])
                                                <div class="col my-3">
                                                    @include('home.video')
                                                </div>
                                                @endif
                                            @endforeach
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
                        </div><!-- /.container -->

                    </div>
                </div>
            </div>
            @endforeach
        @endforeach
    </div>

@endsection
