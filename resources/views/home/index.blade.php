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
                        {{ __("Last added") }}
                        @if (in_array(app()->make('play_role'), [ 'Student','Student1', 'Student2', 'Student3']) && count($latest)>0)
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
        @if (isset($all) && isset($most_viewed) && isset($most_downloaded))
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item pb-0">
                    <a class="nav-link active" href="#pane-A" data-toggle="tab"
                       title="@lang('lang.relevant_courses')">@lang('lang.relevant_courses')</a>
                </li>
                @if (isset($all))
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#pane-B" data-toggle="tab"
                           title="@lang('lang.latest')">@lang('lang.latest')</a>
                    </li>
                @endif
                @if(app()->make('play_role') == 'Administrator')
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#pane-C" data-toggle="tab"
                           title="@lang('lang.viewed')">@lang('lang.viewed')</a>
                    </li>
                    <li class="nav-item pb-0">
                        <a class="nav-link" href="#pane-D" data-toggle="tab"
                           title="@lang('lang.downloaded')">@lang('lang.downloaded')</a>
                    </li>
                @endif
            </ul>
        @endif
        <div class="tab-content" id="myTabContent">
            <div id="pane-A" class="tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
                @if (count($latest)>0)
                    <form class="form-inline">
                        @if (isset($courses))
                            <select name="course" class="form-control mx-1" style="width: 400px">
                                <option selected value="0">Filter by course</option>
                                @foreach($courses as $designation => $name)
                                    <option value="{{$designation}}">{{$name}} ({{$designation}})</option>
                                @endforeach
                            </select>
                        @endif
                        @if (isset($terms))
                            <select name="semester" class="form-control mx-1" style="width: 200px">
                                <option selected value="0">Filter by term</option>
                                @foreach($terms as $term)
                                    <option value="{{$term}}">{{$term}}</option>
                                @endforeach
                            </select>
                        @endif
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                    </form>
                    <div id="test"></div>
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
            <!-- Content tab 2 -->
            @if (isset($all))
                <div id="pane-B" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
                    <div class="card-deck inner">
                        @foreach ($all as $video)
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
        <!-- Content tab 3 -->
            @if(app()->make('play_role') == 'Administrator' && isset($most_viewed) && isset($most_downloaded))
                <div id="pane-C" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
                    <div class="card-deck inner">
                        @foreach ($most_viewed as $video)
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

                <div id="pane-D" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-D">
                    <div class="card-deck inner">
                        @foreach ($most_downloaded as $video)
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
        </div>
    </div>

    <script>
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
                    $('#pane-A .card-deck').html(data);
                },
                error: function (data) {
                    alert('There was an error.');
                    console.log(data);
                }
            });
        });
    </script>

@endsection
