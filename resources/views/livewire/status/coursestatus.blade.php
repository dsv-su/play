<div class="d-inline-block">
    <span class="badge badge-primary ml-2 mb-2"><span data-toggle="tooltip"
          data-title="{{__("Number of presentations")}}">{{$counter[$video_course->course->id]}}</span>
                    <a target="_blank" rel="noopener noreferrer"
                       href="{{route('playCourse', ['course' => $video_course->course->id]) }}" data-toggle="tooltip"
                       title="{{__("Play all")}}" style="color: white;"><i
                                class="fa-solid fa-play ml-1"></i></a></span>
    <fieldset class="form-group border border-primary p-2 d-inline-block">
        <legend class="w-auto px-2 small">{{__('Default settings')}}</legend>
        @if ($individual_permissions[$video_course->course->id])
            <span class="badge badge-secondary mb-2" data-toggle="tooltip"
                  data-title="{{__("Users with individual permissions")}}">{{$individual_permissions[$video_course->course->id]}} <i
                    class="fas fa-user"></i></span>
        @endif
        @if ($playback_permissions[$video_course->course->id])
            @switch($playback_permissions[$video_course->course->id]->permission_id)
                @case(1)
                <span class="badge badge-success mb-2" data-toggle="tooltip"
                      data-title="{{ __("DSV students & staff playback") }}"><i class="fas fa-users"></i></span>
                @break
                @case(2)
                <span class="badge badge-secondary mb-2" data-toggle="tooltip"
                      data-title="{{__("DSV staff only playback")}}"><i class="fas fa-house-user"></i></span>
                @break
                @case(4)
                <span class="badge badge-info mb-2" data-toggle="tooltip" data-title="{{__("Public playback")}}"><i
                        class="fas fa-globe"></i></span>
                @break
                @default
                <span class="badge badge-info mb-2" data-toggle="tooltip" data-title="{{__("Custom playback")}}"><i
                        class="fas fa-user-lock"></i></span>
            @endswitch
        @else
            <span class="badge badge-success mb-2" data-toggle="tooltip"
                  data-title="{{ __("DSV students & staff playback") }}"><i class="fas fa-users"></i></span>
        @endif

    <!-- Downloadability -->
        @if(key_exists($video_course->course->id, $coursesetlist) && $coursesetlist[$video_course->course->id]['downloadable'] == true)
            <span class="badge badge-success mb-2" data-toggle="tooltip" data-title="{{__("Downloadable")}}"><i
                    class="fas fa-download"></i></span>
        @else
            <span class="badge badge-danger mb-2" data-toggle="tooltip" data-title="{{__("Not downloadable")}}"><i
                    class="fas fa-download"></i></span>
        @endif
    <!-- Visibility -->
        @if(!key_exists($video_course->course->id, $coursesetlist) || $coursesetlist[$video_course->course->id]['visibility'] == true)
            <span class="badge badge-success" data-toggle="tooltip" data-title="{{__("Visible")}}"><i
                    class="fas fa-eye"></i></span>
        @else
            <span class="badge badge-danger" data-toggle="tooltip" data-title="{{__("Hidden")}}"><i class="fas fa-eye-slash"></i></span>
        @endif
    </fieldset>
    <!-- Course Settings button -->
        @if($admin)
        <a class="badge badge-primary" role="button" style="max-height: 32.38px;" data-toggle="tooltip" data-title="{{__("Course settings")}}"
           href="{{ route('course_edit', $video_course->course->id) }}">{{__("Settings")}} <i
                class="fas fa-cog"></i></a>
        @else
            @if ($video_course->course->id && (in_array(\App\Course::find($video_course->course->id)->userPermission(), ['edit', 'delete'])))
                <a class="badge badge-primary" role="button" style="max-height: 32.38px;" data-toggle="tooltip" data-title="{{__("Course settings")}}"
                   href="{{ route('course_edit', $video_course->course->id) }}">{{__("Settings")}} <i
                        class="fas fa-cog"></i></a>
            @endif
        @endif



</div>
