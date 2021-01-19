@foreach($mycourses as $course)
    @if ($course->myvideos->isEmpty())
        @continue
    @endif
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <h2 class="word-wrap_xs-only">{{$course->name}}</h2>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-0">
        <div class="d-flex mb-3 flex-wrap">
            @foreach ($course->myvideos as $video)
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
                        <!--  <p class="card-text">
                                <span class="badge badge-light">{{$video->category->category_name}}</span>
                            </p> -->
                            <p class="card-text">
                                @foreach($video->presenters() as $presenter) <a href="/presenter/{{$presenter->id}}"
                                                                                class="badge badge-light">{{$presenter->name}}</a> @endforeach
                            </p>
                            <p class="card-text" id="tags">@foreach($video->tags() as $tag) <a
                                        href="/tag/{{$tag->id}}"
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
@endforeach