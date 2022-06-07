<!-- Video - child view - will inherit all data available in the parent view-->
<div class="shadow p-0 mb-3 bg-white overflow-hidden rounded videolist row mx-1 w-100 @if($video->hidden) faded @endif" id="{{$video->id}}">
    <div class="col-3 px-0 my-auto">
        <a target="_blank" class="d-block w-100 h-100" rel="noopener noreferrer" @if ($video->hidden) href="#" @else href="{{ route('player', ['video' => $video]) }}" @endif>
        <div class="thumb"
         style="background-image: @if ($video->hidden) linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), @endif url({{ asset($video->thumb)}}); object-fit: contain; background-repeat: no-repeat; background-position: 50% 50%;">
            <!-- Icons -->
            <div class="icons m-1">
                <!-- Group Permissions icons-->
                @if($video->permission_type == 'dsv')
                    <div class="permission d-inline-block mx-1" data-toggle="tooltip" title="{{__("DSV students & staff playback")}}">
                        <i class="fas fa-users"></i>
                    </div>
                @elseif($video->permission_type == 'dsv_staff')
                    <div class="permission d-inline-block mx-1" data-toggle="tooltip" title="{{__("DSV staff playback")}}">
                        <i class="fas fa-house-user"></i>
                    </div>
                @elseif($video->permission_type == 'public')
                    <div class="permission d-inline-block mx-1" data-toggle="tooltip" title="{{__("Public playback")}}">
                        <i class="fas fa-globe"></i>
                    </div>
                @elseif($video->permission_type == 'custom')
                    <div class="permission d-inline-block mx-1" data-toggle="tooltip" title="{{__("Custom playback")}}">
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
                    <div class="visibility d-inline-block mx-1" data-toggle="tooltip" title="{{__('Presentation is hidden')}}">
                        <i class="fas fa-eye-slash"></i>
                    </div>
                @endif
            </div>
            <!-- Visibility banner -->
            @if ($video->hidden)
                <div class="d-flex justify-content-center h-100">
                    <div class="d-inline alert alert-secondary m-auto px-2 py-1" role="alert">{{ __("Hidden") }}</div>
                </div>
            @endif
            <p class="m-1 px-1"> {{$video->duration}} </p>

    </div>
        </a>
    </div>

    <div class="col info p-2 d-flex flex-column">
        <div>
        <h4 class="card-text font-1rem py-2 float-left">
            <a href="{{ route('player', ['video' => $video]) }}" class="link">{{ $video->LangTitle }}</a>
        </h4>
            <h4 class="card-text text-font-size-80 font-weight-normal py-2 float-right">{{$video->getCreationDate()}}</h4>
        </div>
        @if ($video->description)
            <p class="text-font-size-80">
                {{$video->description}}</p>
        @endif
        <p class="card-text text-font-size-80 mt-auto">
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

            @if (!$video->tags()->isEmpty())
                @foreach($video->tags() as $tag)
                    @if (!$video->hasCourseDesignation($tag->name))
                        <a href="/tag/{{$tag->name}}" class="badge badge-secondary">{{$tag->name}}</a>
                      @endif
                @endforeach
            @endif
        </p>
    </div>
    <!-- Stats -->
    @if($manageview ?? false)
    <div class="col-auto action p-2">
        <div class="mr-2">
             <span data-toggle="tooltip" data-placement="left" data-title="{{__("Number of Clicks")}}">
                <a href="{{route('stats', $video->id)}}" type="button" class="btn btn-sm">
                    <span style="color: Tomato;"><i class="fa-solid fa-chart-column"></i></span>
                    @if($stats_playback[$video->id] ?? false)
                        {{$stats_playback[$video->id]}}
                    @else
                        0
                    @endif
                </a>
            </span>
            <span data-toggle="tooltip" data-placement="left" data-title="{{__("Number of Downloads")}}">
                <a href="{{route('stats', $video->id)}}" type="button" class="btn btn-sm">
                    <span style="color: #007bff;"><i class="fa-solid fa-download"></i></span>
                    @if($stats_download[$video->id] ?? false)
                        {{$stats_download[$video->id]}}
                    @else
                        0
                    @endif
                </a>
            </span>
        </div>
    </div>
    @endif
    <div class="col-auto action p-2">
        <div class="flex-column list-action-icons">
            <div class="my-1"><span data-placement="left" data-toggle="tooltip" data-title="{{__("Share presentation")}}">
                <a href="#" data-toggle="modal" data-target="#shareModal{{$video->id}}"
                   title="{{ __('Share presentation') }}" class="btn btn-sm">
                    <i class="fas fa-external-link-alt fa-fw"></i>
                </a></span>
            </div>
            @if ($video->download)
                <div class="dropdown my-1"><span data-placement="left" data-toggle="tooltip" data-title="{{ __("Download presentation") }}">
                    <a href="#" data-toggle="modal" data-target="#downloadModal{{$video->id}}"
                       data-title="{{ __('Download presentation') }}" class="btn btn-sm">
                        <i class="fas fa-download fa-fw"></i>
                    </a></span>
                </div>
            @endif
            @if ($video->edit)
                <div class="my-1">
                    <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip" data-placement="left"
                       data-title="{{ __('Edit presentation') }}" class="btn btn-sm">
                        <i class="far fa-edit fa-fw"></i>
                    </a>
                </div>
            @endif
            @if ($video->delete)
                <div class="my-1">
                <span data-toggle="tooltip" data-placement="left" data-title="{{__("Delete presentation")}}">
                    <a type="button" class="btn btn-sm" data-toggle="modal"
                       data-target="#deleteModal{{$video->id}}">
                        <i class="far fa-trash-alt fa-fw"></i>
                    </a>
                </span>
                </div>
            @endif
        </div>
    </div>
</div>