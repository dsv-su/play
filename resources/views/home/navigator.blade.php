@extends('layouts.suplay')
@section('content')
    @include('layouts.partials.searchbox')
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header">
                        @if($term ?? '' and $year ?? '')
                            <span class="fas fa-layer-group fa-icon-border mr-2" aria-hidden="true"></span>
                            {{ __("presentations from") }} {{$term}}{{$year}}
                        @elseif($designation ?? '')
                            <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                            @lang('lang.course'):
                            @if (\App\Course::where('designation', $designation)->count())
                                <i>{{(Lang::locale() == 'swe') ? \App\Course::where('designation', $designation)->latest()->first()->name : \App\Course::where('designation', $designation)->latest()->first()->name_en}}</i>
                            @else
                                <i>{{$designation}}</i>
                            @endif
                        @elseif($category ?? '')
                            <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                            @lang('lang.category'): <i>{{$category}}</i>
                        @elseif($tag ?? '')
                            <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                            @lang('lang.tag'): <i>{{$tag}}</i>
                        @elseif($presenter ?? '')
                            <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                            @lang('lang.presenter'): <i>{{$presenter->name}} ({{$presenter->username}})</i>
                        @endif
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>

    <div class="container px-0">
        @if(count($videos) > 0)
            @if (isset($presenters) || isset($terms) || isset($tags) || isset($courses))
                <form class="form-inline mx-3">
                    <label class="col-form-label mr-1 font-weight-light">{{__('Filter by')}}: </label>
                    @if (isset($courses))
                        <select name="course" @if (empty($courses)) disabled
                                @endif class="form-control mx-1 selectpicker"
                                data-none-selected-text="{{ __('Course') }}" data-live-search="true" multiple
                                style="width: 400px">
                            @foreach($courses as $designation => $name)
                                <option value="{{$designation}}"
                                        @if (isset($filters['courses']) && in_array($designation, $filters['courses'])) selected @endif>{{$name}} @if ($designation != 'nocourse')
                                        ({{$designation}})@endif</option>
                            @endforeach
                        </select>
                    @endif
                    @if (isset($presenters))
                        <select name="presenter" class="form-control mx-1 selectpicker"
                                data-none-selected-text="{{ __('Presenter') }}" data-live-search="true" multiple
                                style="width: 400px;">
                            @foreach($presenters as $username => $name)
                                <option value="{{$username}}"
                                        @if (isset($filters['presenters']) && in_array($username, $filters['presenters'])) selected @endif>{{$name}}</option>
                            @endforeach
                        </select>
                    @endif
                    @if (isset($terms))
                        <select name="semester" class="form-control mx-1 selectpicker"
                                data-none-selected-text="{{ __('Term') }}"
                                data-live-search="true" multiple
                                style="width: 200px">
                            @foreach($terms as $term)
                                <option value="{{$term}}"
                                        @if (isset($filters['terms']) && in_array($term, $filters['terms'])) selected @endif>{{$term}}</option>
                            @endforeach
                        </select>
                    @endif
                    @if (isset($tags))
                        <select name="tag" @if (empty($tags)) disabled
                                @endif class="form-control mx-1 selectpicker"
                                data-none-selected-text="{{ __('Tag') }}" data-live-search="true" multiple
                                style="width: 200px;">
                            @foreach($tags as $tag)
                                <option value="{{$tag}}"
                                        @if (isset($filters['tags']) && in_array($tag, $filters['tags'])) selected @endif>{{$tag}}</option>
                            @endforeach
                        </select>
                    @endif
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
            <div id="navigator_content">
                @include('home.courselist')
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
                    $('#navigator_content').html(data);
                    $('#navigator_content').find('div').first().collapse('show');
                },
                error: function (data) {
                    alert('There was an error.');
                    console.log(data);
                }
            });
        });
    </script>
@endsection
