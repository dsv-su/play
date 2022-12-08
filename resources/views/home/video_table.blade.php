<!-- Video - child view - will inherit all data available in the parent view-->
<div class="videotable p-0 mb-0 bg-white overflow-hidden row mx-1 w-100 border-bottom-grey d-flex align-content-center @if($video->hidden) faded @endif" id="{{$video->id}}">
    @if (!($bulk ?? false) && ($video->edit))
        <div class="pr-0 col-auto form-check d-flex align-items-center">
            <input class="form-check-input check" type="checkbox" name="bulkedit"
                   data-id="{{$video->id}}"
                   @if ($checked_videos ?? false)
                        @if(in_array($video->id, $checked_videos)) checked
                        @endif
                    @endif>
        </div>
    @endif
    <div class="col">
        <div class="row">
            <div class="col-12 @if($manageview ?? false) col-sm-6 @elseif ($bulk ?? false) col-sm-10 @else col-sm-8 @endif col-md info p-2">
                <!-- Group Permissions icons-->
                <h4 class="card-text font-1rem py-1 my-auto" style="line-height: 1.6em;">
                    @if($video->permission_type == 'dsv')
                        <span class="permission d-inline-block mx-1" data-toggle="tooltip"
                              title="{{__("DSV students & staff playback")}}">
                <i class="fas fa-users"></i>
            </span>
                    @elseif($video->permission_type == 'dsv_staff')
                        <span class="permission d-inline-block mx-1" data-toggle="tooltip"
                              title="{{__("DSV staff playback")}}">
                <i class="fas fa-house-user"></i>
            </span>
                    @elseif($video->permission_type == 'public')
                        <span class="permission d-inline-block mx-1" data-toggle="tooltip"
                              title="{{__("Public playback")}}">
                <i class="fas fa-globe"></i>
            </span>
                    @elseif($video->permission_type == 'custom')
                        <span class="permission d-inline-block mx-1" data-toggle="tooltip"
                              title="{{__("Custom playback")}}">
                <i class="fas fa-user-lock"></i>
            </span>
                    @elseif($video->permission_type == 'test')
                        <span class="permission mx-1" data-toggle="tooltip" title="{{__("Work in progress")}}">
                <i class="fas fa-wrench"></i>
            </span>
                    @endif
                    <!-- end Group Permission -->

                    <!-- Visibility icon-->
                    @if($video->hidden)
                        <span class="visibility d-inline-block mx-1" data-toggle="tooltip" title="{{__('Presentation is hidden')}}">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    @endif
                    @if($video->unlisted)
                        <span class="visibility d-inline-block mx-1" data-toggle="tooltip" title="{{__("Presentation is unlisted")}}">
                            <i class="fa-solid fa-key"></i>
                        </span>
                    @endif
                    <a href="{{ route('player', ['video' => $video]) }}" class="link">{{ $video->LangTitle }}</a>
                    <span class="badge badge-light">{{$video->duration}}</span>

                    @foreach($video->getUniqueDesignations() as $designation)
                        <a href="/designation/{{$designation}}"
                           class="badge badge-primary">{{$designation}}</a>
                    @endforeach

                    @if (!$video->presenters()->isEmpty())
                        @foreach($video->presenters() as $presenter)
                            <a href="/presenter/{{$presenter->username}}"
                               class="badge badge-light">{{$presenter->name}}</a>
                        @endforeach
                    @endif
                    @if (!$video->tags()->isEmpty())
                        @foreach($video->tags() as $tag)
                            @if (!$video->hasCourseDesignation($tag->name))
                                <a href="/tag/{{$tag->name}}" class="badge badge-secondary">{{$tag->name}}</a>
                            @endif
                        @endforeach
                    @endif
                </h4>
            </div>
            <!-- Stats -->
            @if($manageview ?? false)
                <div class="col col-sm-2 col-md-auto p-1 my-auto">
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
            <div class="col col-sm-2 col-md-auto p-1 my-auto">
                <span class="card-text text-font-size-80 font-weight-normal py-2">{{$video->getCreationDate()}}</span>
            </div>
            @if (!($bulk ?? false))
                <div class="col-auto col-sm-2 col-md-auto action p-1 d-flex justify-content-center">
                    <div class="d-flex flex-row my-auto flex-wrap action-icons">
                        <div><span data-placement="left" data-toggle="tooltip"
                                   data-title="{{__("Share presentation")}}">
                <a href="#" data-toggle="modal" data-target="#shareModal{{$video->id}}"
                   title="{{ __('Share presentation') }}" class="btn btn-sm">
                    <i class="fas fa-external-link-alt fa-fw"></i>
                </a></span>
                        </div>
                        @if ($video->download)
                            <div class="dropdown"><span data-placement="left" data-toggle="tooltip"
                                                        data-title="{{ __("Download presentation") }}">
                    <a href="#" data-toggle="modal" data-target="#downloadModal{{$video->id}}"
                       title="{{ __('Download presentation') }}" class="btn btn-sm">
                        <i class="fas fa-download fa-fw"></i>
                    </a></span>
                            </div>
                        @endif
                        @if ($video->edit)
                            <div>
                                <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip"
                                   data-placement="left"
                                   data-title="{{ __('Edit presentation') }}" class="btn btn-sm">
                                    <i class="far fa-edit fa-fw"></i>
                                </a>
                            </div>
                        @endif
                        @if ($video->delete)
                            <div>
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
            @endif
        </div>
    </div>
</div>
