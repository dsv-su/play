<span class="badge badge-primary ml-2 mb-2" data-toggle="tooltip" title="{{__("Number of presentations")}}">{{$counter[$video_course->course->id]}}</span>

@if ($individual_permissions[$video_course->course->id])
    <span class="badge badge-secondary mb-2" data-toggle="tooltip"
          title="{{__("Users with individual permissions")}}">{{$individual_permissions[$video_course->course->id]}} <i
            class="fas fa-user"></i></span>
@endif
@if ($playback_permissions[$video_course->course->id])
    @switch($playback_permissions[$video_course->course->id]->permission_id)
        @case(1)
        <span class="badge badge-success mb-2" data-toggle="tooltip"
              title="{{ __("DSV students & staff playback") }}"><i class="fas fa-users"></i></span>
        @break
        @case(2)
        <span class="badge badge-secondary mb-2" data-toggle="tooltip"
              title="{{__("DSV staff only playback")}}"><i class="fas fa-house-user"></i></span>
        @break
        @case(4)
        <span class="badge badge-info mb-2" data-toggle="tooltip" title="{{__("Public playback")}}"><i
                class="fas fa-globe"></i></span>
        @break
        @default
        <span class="badge badge-info mb-2" data-toggle="tooltip" title="{{__("Custom playback")}}"><i
                class="fas fa-user-lock"></i></span>
    @endswitch
@else
    <span class="badge badge-success mb-2" data-toggle="tooltip"
          title="{{ __("DSV students & staff playback") }}"><i class="fas fa-users"></i></span>
@endif

<!-- Downloadability -->
@if(key_exists($video_course->course->id, $coursesetlist) && $coursesetlist[$video_course->course->id]['downloadable'] == true)
    <span class="badge badge-success mb-2" data-toggle="tooltip" title="{{__("Downloadable")}}"><i class="fas fa-download"></i></span>
@else
    <span class="badge badge-danger mb-2" data-toggle="tooltip" title="{{__("Not downloadable")}}"><i class="fas fa-download"></i></span>
@endif
<!-- Visibility -->
@if(!key_exists($video_course->course->id, $coursesetlist) || $coursesetlist[$video_course->course->id]['visibility'] == true)
    <span class="badge badge-success" data-toggle="tooltip" title="{{__("Visible")}}"><i class="fas fa-eye"></i></span>
@else
    <span class="badge badge-danger" data-toggle="tooltip" title="{{__("Hidden")}}"><i class="fas fa-eye-slash"></i></span>
@endif
<!-- Course Settings button -->
@if ($video_course->course->id && (in_array(\App\Course::find($video_course->course->id)->userPermission(), ['edit', 'delete'])))
    <a class="badge badge-primary" role="button" style="max-height: 32.38px;"
       href="{{ route('course_edit', $video_course->course->id) }}">{{__("Settings")}} <i class="fas fa-cog"></i></a>
@endif


