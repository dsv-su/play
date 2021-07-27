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
                        {{ __("Last added presentations") }}
                        @if (in_array(app()->make('play_role'), [ 'Student','Student1', 'Student2', 'Student3']) && isset($my) && $my->count())
                            {{ __("from your ongoing courses") }}
                        @endif
                        @if (isset($course))
                            {{ __("from the course") }} <i>{{$course->name}} {{$course->semester}}{{$course->year}}</i>
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
                        <a class="nav-link" href="#pane-A" data-toggle="tab"
                           title="@lang('lang.my_courses')">@lang('lang.my_courses')</a>
                    </li>
                @endif
                @if (isset($active) && !$active->isEmpty())
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#pane-B" data-toggle="tab"
                           title="@lang('lang.active_courses')">@lang('lang.active_courses')</a>
                    </li>
                @endif
                @if (isset($latest) && $latest->count())
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#pane-C" data-toggle="tab"
                           title="@lang('lang.latest')">@lang('lang.latest')</a>
                    </li>
                @endif
            </ul>
        @endif
        <div class="tab-content" id="myTabContent">
            <!-- Content tab My -->
            @if (isset($my) && !$my->isEmpty())
                <div id="pane-A" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-A">
                    <div class="card-deck inner">
                        @foreach ($my as $video)
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
                </div>
            @endif
        <!-- Content tab Active -->
            @if (isset($active) && !$active->isEmpty())
                <div id="pane-B" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
                    <div class="card-deck inner">
                        @foreach ($active as $video)
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
                </div>
        @endif
        <!-- Content tab Active -->
            <div id="pane-C" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
                @if (isset($latest) && $latest->count())
                    @if (isset($courses) || isset($terms))
                        <form class="form-inline">
                            <label class="col-form-label mr-1 font-weight-light">Filter by: </label>
                            @if (isset($courses))
                                <select name="course" class="form-control mx-1 selectpicker"
                                        data-none-selected-text="Course" multiple style="width: 400px">
                                    @foreach($courses as $designation => $name)
                                        <option value="{{$designation}}">{{$name}} ({{$designation}})</option>
                                    @endforeach
                                </select>
                            @endif
                            @if (isset($terms))
                                <select name="semester" class="form-control mx-1 selectpicker"
                                        data-none-selected-text="Term" multiple
                                        style="width: 200px">
                                    @foreach($terms as $term)
                                        <option value="{{$term}}">{{$term}}</option>
                                    @endforeach
                                </select>
                            @endif
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                        </form>
                    @endif
                    <div class="card-deck inner">
                        @foreach ($latest as $video)
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
            </div>
        </div>
    </div>

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
            $.ajax({
                type: 'POST',
                url: "/{{ Request::path()}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $('#pane-A').find('.card-deck.inner').html(data);
                },
                error: function (data) {
                    alert('There was an error.');
                    console.log(data);
                }
            });
        });
    </script>

@endsection
