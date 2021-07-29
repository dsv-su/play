@extends('layouts.suplay')
@section('content')

    @if (!$manage)
        @include('layouts.partials.searchbox')
    @endif

    <!-- Header message section -->
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header mb-4">
                        <span class="far fa-clock fa-icon-border mr-2" aria-hidden="true"></span>
                        @if ($manage) Manage presentations @else Search results @endif
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-0">
        @if(count($videos) > 0)
            <div id="collapseVideo">
                @if (isset($videopresenters) || isset($videoterms) || isset($videocourses) || isset($videotags))
                    <form class="form-inline mx-3">
                        <label class="col-form-label mr-1 font-weight-light">Filter by: </label>
                        <select name="course" @if (empty($videocourses)) disabled
                                @endif class="form-control mx-1 selectpicker"
                                data-none-selected-text="Course" data-live-search="true" multiple style="width: 400px">
                            @foreach($videocourses as $designation => $name)
                                <option value="{{$designation}}">{{$name}} @if ($designation != 'nocourse')
                                        ({{$designation}})@endif</option>
                            @endforeach
                        </select>
                        <select name="semester" @if (empty($videoterms)) disabled
                                @endif class="form-control mx-1 selectpicker" data-none-selected-text="Term"
                                data-live-search="true"
                                multiple style="width: 200px">
                            @foreach($videoterms as $term)
                                <option value="{{$term}}">{{$term}}</option>
                            @endforeach
                        </select>
                        <select name="presenter" @if (empty($videopresenters)) disabled
                                @endif class="form-control mx-1 selectpicker"
                                data-none-selected-text="Presenter" data-live-search="true" multiple
                                style="width: 200px;">
                            @foreach($videopresenters as $username => $name)
                                <option value="{{$username}}">{{$name}}</option>
                            @endforeach
                        </select>
                        <select name="tag" @if (empty($videotags)) disabled
                                @endif class="form-control mx-1 selectpicker"
                                data-none-selected-text="Tag" data-live-search="true" multiple style="width: 200px;">
                            @foreach($videotags as $tag)
                                <option value="{{$tag}}">{{$tag}}</option>
                            @endforeach
                        </select>
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
            formData.append("tag", $('select[name="tag"]').val());
            formData.append("filtered", '1');
            $.ajax({
                type: 'POST',
                url: "/{{ Request::path()}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $('#collapseVideo').find('.d-flex').html(data['html']);
                    $('select[name="tag"] option').each(function () {
                        if (data['tags'].indexOf($(this).val()) >= 0) {
                            $(this).prop('disabled', false);
                        } else {
                            $(this).prop('disabled', true);
                        }
                    });
                    $('select[name="course"] option').each(function () {
                        if (data['courses'][$(this).val()]) {
                            $(this).prop('disabled', false);
                        } else {
                            $(this).prop('disabled', true);
                        }
                    });
                    $('select[name="presenter"] option').each(function () {
                        if (data['presenters'][$(this).val()]) {
                            $(this).prop('disabled', false);
                        } else {
                            $(this).prop('disabled', true);
                        }
                    });
                    $('select[name="semester"] option').each(function () {
                        if (data['terms'].indexOf($(this).val()) >= 0) {
                            $(this).prop('disabled', false);
                        } else {
                            $(this).prop('disabled', true);
                        }
                    });
                    $('.selectpicker').selectpicker('refresh');
                },
                error: function (data) {
                    alert('There was an error.');
                    console.log(data);
                }
            });
        });
    </script>

@endsection
