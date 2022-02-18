@foreach ($videos as $key => $videocourse)
    <h3 class="col mt-4" style="line-height: 1.5em;">
        <a class="link @if ($videos->first() !== $videocourse || (isset($manage) && $manage)) collapsed @endif"
           data-toggle="collapse"
           href="#collapse{{$key}}" role="button" aria-expanded="false"
           aria-controls="collapse{{$key}}">
            <i class="fa mr-2"></i>
            @if(Lang::locale() == 'swe')
                {{\App\Course::find($key) ? \App\Course::find($key)->designation . ' ' . \App\Course::find($key)->semester.\App\Course::find($key)->year . ' — ' . \App\Course::find($key)->name : 'Okategoriserad'}}
            @else
                {{\App\Course::find($key) ? \App\Course::find($key)->designation . ' ' . \App\Course::find($key)->semester.\App\Course::find($key)->year . ' — ' . \App\Course::find($key)->name_en : 'Uncategorized'}}
            @endif
        </a>
        <span class="badge badge-light" data-toggle="tooltip" title="{{__("Number of presentations")}}">{{count($videocourse)}}</span>
        @if (isset($manage) && $manage && $key)
            @if ($individual_permissions[$key])
                <span class="badge badge-secondary mb-2" data-toggle="tooltip" title="{{__("Users with individual permissions")}}">{{$individual_permissions[$key]}} <i
                            class="fas fa-user"></i></span>
            @endif
            @if ($playback_permissions[$key])
                @switch($playback_permissions[$key]->permission_id)
                    @case(1)
                    <span class="badge badge-success mb-2" data-toggle="tooltip" title="{{ __("DSV students & staff playback") }}"><i class="fas fa-users"></i></span>
                    @break
                    @case(2)
                    <span class="badge badge-secondary mb-2" data-toggle="tooltip" title="{{__("DSV staff only playback")}}"><i class="fas fa-house-user"></i></span>
                    @break
                    @case(4)
                    <span class="badge badge-info mb-2" data-toggle="tooltip" title="{{__("Public playback")}}"><i class="fas fa-globe"></i></span>
                    @break
                    @default
                    <span class="badge badge-info mb-2" data-toggle="tooltip" title="{{__("Custom playback")}}"><i class="fas fa-user-lock"></i></span>
                @endswitch
            @else
                <span class="badge badge-success mb-2" data-toggle="tooltip" title="{{ __("DSV students & staff playback") }}"><i class="fas fa-users"></i></span>
            @endif
            <!-- If setting does not exist the download is default 'not downloadable' otherwise it is up to the download-key -->
            @if(key_exists($key, $coursesetlist) && $coursesetlist[$key]['downloadable'] == true)
                <span class="badge badge-success mb-2" data-toggle="tooltip" title="{{__("Downloadable")}}"><i class="fas fa-download"></i></span>
            @else
                <span class="badge badge-danger mb-2" data-toggle="tooltip" title="{{__("Not downloadable")}}"><i class="fas fa-download"></i></span>
            @endif
            <!-- If setting does not exist the download is default 'visible' otherwise it is up to the visibility-key -->
            @if(!key_exists($key, $coursesetlist) || $coursesetlist[$key]['visibility'] == true)
                <span class="badge badge-success" data-toggle="tooltip" title="{{__("Visible")}}"><i class="fas fa-eye"></i></span>
            @else
                <span class="badge badge-danger" data-toggle="tooltip" title="{{__("Hidden")}}"><i class="fas fa-eye-slash"></i></span>
            @endif
            @if ($key && (in_array(\App\Course::find($key)->userPermission(), ['edit', 'delete'])))
                <a class="badge badge-primary" role="button" style="max-height: 32.38px;"
                   href="{{ route('course_edit', $key) }}">{{__("Settings")}} <i class="fas fa-cog"></i></a>
            @endif
        @endif
    </h3>
    <div class="collapse @if ((isset($manage) && $manage) || $videos->first() !== $videocourse) hide @else show @endif"
         id="collapse{{$key}}">
        @if (isset($manage) && $manage)
            <h5 class="col">
                <span class="badge badge-light">{{__("Presentations")}} <span class="badge badge-secondary">{{count($videocourse)}}</span></span>
                @if ($key)
                    @if ($individual_permissions[$key])
                        <span class="badge badge-light mb-2">{{__("Individual permissions")}} <span class="badge badge-secondary">{{$individual_permissions[$key]}} <i
                                        class="fas fa-user"></i></span></span>
                    @endif
                    @if ($playback_permissions[$key])
                        @switch($playback_permissions[$key]->permission_id)
                            @case(1)
                            <span class="badge badge-light mb-2">{{ __("DSV students & staff playback") }} <span
                                        class="badge badge-success"><i class="fas fa-users"></i></span></span>
                            @break
                            @case(2)
                            <span class="badge badge-light mb-2">{{ __("DSV staff only playback") }} <span
                                        class="badge badge-secondary"><i class="fas fa-house-user"></i></span></span>
                            @break
                            @case(4)
                            <span class="badge badge-light mb-2">{{ __("Public playback") }} <span
                                        class="badge badge-info"><i class="fas fa-globe"></i></span></span>
                            @break
                            @default
                            <span class="badge badge-light mb-2">{{ __("Custom playback") }} <span
                                        class="badge badge-info"><i class="fas fa-user-lock"></i></span></span>
                        @endswitch
                    @else
                        <span class="badge badge-light mb-2">{{__("DSV students & staff playback")}} <span
                                    class="badge badge-success"><i class="fas fa-users"></i></span></span>
                    @endif
                    <!-- If setting does not exist the download is default 'not downloadable' otherwise it is up to the download-key -->
                    @if(key_exists($key, $coursesetlist) && $coursesetlist[$key]['downloadable'] == true)
                        <span class="badge badge-light mb-2">{{__("Downloadable")}} <span class="badge badge-success"><i
                                        class="fas fa-download"></i></span></span>
                    @else
                            <span class="badge badge-light mb-2">{{__("Not downloadable")}} <span class="badge badge-danger"><i class="fas fa-download"></i></span></span>
                    @endif
                    @if(!key_exists($key, $coursesetlist) || $coursesetlist[$key]['visibility'] == true)
                            <span class="badge badge-light mb-2">{{__("Visible")}} <span class="badge badge-success"><i class="fas fa-eye"></i></span></span>
                    @else
                        <span class="badge badge-light mb-2">{{__("Hidden")}} <span class="badge badge-danger"><i
                                        class="fas fa-eye-slash"></i></span></span>
                    @endif
                    @if (in_array(\App\Course::find($key)->userPermission(), ['edit', 'delete']))
                        <a class="badge badge-primary" role="button" style="max-height: 32.38px;"
                           href="{{ route('course_edit', $key) }}">{{__("Settings")}} <i class="fas fa-cog"></i></a>
                    @endif
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

@if (isset($manage) && $manage)
    <script>
        $(document).on('click', 'a.link', function (e) {
            let icons = $(this).closest('h3').find('span.badge');
            let settings = $(this).closest('h3').find('a.badge');
            icons.toggle();
            settings.toggle();
        });
    </script>
@endif
