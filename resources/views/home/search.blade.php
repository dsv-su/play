@extends('layouts.suplay')
@section('content')

    @if (!$manage)
        @include('layouts.partials.searchbox')
    @endif

    <!-- Header message section -->
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <span class="su-theme-anchor"></span>
                <h3 class="su-theme-header mb-4">
                    @if ($manage)
                        <i class="fas fa-edit fa-icon mr-2"></i> {{__('Manage presentations')}}
                    @else
                        <i class="fas fa-search fa-icon mr-2"></i>  {{__('Search results')}}
                    @endif
                </h3>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-0">
        @if(count($videos) > 0)
            <div id="collapseVideo">
                @if (isset($videopresenters) || isset($videoterms) || isset($videocourses) || isset($videotags))
                    <form class="form-inline mx-3">
                        <label class="col-form-label mr-1 font-weight-light">{{__('Filter by')}}: </label>
                        <select name="course" @if (empty($videocourses)) disabled
                                @endif class="form-control mx-1 selectpicker"
                                data-none-selected-text="{{ __('Course') }}" data-live-search="true" multiple
                                style="width: 400px">
                            @foreach($videocourses as $designation => $name)
                                <option value="{{$designation}}"
                                        @if (isset($filters['courses']) && in_array($designation, $filters['courses'])) selected @endif>{{$name}} @if ($designation != 'nocourse')
                                        ({{$designation}})
                                    @endif</option>
                            @endforeach
                        </select>
                        <select name="presenter" @if (empty($videopresenters)) disabled
                                @endif class="form-control mx-1 selectpicker"
                                data-none-selected-text="{{ __('Presenter') }}" data-live-search="true" multiple
                                style="width: 200px;">
                            @foreach($videopresenters as $username => $name)
                                <option value="{{$username}}"
                                        @if (isset($filters['presenters']) && in_array($username, $filters['presenters'])) selected @endif>{{$name}}</option>
                            @endforeach
                        </select>
                        <select name="semester" @if (empty($videoterms)) disabled
                                @endif class="form-control mx-1 selectpicker" data-none-selected-text="{{ __('Term')}}"
                                data-live-search="true"
                                multiple style="width: 200px">
                            @foreach($videoterms as $term)
                                <option value="{{$term}}"
                                        @if (isset($filters['terms']) && in_array($term, $filters['terms'])) selected @endif>{{$term}}</option>
                            @endforeach
                        </select>
                        <select name="tag" @if (empty($videotags)) disabled
                                @endif class="form-control mx-1 selectpicker"
                                data-none-selected-text="{{ __('Tag') }}" data-live-search="true" multiple
                                style="width: 200px;">
                            @foreach($videotags as $tag)
                                <option value="{{$tag}}"
                                        @if (isset($filters['tags']) && in_array($tag, $filters['tags'])) selected @endif>{{$tag}}</option>
                            @endforeach
                        </select>
                        <button type="button" class="mb-2 btn btn-outline-secondary"
                                onclick="$('.selectpicker').selectpicker('deselectAll'); $('.selectpicker').selectpicker('refresh');">
                            {{ __("Clear selection") }}
                        </button>
                        <button type="button" class="mb-2 ml-1 btn btn-outline-secondary collapsed" id="toggle">
                            {{ __("Expand all") }}
                        </button>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                    </form>
                @endif
                <form id="videoformat" class="form-inline mx-3" method="post" action="{{route('updateVideoFormat')}}">
                    @csrf
                    <label class="my-1 mr-2" for="role">Display</label>
                    <select class="form-control my-1 mr-sm-2 selectpicker" id="videoformat" name="videoformat">
                        <option @if(Cookie::get('videoformat') == 'grid') selected @endif value="grid">Grid</option>
                        <option @if(Cookie::get('videoformat') == 'list') selected @endif value="list">List</option>
                        <option @if(Cookie::get('videoformat') == 'table') selected @endif value="table">Table</option>
                    </select>
                </form>
                <div id="navigator_content">
                    @include('home.courselist')
                </div>
            </div>
        @else
            <h3 class="col mt-4">{{ __("No presentations") }}</h3>
        @endif
    </div><!-- /.container -->

    <script>
        $(document).on('click', '#toggle', function (e) {
            if ($(this).hasClass('expanded')) {
                $('#navigator_content').find('div.collapse').collapse('hide');
                $(this).text("{{ __('Expand all')}}");
            } else {
                $('#navigator_content').find('div.collapse').collapse('show');
                $(this).text("{{ __('Collapse all')}}");
            }
            $(this).toggleClass('expanded collapsed');
        });
        $(document).on('change', 'select', function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var course = $('select[name="course"]').val();
            var presenter = $('select[name="presenter"]').val();
            var semester = $('select[name="semester"]').val();
            var tag = $('select[name="tag"]').val();
            var url = '?';

            let formData = new FormData();

            if (course && course.length) {
                url += '&course=' + course;
                formData.append("course", $('select[name="course"]').val());
            }
            if (presenter && presenter.length) {
                url += '&presenter=' + presenter;
                formData.append("presenter", $('select[name="presenter"]').val());
            }
            if (tag && tag.length) {
                url += '&tag=' + tag;
                formData.append("tag", $('select[name="tag"]').val());
            }
            if (semester && semester.length) {
                url += '&semester=' + semester;
                formData.append("semester", $('select[name="semester"]').val());
            }

            window.history.replaceState(null, null, url);

            $.ajax({
                type: 'POST',
                url: "/{{ Request::path()}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $('#collapseVideo').find('#navigator_content').html(data['html']);
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
