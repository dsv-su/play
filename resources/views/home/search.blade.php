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
                @if (isset($videopresenters) || isset($videoterms) || isset($videocourses))
                    <form class="form-inline mx-3 mt-3">
                        <label class="col-form-label mr-1 font-weight-light">Filter by: </label>
                        @if (isset($videocourses))
                            <select name="course" class="form-control mx-1 selectpicker"
                                    data-none-selected-text="Course" multiple style="width: 400px">
                                @foreach($videocourses as $designation => $name)
                                    <option value="{{$designation}}">{{$name}} ({{$designation}})</option>
                                @endforeach
                            </select>
                        @endif
                        @if (isset($videoterms))
                            <select name="semester" class="form-control mx-1 selectpicker" data-none-selected-text="Term"
                                    multiple style="width: 200px">
                                @foreach($videoterms as $term)
                                    <option value="{{$term}}">{{$term}}</option>
                                @endforeach
                            </select>
                        @endif
                        @if (isset($videopresenters))
                            <select name="presenter" class="form-control mx-1 selectpicker"
                                    data-none-selected-text="Presenter" multiple style="width: 400px;">
                                @foreach($videopresenters as $username => $name)
                                    <option value="{{$username}}">{{$name}}</option>
                                @endforeach
                            </select>
                        @endif
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                    </form>
                @endif
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

    <script>
        $(document).on('change', 'select', function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = new FormData();
            formData.append("presenter", $('select[name="presenter"]').val());
            formData.append("semester", $('select[name="semester"]').val());
            formData.append("course", $('select[name="course"]').val());
            formData.append("filtered", '1');
            formData.append("q", $('#header-main-search-text').val());
            $.ajax({
                type: 'POST',
                url: "/{{ Request::path()}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $('#collapseVideo').find('.d-flex').html(data);
                },
                error: function (data) {
                    alert('There was an error.');
                    console.log(data);
                }
            });
        });
    </script>

@endsection
