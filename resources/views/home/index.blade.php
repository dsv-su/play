@extends('layouts.suplay')
@section('content')
    @if (isset($pending) && $pending->count() && !session()->has('message'))
        <div class="container banner-inner">
            <div class="row no-gutters w-100">
                <div class="alert alert-info w-100 mb-5">
                    {{__('Some of the uploaded presentations are being processed now. You can see them under "All presentations" tab.')}}
                </div>
            </div>
        </div>
    @endif
    @include('layouts.partials.searchbox')
    <!-- Header message section -->
    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <div class="col-12">
                <div>
                    <span class="su-theme-anchor"></span>
                    <h3 class="su-theme-header mb-4">
                        <span class="far fa-clock fa-icon-border mr-2" aria-hidden="true"></span>
                        {{ __("Last added presentations") }}
                        @if (in_array(app()->make('play_role'), [ 'Student','Student1', 'Student2', 'Student3']) && isset($my) && $my->count())
                            {{ __("from your ongoing courses") }}
                        @endif
                        @if (isset($course))
                            {{ __("from the course") }} <i> @if(Lang::locale() == 'swe'){{$course->name}}@else {{$course->name_en}} @endif {{$course->semester}}{{$course->year}}</i>
                        @elseif (isset($tag)) {{ __("after the tag: ") }} <i>{{$tag}}</i>
                        @elseif (isset($presenter))  {{ __("by") }} <i>{{$presenter}}</i>
                        @endif
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>
    <div class="container">
        @if (isset($active) || isset($my))
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                @if (isset($my) && !$my->isEmpty())
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#my" data-toggle="tab" role="tab" aria-controls="my"
                           title="@lang('lang.my_courses')">@lang('lang.my_courses') ({{$my->count()}})</a>
                    </li>
                @endif
                @if (isset($active) && !$active->isEmpty())
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#active" data-toggle="tab" role="tab" aria-controls="active"
                           title="@lang('lang.active_courses')">@lang('lang.active_courses') {{--}}({{$active->count()}}){{--}}</a>
                    </li>
                @endif
                @if (isset($latest) && $latest->count())
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#all" data-toggle="tab" role="tab" aria-controls="all"
                           title="@lang('lang.latest')">@lang('lang.latest') {{--}}({{$latest->count()}}){{--}}</a>
                    </li>
                @endif
            </ul>
        @endif
        <div class="tab-content" id="myTabContent">
            <!-- Content tab My -->
            @if (isset($my) && !$my->isEmpty())
                <div id="my" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-A">
                    <div class="card-deck inner">
                        @foreach ($my as $key => $video)
                            <div class="col my-3 w">
                                @include('home.video')
                            </div>
                        @endforeach
                        <div class="col">
                            <div class="card video my-0 mx-auto"></div>
                        </div>
                        <div class="col">
                            <div class="card video my-0 mx-auto"></div>
                        </div>
                        <div class="col">
                            <div class="card video my-0 mx-auto"></div>
                        </div>
                    </div>
                </div>
            @endif
        <!-- Content tab Active -->
            @if (isset($active) && !$active->isEmpty())
                <div id="active" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
                    <div class="card-deck inner">
                        @foreach ($active as $key => $video)
                            <div class="col my-3">
                                @include('home.video')
                            </div>
                        @endforeach
                        <div class="col">
                            <div class="card video my-0 mx-auto"></div>
                        </div>
                        <div class="col">
                            <div class="card video my-0 mx-auto"></div>
                        </div>
                        <div class="col">
                            <div class="card video my-0 mx-auto"></div>
                        </div>
                    </div>
                    {{ $activepaginated->links() }}
                </div>

        @endif


        <!-- Content tab Active -->
            <div id="all" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
                @if ((isset($latest) && $latest->count()) || isset($pending) && $pending->count())
                    @if (isset($courses) || isset($terms) || isset($presenters) || isset($tags))
                        <form class="form-inline">
                            <label class="col-form-label mr-1 font-weight-light">Filter by: </label>
                            @if (isset($courses))
                                <select name="course" class="form-control mx-1 selectpicker"
                                        data-none-selected-text="Course" data-live-search="true" multiple
                                        style="width: 400px">
                                    @foreach($courses as $designation => $name)
                                        <option value="{{$designation}}">{{$name}} ({{$designation}})</option>
                                    @endforeach
                                </select>
                            @endif
                            @if (isset($terms))
                                <select name="semester" class="form-control mx-1 selectpicker"
                                        data-none-selected-text="Term" data-live-search="true" multiple
                                        style="width: 200px">
                                    @foreach($terms as $term)
                                        <option value="{{$term}}">{{$term}}</option>
                                    @endforeach
                                </select>
                            @endif
                            @if (isset($presenters))
                                <select name="presenter" class="form-control mx-1 selectpicker"
                                        data-none-selected-text="Presenter" data-live-search="true" multiple
                                        style="width: 200px">
                                    @foreach($presenters as $username => $name)
                                        <option value="{{$username}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            @endif
                            @if (isset($tags))
                                <select name="tag" @if (empty($tags)) disabled
                                        @endif class="form-control mx-1 selectpicker"
                                        data-none-selected-text="Tag" data-live-search="true" multiple
                                        style="width: 200px;">
                                    @foreach($tags as $tag)
                                        <option value="{{$tag}}">{{$tag}}</option>
                                    @endforeach
                                </select>
                            @endif
                            <button type="button" class="mb-2 btn btn-outline-secondary"
                                    onclick="$('.selectpicker').selectpicker('deselectAll'); $('.selectpicker').selectpicker('refresh');">
                                {{__("Clear selection")}}
                            </button>
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                        </form>
                    @endif
                    <div class="card-deck inner">
                        @if (isset($pending) && $pending->count())
                            @foreach ($pending as $key => $video)
                                <div class="col my-3">
                                    @include('home.pending_video')
                                </div>
                            @endforeach
                        @endif
                        @foreach ($latest as $key => $video)
                            <div class="col my-3">
                                @include('home.video')
                            </div>
                        @endforeach
                        <div class="col">
                            <div class="card video my-0 mx-auto"></div>
                        </div>
                        <div class="col">
                            <div class="card video my-0 mx-auto"></div>
                        </div>
                        <div class="col">
                            <div class="card video my-0 mx-auto"></div>
                        </div>
                    </div>
                @else
                    <p class="my-3">
                        {{ __("No presentations from ongoing courses were found") }}
                    </p>
                @endif
                    {{ $allpaginated->links() }}
            </div>
        </div>
    </div>

    <!--Download modal -->
    <livewire:modals.download-presentation />

    <script>
        $(document).ready(function (e) {
            // Makes the first tab visible
            $('#myTab').find('li').first().addClass('active');
            $('#myTab').find('li').first().find('a').addClass('active');
            $('div.tab-pane').first().addClass('show active');
        });

        $(document).on('change', 'select', function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = new FormData();
            formData.append("course", $('select[name="course"]').val());
            formData.append("semester", $('select[name="semester"]').val());
            formData.append("presenter", $('select[name="presenter"]').val());
            formData.append("tag", $('select[name="tag"]').val());
            $.ajax({
                type: 'POST',
                url: "/{{ Request::path()}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $('#all').find('.card-deck.inner').html(data['html']);
                    $('select[name="tag"] option').each(function () {
                        console.log(data['tags']);
                        if (data['tags'].indexOf($(this).val()) >= 0) {
                            $(this).prop('disabled', false);
                        } else {
                            $(this).prop('disabled', true);
                        }
                    });
                    $('select[name="course"] option').each(function () {
                        console.log($(this).val());
                        console.log(data['courses']);
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
                    //alert('There was an error');
                    console.log(data);
                }
            });
        });
    </script>
    <script>
        $(document).ready(() => {
            let url = location.href.replace(/\/$/, "");

            if (location.hash) {
                const hash = url.split("#");
                $('#myTab a[href="#'+hash[1]+'"]').tab("show");
                url = location.href.replace(/\/#/, "#");
                history.replaceState(null, null, url);
                setTimeout(() => {
                    $(window).scrollTop(0);
                }, 400);
            }

            $('a[data-toggle="tab"]').on("click", function() {
                let newUrl;
                const hash = $(this).attr("href");
                if(hash == "#my") {
                    newUrl = url.split("#")[0];
                } else {
                    newUrl = url.split("#")[0] + hash;
                }
                newUrl += "/";
                history.replaceState(null, null, newUrl);
            });
        });
    </script>
@endsection
