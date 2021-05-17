@extends('layouts.suplay')
@section('content')

    <div class="container banner-inner">
        <div class="row no-gutters w-100">
            <!-- -->

            <!-- -->
            <div class="col-12">
                @if(app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff')
                    <div>
                        <h1 class="word-wrap_xs-only">{{ __("Manage your presentations") }}</h1>
                        <p class="lead-light mb-5 mb-lg-0">{{ __("Here you can edit, download, change rights or delete a presentation you have uploaded.") }}</p>
                    </div>
                @elseif(app()->make('play_role') == 'Administrator')
                    <div>
                        <h1 class="word-wrap_xs-only">{{ __("Manage all presentations") }}</h1>
                    </div>
                @endif
            </div> <!-- col-12 -->
        </div> <!-- row no-gutters -->
    </div>
    <div class="container">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                @if(app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff')
                <label for="filter_category">@lang('lang.category'):</label>
                @else
                <label for="filter_category">@lang('lang.category'):</label>
                @endif
                <!-- Filtering -->
                <select class="custom-select" name="filter_category" id="filter_category">
                    <option value="0" @if(!app('request')->input('category')) selected @endif
                    @if(app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff')
                        >{{ __("Choose category") }}
                    @else
                        >{{ __("Choose category") }}
                    @endif
                    </option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}"
                                @if(app('request')->input('category') == $category->id) selected @endif>{{$category->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                @if(app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff')
                <label for="filter_course">@lang('lang.course'):</label>
                @else
                <label for="filter_course">@lang('lang.course'):</label>
                @endif
                <!-- Filtering -->
                <select class="custom-select" name="filter_course" id="filter_course">
                    <option value="0" @if(!app('request')->input('course')) selected @endif
                    @if(app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff')
                    >{{ __("Choose course") }}
                    @else
                    >{{ __("Choose course") }}
                    @endif
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
                    @include('manage.manage_video')
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
@endsection
