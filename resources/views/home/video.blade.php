<!-- Video - child view - will inherit all data available in the parent view-->
<div class="card video m-auto @if($video->visability == false && $video->visibility_setting == false) faded @endif" @if (isset($manage) && $manage) id="{{$video->id}}" @endif>
    <div id="action-icons" class="flex-column m-1">
        @if ($video->visability == false && $video->visibility_setting == false)
            @if ($video->editable())
            <div class="mb-1" data-placement="left" data-toggle="tooltip" title="{{__("Share presentation")}}">
                <a href="#" data-toggle="modal" data-target="#shareModal{{$video->id}}"
                   title="{{ __('Share presentation') }}" class="btn btn-dark btn-sm"><i
                            class="fas fa-external-link-alt fa-fw"></i></a>
            </div>
            @endif
            @if ($video->download or $video->download_setting)
                <div class="dropdown mb-1" data-placement="left" data-toggle="tooltip"
                     title="{{ __("Download presentation") }}">
                    <a href="#" data-toggle="modal" data-target="#downloadModal{{$video->id}}"
                       title="{{ __('Download presentation') }}" class="btn btn-dark btn-sm"><i
                                class="fas fa-download fa-fw"></i></a>
                </div>
            @endif
        @endif
        @if (isset($manage) && $manage or (isset($manage) && $manage and app()->make('play_role') == 'Administrator'))
            @if ($video->editable() or $video->edit_setting)
                <div class="mb-1">
                    <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip" data-placement="left"
                       title="{{ __('Edit presentation') }}" class="btn btn-dark btn-sm"><i
                                class="far fa-edit fa-fw"></i></a>
                </div>
            @endif
            @if ($video->deletable() or $video->delete_setting)
                <div class="mb-1">
                    <form>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <a href="#" data-toggle="tooltip" data-placement="left"
                           title="{{ __("Delete presentation") }}"
                           class="btn btn-dark btn-sm delete"><i
                                    class="far fa-trash-alt fa-fw"></i></a>
                    </form>
                </div>
            @endif
        @endif
    </div>
    <a href="{{ route('player', ['video' => $video]) }}">

        <!--   Visibility: Individual presentation setting -> $video->visability, Course (bulk) settings -> $video->visibility_setting -->

        <div class="card-header position-relative"
             style="background-image: @if ($video->visability == false or $video->visibility_setting == false) linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), @endif url({{ asset($video->thumb)}}); height:200px;">
            <!-- Group Permissions -->
            <div class="icons m-1">
                @foreach($video->status as $permission)
                    @if($permission->type == 'private' or $video->private_setting)
                        <div class="permission mx-1" data-toggle="tooltip"
                             title="{{__('Viewing permissions modified')}}"><i class="fas fa-user-lock"></i></div>
                    @endif
                    @if($permission->type == 'external' or $video->external_setting)
                        <div class="permission mx-1" data-toggle="tooltip"
                             title="{{__('External access enabled')}}"><i
                                    class="fas fa-globe"></i></div>
                    @endif
                @endforeach
            <!-- end Group Permission -->

                <!-- Visability -->
                @if($video->visability == false or $video->visibility_setting == false)
                    <div class="visability mx-1" data-toggle="tooltip" title="{{__('Presentation is hidden')}}"><i
                                class="fas fa-eye-slash"></i></div>
                @endif
            </div>
            @if ($video->visability == false or $video->visibility_setting == false)
                <div class="d-flex justify-content-center h-100">
                    <div class="d-inline alert alert-secondary m-auto"
                         role="alert">{{ __("Presentation hidden") }}</div>
                </div>
            @endif
            <p class="m-1 px-1"> {{$video->duration}} </p>
        </div>
        @if ($video->visability == false && $video->visibility_setting == false)
    </a>
    @endif
    <div class="card-body p-1 overflow-hidden">
        <div class="d-flex align-items-start">
            <div class=""><h4 class="card-text font-1rem font-weight-bold px-1 py-2"><a
                            href="{{ route('player', ['video' => $video]) }}" class="link">{{ $video->title }}</a></h4>
            </div>
            @if ($video->description)
                <div class="ml-auto" id="showmore">
                    <a tabindex="0" class="btn btn-sm" role="button" data-toggle="popover"
                       data-trigger="focus"
                       data-original-title="Description"
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
            @if (!$video->tags()->isEmpty())
                @foreach($video->tags() as $tag)
                    <a href="/tag/{{$tag->name}}" class="badge badge-secondary">{{$tag->name}}</a>
                @endforeach
            @endif
        </p>

    <!-- Remove description for now
        @if ($video->description)
        <p class="m-1 line-1rem text-shrink"><small>{{$video->description}}</small></p>
        @endif
            -->
        @if (!App::environment('production'))
            <!--<p class="mx-1 my-0 d-inline-block"><small>id: {{$video->id}}</small></p>-->
        @endif
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="shareModal{{$video->id}}" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">{{__("Share a presentation")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="staticLink">{{__("Direct link")}}</label>
                {{--}}<textarea readonly class="form-control" id="staticLink"
                          value="">{{ route('player', ['video' => $video]) }}</textarea>{{--}}
                <!-- Enables public access for links -->
                    <textarea readonly class="form-control" id="staticLink"
                              value="">{{url("/multiplayer?p={$video->id}")}} </textarea>
                    <small id="staticLinkHelp"
                           class="form-text text-muted">{{ __("Permalink to this presentation") }}</small>
                </div>
                <div class="form-group">
                    <label for="embedCode">{{__("Embed code")}}</label>
                    <textarea readonly class="form-control text-muted" rows="4" id="embedCode"><iframe width="560" height="315" src="{{ route('player', ['video' => $video]) }}" frameborder="0" allowfullscreen></iframe></textarea>
                    {{--}}<textarea readonly class="form-control text-muted" rows="4" id="embedCode"><iframe width="560" height="315" src="{{url("/multiplayer?p={$video->id}")}}" frameborder="0" allowfullscreen></iframe></textarea>{{--}}
                    <small id="embbedCodeHelp"
                           class="form-text text-muted">{{ __("Use this embed code to insert the video in e.g. iLearn") }}</small>
                </div>
                <div class="form-group">
                    <label for="permissions">{{__("Permissions")}}
                        @if ($video->editable())
                            <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip"
                               title="{{ __('Edit presentation') }}" class="btn btn-info btn-sm">{{__('Edit')}} <i
                                        class="far fa-edit"></i></a>
                        @endif</label>
                    <p class="font-1rem">
                        @foreach ($video->permissions() as $permission)
                            <span class="d-block">{{$permission->scope}}</span>
                        @endforeach
                    </p>
                    <p class="font-1rem">
                        @foreach($video->coursepermissions as $cpermission)
                            <span class="d-block">{{$cpermission->name}} ({{$cpermission->username}}): <span
                                        class="text-capitalize badge badge-light">{{__('Manager')}}</span></span>
                        @endforeach
                        @foreach ($video->ipermissions as $ipermission)
                            <span class="d-block">{{$ipermission->name}} ({{$ipermission->username}}): <span
                                        class="text-capitalize badge badge-light">{{$ipermission->permission}}</span></span>
                        @endforeach
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- -->
<div class="modal fade" id="downloadModal{{$video->id}}" tabindex="-1" role="dialog"
     aria-labelledby="downloadModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">{{__("Download presentation")}}
                    <strong>{{$video->title}}</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="staticLink">{{__("Choose a resolution")}}</label>
                    {{--}}<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">{{--}}
                    <div class="dropdown">
                        <form method="post" action="{{route('download', $video)}}">
                            @csrf
                            @foreach(json_decode($video->sources, true) as $source)
                                @if(is_array($source['video']) && $loop->first)
                                    @foreach($source['video'] as $key => $source)
                                        <button class="btn btn-outline-primary btn-sm" name="res"
                                                value="{{$key}}"><i class="fas fa-download"></i>
                                            {{$key}}p
                                        </button>
                                    @endforeach
                                @elseif($loop->first)
                                    <button class="btn btn-outline-primary btn-sm" name="res"
                                            value="999">
                                        <i class="fas fa-download"></i> 720p
                                    </button>
                                @endif
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("Close")}}</button>
            </div>
        </div>
    </div>
</div>
