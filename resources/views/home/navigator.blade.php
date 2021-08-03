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
                            <i>{{\App\Course::where('designation', $designation)->latest()->first()->name}}</i>
                        @elseif($category ?? '')
                            <span class="fas fa-address-card fa-icon-border mr-2" aria-hidden="true"></span>
                            @lang('lang.category'): <i>{{$category}}</i>
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
                    <label class="col-form-label mr-1 font-weight-light">Filter by: </label>
                    <select name="course" @if (empty($courses)) disabled
                            @endif class="form-control mx-1 selectpicker"
                            data-none-selected-text="Course" data-live-search="true" multiple style="width: 400px">
                        @foreach($courses as $designation => $name)
                            <option value="{{$designation}}">{{$name}} @if ($designation != 'nocourse')
                                    ({{$designation}})@endif</option>
                        @endforeach
                    </select>
                    @if (isset($presenters))
                        <select name="presenter" class="form-control mx-1 selectpicker"
                                data-none-selected-text="Presenter" data-live-search="true" multiple
                                style="width: 400px;">
                            @foreach($presenters as $username => $name)
                                <option value="{{$username}}">{{$name}}</option>
                            @endforeach
                        </select>
                    @endif
                    @if (isset($terms))
                        <select name="semester" class="form-control mx-1 selectpicker" data-none-selected-text="Term"
                                data-live-search="true" multiple
                                style="width: 200px">
                            @foreach($terms as $term)
                                <option value="{{$term}}">{{$term}}</option>
                            @endforeach
                        </select>
                    @endif
                    @if (isset($tags))
                        <select name="tag" @if (empty($tags)) disabled
                                @endif class="form-control mx-1 selectpicker"
                                data-none-selected-text="Tag" data-live-search="true" multiple style="width: 200px;">
                            @foreach($tags as $tag)
                                <option value="{{$tag}}">{{$tag}}</option>
                            @endforeach
                        </select>
                    @endif
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                </form>
            @endif
            <div id="navigator_content">
                @foreach ($videos as $key => $videocourse)
                    <h3 class="col mt-4">
                        <a class="link @if ($videos->first() !== $videocourse) collapsed @endif" data-toggle="collapse"
                           href="#collapse{{str_replace(' ', '', $key)}}" role="button" aria-expanded="false"
                           aria-controls="collapse{{str_replace(' ', '', $key)}}"><i class="fa mr-2"></i>
                            @if($designation ?? '') {{$designation}} @elseif($category ?? '') {{$category}} @endif {{$key}}
                            ({{count($videocourse)}} st)
                        </a>
                    </h3>

                    <div class="collapse @if ($videos->first() == $videocourse) show @endif"
                         id="collapse{{str_replace(' ', '', $key)}}">
                        <div class="d-flex flex-wrap">
                            @foreach ($videocourse as $video)
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
                @endforeach
            </div>
        @else
            <h3 class="col mt-4">{{ __("No presentations") }}</h3>
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
            formData.append("course", $('select[name="course"]').val());
            formData.append("presenter", $('select[name="presenter"]').val());
            formData.append("semester", $('select[name="semester"]').val());
            formData.append("tag", $('select[name="tag"]').val());
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
