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
                        <span class="far fa-clock fa-icon mr-2" aria-hidden="true"></span>
                        {{ __("Last added presentations") }}
                        @if (in_array(app()->make('play_role'), [ 'Student','Student1', 'Student2', 'Student3']) && isset($my) && $my->count())
                            {{ __("from your ongoing courses") }}
                        @endif
                        @if (isset($course))
                            {{ __("from the course") }} <i> @if(Lang::locale() == 'swe')
                                    {{$course->name}}
                                @else
                                    {{$course->name_en}}
                                @endif {{$course->semester}}{{$course->year}}</i>
                        @elseif (isset($tag))
                            {{ __("after the tag: ") }} <i>{{$tag}}</i>
                        @elseif (isset($presenter))
                            {{ __("by") }} <i>{{$presenter}}</i>
                        @endif
                    </h3>
                </div>
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>
    <div class="container">
        @if (isset($active_vt) || isset($my))
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                @if (isset($my) && !$my->isEmpty())
                    <!-- Paginated tab -->
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#my" data-toggle="tab" role="tab" aria-controls="my"
                           title="
                            @if(in_array(app()->make('play_role'), ['Courseadmin','Uploader', 'Staff']))
                                @lang('lang.my_presentations')">@lang('lang.my_presentations')
                            @else
                                @lang('lang.my_courses')">@lang('lang.my_courses')
                            @endif
                            <span class="count-label">{{$mypaginated->total()}}</span>
                        </a>
                    </li>
                @endif
                <!-- VT 2023 -->
                @if (isset($active_vt) && !$active_vt->isEmpty())
                    <!-- Paginated tab -->
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#active_vt" data-toggle="tab" role="tab" aria-controls="active_vt"
                           title="@lang('lang.active_courses_vt')">@lang('lang.active_courses_vt') <span
                                class="count-label">{{$activepaginated_vt->total()}}</span></a>
                    </li>
                @endif
                <!-- HT 2023 -->
                @if (isset($active_ht) && !$active_ht->isEmpty())
                    <!-- Paginated tab -->
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#active_ht" data-toggle="tab" role="tab" aria-controls="active_ht"
                           title="@lang('lang.active_courses_ht')">@lang('lang.active_courses_ht')
                            <span class="count-label">{{$activepaginated_ht->total()}}</span>
                        </a>
                    </li>
                @endif
                <!-- HT 2022 -->
                @if (isset($previous_ht) && !$previous_ht->isEmpty())
                    <!-- Paginated tab -->
                    <li class="nav-item pb-0">
                            <a class="nav-link" href="#previous_ht" data-toggle="tab" role="tab" aria-controls="previous_ht"
                               title="@lang('lang.previous_courses_ht')">@lang('lang.previous_courses_ht') <span
                                    class="count-label">{{$previouspaginated_ht->total()}}</span></a>
                    </li>
                @endif

                <!-- Paginated tab -->

                @if (isset($latest) && !isset($course) && $allpaginated->total())
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#all" data-toggle="tab" role="tab" aria-controls="all"
                           title="@lang('lang.latest')">@lang('lang.latest') <span
                                    class="count-label">{{$allpaginated->total()}}</span>
                            @if($pending->count())
                            <div class="la-line-scale la-dark la-sm">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                            @endif
                        </a>
                    </li>
                @endif
                {{--}}
                @if (isset($latest) && $latest->count())
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#all" data-toggle="tab" role="tab" aria-controls="all"
                           title="@lang('lang.latest')">@lang('lang.latest') <span class="count-label">{{$latest->count()}}+</span></a>
                    </li>
                @endif
                {{--}}
            </ul>

        @endif

        <!-- Tab Contend -->

        <div class="tab-content" id="myTabContent">
            <!-- Content tab My -->
            @if (isset($my) && !$my->isEmpty())
                <div id="my" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-A">
                    <!--  Pagination for tab1 - My courses -->
                    <div class="pagination justify-content-center mt-4">
                        {{ $mypaginated->fragment('my')->links() }}
                    </div>

                    <div class="card-deck inner">
                        @foreach ($my as $key => $video)
                            <div class="col my-3 w">
                                @include('home.video')
                                @include('layouts.partials.videomodals')
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
                    <!--  Pagination for tab1 - My courses -->
                    <div class="pagination justify-content-center">
                        {{ $mypaginated->fragment('my')->links() }}
                    </div>
                    <!-- -->
                </div>
            @endif

            <!-- Content HT 2023 Active -->
            @if (isset($active_ht) && !$active_ht->isEmpty())
                <div id="active_ht" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-B">

                    <!-- Pagination for HT2023  Active courses -->
                    <div class="pagination justify-content-center mt-4">
                        {{ $activepaginated_ht->fragment('active_ht')->links() }}
                    </div>
                    <!-- -->
                    <div class="card-deck inner">
                        @foreach ($active_ht as $key => $video)
                            <div class="col my-3">
                                @include('home.video')
                                @include('layouts.partials.videomodals')
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
                    <!-- Pagination for tab2  Active courses -->
                    <div class="pagination justify-content-center">
                        {{ $activepaginated_ht->fragment('active_ht')->links() }}
                    </div>
                    <!-- -->
                </div>
            @endif

            <!-- Content VT 2023 Active -->
            @if (isset($active_vt) && !$active_vt->isEmpty())
                <div id="active_vt" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
                    <!-- Pagination for tab2  Active courses -->
                    <div class="pagination justify-content-center mt-4">
                        {{ $activepaginated_vt->fragment('active_vt')->links() }}
                    </div>
                    <!-- -->
                    <div class="card-deck inner">
                        @foreach ($active_vt as $key => $video)
                            <div class="col my-3">
                                @include('home.video')
                                @include('layouts.partials.videomodals')
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
                    <!-- Pagination for tab2  Active courses -->
                    <div class="pagination justify-content-center">
                        {{ $activepaginated_vt->fragment('active_vt')->links() }}
                    </div>
                    <!-- -->
                </div>
            @endif

            <!-- Content HT 2022 Previous -->
            @if (isset($previous_ht) && !$previous_ht->isEmpty())
                <div id="previous_ht" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-D">

                    <!-- Pagination for HT2022  Previous courses -->
                    <div class="pagination justify-content-center mt-4">
                        {{ $previouspaginated_ht->fragment('previous_ht')->links() }}
                    </div>
                    <!-- -->
                    <div class="card-deck inner">
                        @foreach ($previous_ht as $key => $video)
                            <div class="col my-3">
                                @include('home.video')
                                @include('layouts.partials.videomodals')
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
                    <!-- Pagination for tab2  Previous courses -->
                    <div class="pagination justify-content-center">
                        {{ $previouspaginated_ht->fragment('previous_ht')->links() }}
                    </div>
                    <!-- -->
                </div>
            @endif
            <!-- Content tab All -->
            <div id="all" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-E">
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

                    @if (!isset($course))
                        <!--  Pagination for tab3 - All courses -->
                        <div class="pagination justify-content-center mt-4">
                            {{ $allpaginated->fragment('all')->links() }}
                        </div>
                    @endif

                    <div class="card-deck inner">
                        @if (isset($pending) && $pending->count())
                            @foreach ($pending as $key => $video)
                                <div class="col my-3">
                                    @include('home.pending_video')
                                </div>
                            @endforeach
                        @endif
                        @if (isset($tagged) && $tagged)
                            @foreach($tagged as $tagname => $taggedvideos)
                                <div class="row mx-1 mt-2">
                                    <div class="col">
                                        <h2>{{$tagname ? $tagname : 'Uncategorized'}}</h2>
                                    </div>
                                </div>
                                <div class="row mx-1">
                                    @foreach ($taggedvideos as $key => $video)
                                        <div class="col my-3">
                                            @include('home.video')
                                            @include('layouts.partials.videomodals')
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
                            @endforeach
                        @else
                            @foreach ($latest as $key => $video)
                                <div class="col my-3">
                                    @include('home.video')
                                    @include('layouts.partials.videomodals')
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
                        @endif

                    </div>
                @else
                    <p class="my-3">
                        {{ __("No presentations from ongoing courses were found") }}
                    </p>
                @endif
                <!-- Pagination for tab3 - All courses -->
                @if (!isset($course))
                    <div class="pagination justify-content-center">
                        {{ $allpaginated->fragment('all')->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!--Download modal -->
    <livewire:modals.download-presentation/>

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
    {{--}} For pagination
    <script>
        $(document).ready(function(){
            var url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs a[href="#' + url.split('#')[1] + '"]')[0].click();
            }
            //To make sure that the page always goes to the top
            setTimeout(function () {
                window.scrollTo(0, 0);
            },200);
        });
    </script>
    {{--}}
    <script>
        $(document).ready(() => {
            let url = location.href.replace(/\/$/, "");
            if (location.hash) {
                const hash = url.split("#");
                $('#myTab a[href="#' + hash[1] + '"]').tab("show");
                url = location.href.replace(/\/#/, "#");
                history.replaceState(null, null, url);
                setTimeout(() => {
                    $(window).scrollTop(0);
                }, 400);
            }
            $('a[data-toggle="tab"]').on("click", function () {
                let newUrl;
                const hash = $(this).attr("href");
                if (hash == "#my") {
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
