<div class="d-inline-block">
    <h5 class="col">
        <span class="badge badge-light">{{__("Presentations")}} <span
                    class="badge badge-primary">{{$counter[$video_course->course->id]}}</span>
            <span class="badge badge-primary">
        <a target="_blank" rel="noopener noreferrer" class="text-decoration-none"
           href="{{route('playCourse', ['course' => $video_course->course->id]) }}" style="color: white;">{{__("Play all")}}<i
                    class="fa-solid fa-play ml-1"></i></a></span>
        </span>

        @if ($individual_permissions[$video_course->course->id])
            <span class="badge badge-light mb-2">{{__("Individual permissions")}} <span
                        class="badge badge-secondary">{{$individual_permissions[$video_course->course->id]}} <i
                            class="fas fa-user"></i></span></span>
        @endif
        @if ($playback_permissions[$video_course->course->id])
            @switch($playback_permissions[$video_course->course->id]->permission_id)
                @case(1)
                <span class="badge badge-light mb-2">{{ __("DSV students & staff playback") }} <span
                            class="badge badge-success"><i class="fas fa-users"></i></span></span>
                @break
                @case(2)
                <span class="badge badge-light mb-2">{{ __("DSV staff only playback") }} <span
                            class="badge badge-secondary"><i
                                class="fas fa-house-user"></i></span></span>
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
        @if(key_exists($video_course->course->id, $coursesetlist) && $coursesetlist[$video_course->course->id]['downloadable'] == true)
            <span class="badge badge-light mb-2">{{__("Downloadable")}} <span class="badge badge-success"><i
                            class="fas fa-download"></i></span></span>
        @else
            <span class="badge badge-light mb-2">{{__("Not downloadable")}} <span
                        class="badge badge-danger"><i class="fas fa-download"></i></span></span>
        @endif
        @if(!key_exists($video_course->course->id, $coursesetlist) || $coursesetlist[$video_course->course->id]['visibility'] == true)
            <span class="badge badge-light mb-2">{{__("Visible")}} <span class="badge badge-success"><i
                            class="fas fa-eye"></i></span></span>
        @else
            <span class="badge badge-light mb-2">{{__("Hidden")}} <span class="badge badge-danger"><i
                            class="fas fa-eye-slash"></i></span></span>
        @endif
        @if ($video_course->course->id && (in_array(\App\Course::find($video_course->course->id)->userPermission(), ['edit', 'delete'])))
            <a class="badge badge-primary" role="button" style="max-height: 32.38px;"
               href="{{ route('course_edit', $video_course->course->id) }}">{{__("Settings")}} <i class="fas fa-cog"></i></a>
        @endif

    </h5>
</div>
