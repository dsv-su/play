@extends('layouts.suplay')
@section('content')

    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <h1 class="word-wrap_xs-only">Video management</h1>
                </div>

            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>
    <div class="container">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="filter_category">Category:</label>
                <!-- Filtering -->
                <select class="custom-select" name="filter_category" id="filter_category">
                    <option value="0" @if(!app('request')->input('category')) selected @endif
                    >Choose category
                    </option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}"
                                @if(app('request')->input('category') == $category->id) selected @endif>{{$category->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="filter_course">Course:</label>
                <!-- Filtering -->
                <select class="custom-select" name="filter_course" id="filter_course">
                    <option value="0" @if(!app('request')->input('course')) selected @endif
                    >Choose course
                    </option>
                    @foreach($allcourses as $course)
                        <option value="{{$course->id}}"
                                @if(app('request')->input('course') == $course->id) selected @endif>{{$course->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="container px-0">
        <div class="d-flex mb-3 flex-wrap">
            @foreach ($videos as $video)
                @if(app('request')->input('course') && $video->courses()->where('id', app('request')->input('course'))->isEmpty())
                    @continue
                @endif
                @if(app('request')->input('category') && $video->category_id != app('request')->input('category'))
                    @continue
                @endif
                <div class="col my-3">
                    <div class="card video m-auto" id="{{$video->id}}">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <a href="{{ route('player', ['video' => $video]) }}">
                            <div class="card-header position-relative"
                                 style="background-image: url({{ asset(json_decode($video->presentation)->sources[0]->poster)}}); height:200px;">
                                <div class="title">{{ $video->title }}</div>
                                <p class="p-1"> {{$video->duration}} </p>
                            </div>
                        </a>
                        <div class="card-body p-1">
                            <p class="card-text">
                                @foreach($video->video_course as $vc) <a
                                        href="/course/{{$vc->course_id}}"
                                        class="badge badge-primary">{{\App\Course::find($vc->course_id)->name}}</a> @endforeach
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
                            <p class="card-text">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-{{$video->id}}">
                                    Edit
                                </button>
                                <button class="delete btn btn-danger" type="submit">Delete</button>
                            </p>
                        </div>
                    </div>
                    <!-- The Modal -->
                    <div class="modal fade" id="modal-{{$video->id}}" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <!-- Modal content -->
                            <div class="modal-content">
                                <form>
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{$video->title}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="video_category_{{$video->id}}">Category:</label>
                                        <select name="video_category[]" id="video_category_{{$video->id}}" required>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}"
                                                        @if ($category->id == $video->category_id) selected @endif>{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="video_course_{{$video->id}}">Course:</label>
                                        <select name="video_course[]" id="video_course_{{$video->id}}" required>
                                            @foreach($allcourses as $course)
                                                <option value="{{$course->id}}"
                                                        @if ($course->id == $video->course_id) selected @endif>{{$course->course}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" class="btn btn-primary save" id="{{$video->id}}">
                                            Save changes
                                        </button>
                                    </div>
                                </form>
                            </div>
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

    <script>
        $(document).ready(function () {
            $('button.delete').on('click', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let formData = new FormData();
                let video_id = $(this).closest('div.video').attr('id');
                formData.append("video_id", video_id);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('manage.deleteVideo') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: () => {
                        alert('The video has been deleted');
                        $("#" + video_id).closest('.col').hide();
                    },
                    error: function () {
                        alert('There was an error in deleting the video.');
                    }
                });
            });

            $('button.save').on('click', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let formData = new FormData();
                let video_id = $(this).attr('id');
                formData.append("video_id", video_id);
                formData.append('category_id', $(this).closest('form').find('#video_category_'+video_id).val());
                formData.append('course_id', $(this).closest('form').find('#video_course_'+video_id).val());

                $.ajax({
                    type: 'POST',
                    url: "{{ route('manage.editVideo') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        alert('Changed saved.');
                        $("#" + video_id).find('#course').text(data.course);
                        $("#" + video_id).find('#category').text(data.category);
                        $(this).closest('div.modal').hide();
                    },
                    error: function () {
                        alert('There was an error in editing the video.');
                    }
                });
            });
            $("#filter_category").change(function () {
                filter_search('category', this.value)
            });
            $("#filter_course").change(function () {
                filter_search('course', this.value);
            });
        });

        function filter_search(subject, value) {
            let url = new URL(location.href);
            let search_params = url.searchParams;
            search_params.set(subject, value);
            url.search = search_params.toString();
            document.location.href = url.toString();
        }
    </script>

@endsection
