@foreach ($videos as $key => $videocourse)
    <h3 class="col mt-4">
        {{--}} Fix for issue #78 {{--}}
        {{--}}@if (isset($manage) && $manage){{--}}
            <a class="link" data-toggle="collapse"
               href="#collapse{{$key}}" role="button" aria-expanded="false"
               aria-controls="collapse{{$key}}">
                <i class="fa mr-2"></i>{{\App\Course::find($key) ? \App\Course::find($key)->name . ' ' . \App\Course::find($key)->semester.\App\Course::find($key)->year : 'Uncategorized'}}</a>
            <span class="badge badge-primary">{{count($videocourse)}}</span>
            @if ($key && (in_array(\App\Course::find($key)->userPermission(), ['edit', 'delete']))) <a class="badge badge-primary" role="button" style="max-height: 32.38px;"
                          href="{{ route('course_edit', $key) }}"><i class="fas fa-cog"></i></a>
            @endif
        {{--}} Fix for issue #78 {{--}}
       {{--}} @else
            <a class="link @if ($videos->first() !== $videocourse) collapsed @endif" data-toggle="collapse"
               href="#collapse{{$key}}" role="button" aria-expanded="false"
               aria-controls="collapse{{$key}}"><i class="fa mr-2"></i>
                {{\App\Course::find($key)->semester.\App\Course::find($key)->year}}</a>
            <span class="badge badge-primary">{{count($videocourse)}}</span>
        @endif{{--}}
    </h3>

    <div class="collapse @if ($videos->first() == $videocourse || (isset($manage) && $manage))show @endif"
         id="collapse{{$key}}">
        @if (isset($manage) && $manage && $key)
            <h5 class="col">
                @if ($individual_permissions[$key])
                    <span class="badge badge-secondary mb-2">{{$individual_permissions[$key]}} {{__("individual permissions")}}</span>
                @endif
                @if ($playback_permissions[$key])
                    @switch($playback_permissions[$key]->permission_id)
                        @case(1)
                        <span class="badge badge-success mb-2">{{ __("DSV students & staff") }}</span>
                        @break
                        @case(2)
                        <span class="badge badge-secondary mb-2">{{ __("DSV staff only") }}</span>
                        @break
                        @case(4)
                        <span class="badge badge-warning mb-2">{{ __("Public") }}</span>
                        @break
                        @default
                        <span class="badge badge-info mb-2">{{ __("Custom") }}</span>
                    @endswitch
                @else
                    <span class="badge badge-success mb-2">{{__("DSV students & staff")}}</span>
                @endif
                @if(!key_exists($key, $coursesetlist) || $coursesetlist[$key]['downloadable'] == true)
                    <span class="badge badge-success mb-2">{{__("Downloadable")}}</span>
                @else
                    <span class="badge badge-danger mb-2">{{__("Not downloadable")}}</span>
                @endif

                @if(!key_exists($key, $coursesetlist) || $coursesetlist[$key]['visibility'] == true)
                    <span class="badge badge-success mb-2">{{__("Viewable")}}</span>
                @else
                    <span class="badge badge-danger mb-2">{{__("Not viewable")}}</span>
                @endif
            </h5>
        @endif
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
