<!-- Video - child view - will inherit all data available in the parent view-->
@if($view ?? false)
    @if (!($bulk ?? false) && ($video->edit))
        <div class="pr-0 col-auto form-check d-flex align-items-center">
            <div data-placement="top" data-toggle="tooltip" data-title="{{__("Select for bulkedit")}}">
                <label class="form-control-label px-1">{{__("Select")}}</label>
            </div>
            <input class="form-check-input check" type="checkbox" name="bulkedit"
                   data-id="{{$video->id}}"
                   @if ($checked_videos ?? false)
                        @if(in_array($video->id, $checked_videos)) checked
                        @endif
                   @endif>
        </div>
    @else
        <div class="pr-0 col-auto form-check d-flex align-items-center">
            <div>
                <label class="form-control-label px-1"> </label>
            </div>
        </div>
    @endif
@endif
<div wire:ignore class="shadow-lg shadow-warning card video m-auto @if($video->hidden) faded @endif" id="{{$video->id}}">
    <div class="flex-column m-1 action-icons">
       <div data-placement="left" data-toggle="tooltip" data-title="{{__("Share presentation")}}">
            <a href="#" data-toggle="modal" data-target="#shareModal{{$video->id}}"
               title="{{ __('Share presentation') }}" class="btn btn-dark btn-sm">
                <i class="fas fa-external-link-alt fa-fw"></i>
            </a>
        </div>
        @if ($video->download and $video->state)
            <div class="dropdown" data-placement="left" data-toggle="tooltip" title="{{ __("Download presentation") }}">
                <a href="#" data-toggle="modal" data-target="#downloadModal{{$video->id}}"
                   data-title="{{ __('Download presentation') }}" class="btn btn-dark btn-sm">
                    <i class="fas fa-download fa-fw"></i>
                </a>
            </div>
        @endif
        @if ($video->edit and $video->state)
            <div>
                <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip" data-placement="left"
                   data-title="{{ __('Edit presentation') }}" class="btn btn-dark btn-sm">
                    <i class="far fa-edit fa-fw"></i>
                </a>
            </div>
        @endif
        @if ($video->delete and $video->state)
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
             style="background-image: @if ($video->hidden) linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), @endif url({{ asset($video->thumb . '?'. time())}}); width: 100%; height: 0; object-fit: cover; background-repeat: no-repeat; background-position: 50% 50%;">
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

                <!-- Visibility icons-->
                @if($video->hidden && $video->unlisted == false)
                    <div class="visibility mx-1" data-toggle="tooltip" title="{{__("Presentation is private")}}">
                        <i class="fas fa-eye-slash"></i>
                    </div>
                @endif
                @if($video->unlisted)
                    <div class="visibility mx-1" data-toggle="tooltip" title="{{__("Presentation is unlisted")}}">
                        <i class="fa-solid fa-key"></i>
                    </div>
                @endif
                <!-- CC -->
                @if(json_decode($video->subtitles))
                    <div class="visibility mx-1" data-toggle="tooltip" title="{{__("Subtitles")}}">
                        <i class="fa-regular fa-closed-captioning"></i>
                    </div>
                @endif
            </div>
            <!-- Visibility banner -->
            @if ($video->hidden)
                <div class="d-flex justify-content-center h-100">
                    <div class="d-inline alert alert-secondary m-auto" role="alert">{{ __("Private") }}</div>
                </div>
            {{--}}
            @else
            <!-- Play icon -->
            <div class="d-flex justify-content-center h-100">
                <div class="d-inline alert m-auto">
                    <!--<i class="fa-regular fa-circle-play fa-3x play-icon"></i>-->
                    <i class="fa-solid fa-play fa-3x play-icon"></i>
                </div>
            </div>
            {{--}}
            @endif
            @if ($video->unlisted)
                <div class="d-flex justify-content-center h-100">
                    <div class="d-inline alert alert-secondary m-auto" role="alert">{{ __("Unlisted") }}</div>
                </div>
            @endif
            @if (!$video->state)
                <div class="d-flex justify-content-center h-100">
                    <div class="d-inline alert alert-secondary m-auto" role="alert">{{ __("Processing") }}</div>
                </div>
            @endif
            <p class="m-1 px-1"> {{$video->duration}} </p>
        </div>
    </a>

    <div class="card-body p-1 overflow-hidden">
        <div class="d-flex align-items-start">
            <div class="">
                <h4 class="card-text font-1rem px-1 py-2">
                    <div data-placement="auto" data-toggle="tooltip" data-title="{{$video->LangTitle}}">
                        <a target="_blank" rel="noopener noreferrer" href="{{ route('player', ['video' => $video]) }}" class="link">{{ Str::limit($video->LangTitle, 27) }}</a>
                    </div>

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


        <p class="card-text">
            <!-- Designations -->
            @if (!$video->courses()->isEmpty())
                @foreach($video->getUniqueDesignations() as $designation)
                    <a href="/designation/{{$designation}}" class="badge badge-primary">{{$designation}}</a>
                @endforeach
            @endif

            <!-- Study Admin Category -->
            @if (!$video->courses()->isEmpty() && $video->getUniqueStudyAdminCat())
                @foreach($video->getUniqueStudyAdminCat() as $cat)
                    <a href="/category/Studieadmin" class="badge badge-success">{{__("STUDYINFO")}}</a>
                @endforeach
            @elseif ($video->category->category_name == 'Studieadmin')
                <a href="/category/Studieadmin" class="badge badge-success">{{__("STUDYINFO")}}</a>
            @endif

            <!-- Nextilearn Category -->
            <!-- Study Admin Category -->
            @if (!$video->courses()->isEmpty() && $video->getUniqueNextilearnCat())
                @foreach($video->getUniqueNextilearnCat() as $cat)
                    <a href="/category/Nextilearn" class="badge badge-success">{{__("NEXTilearn")}}</a>
                @endforeach
            @elseif ($video->category->category_name == 'Nextilearn')
                <a href="/category/Nextilearn" class="badge badge-success">{{__("NEXTilearn")}}</a>
            @endif

            <!-- Presenters -->
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
                    <a {{--}}href="{{route('stats', $video->id)}}" {{--}} href="#" type="button" class="btn btn-sm px-1">
                        <span style="color: Tomato;"><i class="fa-solid fa-chart-column"></i></span>
                        @if($stats_playback[$video->id] ?? false)
                            {{$stats_playback[$video->id]}}
                        @else
                            0
                        @endif
                    </a>
                </span>
                <span data-toggle="tooltip" data-placement="left" data-title="{{__("Number of Downloads")}}">
                    <a {{--}} href="{{route('stats', $video->id)}}" {{--}} href="#" type="button" class="btn btn-sm px-1">
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

