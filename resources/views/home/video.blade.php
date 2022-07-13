<!-- Video - child view - will inherit all data available in the parent view-->
<div class="shadow-lg shadow-warning card video m-auto @if($video->hidden) faded @endif" id="{{$video->id}}">
    <div class="flex-column m-1 action-icons">
        <div data-placement="left" data-toggle="tooltip" data-title="{{__("Share presentation")}}">
            <a href="#" data-toggle="modal" data-target="#shareModal{{$video->id}}"
               title="{{ __('Share presentation') }}" class="btn btn-dark btn-sm">
                <i class="fas fa-external-link-alt fa-fw"></i>
            </a>
        </div>
        @if ($video->download)
            <div class="dropdown" data-placement="left" data-toggle="tooltip" title="{{ __("Download presentation") }}">
                <a href="#" data-toggle="modal" data-target="#downloadModal{{$video->id}}"
                   data-title="{{ __('Download presentation') }}" class="btn btn-dark btn-sm">
                    <i class="fas fa-download fa-fw"></i>
                </a>
            </div>
        @endif
        @if ($video->edit)
            <div>
                <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip" data-placement="left"
                   data-title="{{ __('Edit presentation') }}" class="btn btn-dark btn-sm">
                    <i class="far fa-edit fa-fw"></i>
                </a>
            </div>
        @endif
        @if ($video->delete)
            <div>
                <span data-toggle="tooltip" data-placement="left" data-title="{{__("Delete presentation")}}">
                    <a type="button" class="btn btn-dark btn-sm" data-toggle="modal"
                       data-target="#deleteModal{{$video->id}}">
                        <i class="far fa-trash-alt fa-fw"></i>
                    </a>
                </span>
            </div>
        @endif
    </div>
    <a target="_blank" rel="noopener noreferrer" href="{{ route('player', ['video' => $video]) }}">
        <div class="card-header position-relative"
             style="background-image: @if ($video->hidden) linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), @endif url({{ asset($video->thumb)}}); width: 100%; height: 0px; object-fit: cover; background-repeat: no-repeat; background-position: 50% 50%;">
            <!-- Icons -->
            <div class="icons m-1">
                <!-- Group Permissions icons-->
                @if($video->permission_type == 'dsv')
                    <div class="permission mx-1" data-toggle="tooltip" title="{{__("DSV students & staff playback")}}">
                        <i class="fas fa-users"></i>
                    </div>
                @elseif($video->permission_type == 'dsv_staff')
                    <div class="permission mx-1" data-toggle="tooltip" title="{{__("DSV staff playback")}}">
                        <i class="fas fa-house-user"></i>
                    </div>
                @elseif($video->permission_type == 'public')
                    <div class="permission mx-1" data-toggle="tooltip" title="{{__("Public playback")}}">
                        <i class="fas fa-globe"></i>
                    </div>
                @elseif($video->permission_type == 'custom')
                    <div class="permission mx-1" data-toggle="tooltip" title="{{__("Custom playback")}}">
                        <i class="fas fa-user-lock"></i>
                    </div>
                @elseif($video->permission_type == 'test')
                    <div class="permission mx-1" data-toggle="tooltip" title="{{__("Work in progress")}}">
                        <i class="fas fa-wrench"></i>
                    </div>
                @endif
                <!-- end Group Permission -->

                <!-- Visibility icon-->
                @if($video->hidden)
                    <div class="visibility mx-1" data-toggle="tooltip" title="{{__('Presentation is hidden')}}">
                        <i class="fas fa-eye-slash"></i>
                    </div>
                @endif
            </div>
            <!-- Visibility banner -->
            @if ($video->hidden)
                <div class="d-flex justify-content-center h-100">
                    <div class="d-inline alert alert-secondary m-auto" role="alert">{{ __("Hidden") }}</div>
                </div>
            @endif
            <p class="m-1 px-1"> {{$video->duration}} </p>
        </div>
    </a>

    <div class="card-body p-1 overflow-hidden">
        <div class="d-flex align-items-start">
            <div class="">
                <h4 class="card-text font-1rem px-1 py-2">
                    <a href="{{ route('player', ['video' => $video]) }}" class="link">{{ $video->LangTitle }}</a>
                </h4>
            </div>
            @if ($video->description)
                <div class="ml-auto showmore">
                    <a tabindex="0" class="btn btn-sm" role="button" data-toggle="popover"
                       data-trigger="focus"
                       data-original-title="{{__("Description")}}"
                       data-placement="bottom"
                       data-content="{{$video->description}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>

        <!-- While testing we need id -->
        <p class="card-text">
            @if (!$video->video_course->isEmpty())
                @foreach($video->video_course as $vc)
                    <a href="/designation/{{\App\Course::find($vc->course_id)->designation}}"
                       class="badge badge-primary">{{\App\Course::find($vc->course_id)->designation}}</a>
                @endforeach
            @endif

            @if (!$video->presenters()->isEmpty())
                @foreach($video->presenters() as $presenter)
                    <a href="/presenter/{{$presenter->username}}" class="badge badge-light">{{$presenter->name}}</a>
                @endforeach
            @endif
            {{--}}
            <!-- Hide tags -->
        @if (!$video->tags()->isEmpty())
            @foreach($video->tags() as $tag)
                                @if (!$video->hasCourseDesignation($tag->name))
                <a href="/tag/{{$tag->name}}" class="badge badge-secondary">{{$tag->name}}</a>
                @endif
            @endforeach
        @endif
            <!---->
            {{--}}
        </p>
        <!-- Stats -->
        @if($manageview ?? false)
            <div class="text-right">
     <span data-toggle="tooltip" data-placement="left" data-title="{{__("Number of Clicks")}}">
        <a href="{{route('stats', $video->id)}}" type="button" class="btn btn-sm px-1">
            <span style="color: Tomato;"><i class="fa-solid fa-chart-column"></i></span>
            @if($stats_playback[$video->id] ?? false)
                {{$stats_playback[$video->id]}}
            @else
                0
            @endif
        </a>
    </span>
                <span data-toggle="tooltip" data-placement="left" data-title="{{__("Number of Downloads")}}">
        <a href="{{route('stats', $video->id)}}" type="button" class="btn btn-sm px-1">
            <span style="color: #007bff;"><i class="fa-solid fa-download"></i></span>
            @if($stats_download[$video->id] ?? false)
                {{$stats_download[$video->id]}}
            @else
                0
            @endif
        </a>
    </span>
            </div>
        @endif
    </div>
</div>
