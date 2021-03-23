@extends('layouts.suplay')
@section('content')

    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <h1 class="word-wrap_xs-only">Video hantering</h1>
                </div>

            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>
    <div class="container">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="filter_category">Kategori:</label>
                <!-- Filtering -->
                <select class="custom-select" name="filter_category" id="filter_category">
                    <option value="0" @if(!app('request')->input('category')) selected @endif
                    >Välj kategori
                    </option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}"
                                @if(app('request')->input('category') == $category->id) selected @endif>{{$category->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="filter_course">Kurs:</label>
                <!-- Filtering -->
                <select class="custom-select" name="filter_course" id="filter_course">
                    <option value="0" @if(!app('request')->input('course')) selected @endif
                    >Välj kurs
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
                    @include('home.manage_video')
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

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
                        alert('There was an error in deleting the video. Please check the logs for more info.');
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
                formData.append('course_ids', JSON.stringify($(this).closest('form').find('#video_course_'+video_id).val()));
                formData.append('tag_ids', JSON.stringify($(this).closest('form').find('#video_tag_'+video_id).val()));

                $.ajax({
                    type: 'POST',
                    url: "{{ route('manage.editVideo') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        alert(data.message);
                        $("#" + video_id).find('#courses').html(data.courses);
                        $("#" + video_id).find('#tags').html(data.tags);
                        $("#" + video_id).find('#category').html(data.category);
                        $(this).closest('div.modal').modal('hide');
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
