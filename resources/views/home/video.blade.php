<!-- Video - child view - will inherit all data available in the parent view-->
<div class="card video m-auto" @if (isset($manage) && $manage) id="{{$video->id}}" @endif>
    @if ($video->visability)
        <a href="{{ route('player', ['video' => $video]) }}">
    @endif

        <!--   Visibility: Individual presentation setting -> $video->visability, Course (bulk) settings -> $video->visibility_setting -->

        <div class="card-header position-relative"
             style="background-image: @if ($video->visability == false or $video->visibility_setting == false) linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), @endif url({{ asset($video->thumb)}}); height:200px;">
            <div class="title">{{ $video->title }}</div>
            <!-- Group Permissions -->
            <div class="icons">
                @foreach($video->status as $permission)

                    @if($permission->type == 'private')
                        <div class="permission mx-1" data-toggle="tooltip"
                             title="{{__('Viewing permissions modified')}}"><i class="fas fa-user-lock"></i></div>
                    @endif
                    @if($permission->type == 'external')
                        <div class="permission mx-1" data-toggle="tooltip" title="{{__('External access enabled')}}"><i
                                    class="fas fa-globe"></i></div>
                    @endif
                @endforeach
            <!-- end Group Permission -->

                <!-- Visability -->
                @if($video->visability == false or $video->visibility_setting == false)
                    <div class="visability mx-1" data-toggle="tooltip" title="{{__('Presentation is hidden')}}"><i
                                class="far fa-eye-slash"></i></div>
                @endif
            </div>
            @if ($video->visability == false or $video->visibility_setting == false)
                <div class="d-flex justify-content-center h-100">
                    <div class="d-inline alert alert-secondary m-auto"
                         role="alert">{{ __("Presentation hidden") }}</div>
                </div>
            @endif
            <p class="p-1"> {{$video->duration}} </p>
        </div>
    @if ($video->visability)
        </a>
    @endif
    <div class="card-body p-1 overflow-hidden">
        <!-- While testing we need id -->
        @if (!$video->video_course->isEmpty())
            <p class="card-text">
                @foreach($video->video_course as $vc)
                    <a href="/designation/{{\App\Course::find($vc->course_id)->designation}}"
                       class="badge badge-primary">{{\App\Course::find($vc->course_id)->designation}}</a>
                @endforeach
            </p>
        @endif
        @if (!$video->presenters()->isEmpty())
            <p class="card-text">
                @foreach($video->presenters() as $presenter)
                    <a href="/presenter/{{$presenter->username}}" class="badge badge-light">{{$presenter->name}}</a>
                @endforeach
            </p>
        @endif
        @if (!$video->tags()->isEmpty())
            <p class="card-text" id="tags">
                @foreach($video->tags() as $tag)
                    <a href="/tag/{{$tag->name}}" class="badge badge-secondary">{{$tag->name}}</a>
                @endforeach
            </p>
        @endif
        <div class="d-flex float-right clearfix">
            @if ($video->visability)
                <div class="ml-1" data-toggle="tooltip" title="{{__("Share presentation")}}">
                    <a href="#" data-toggle="modal" data-target="#shareModal{{$video->id}}"
                       title="{{ __('Share presentation') }}" class="btn btn-outline-secondary btn-sm"><i
                                class="fas fa-external-link-alt"></i></a>
                </div>
                @if ($video->download or $video->download_setting)
                    <div class="dropdown ml-1" data-toggle="tooltip" data-placement="top"
                         title="{{ __("Download presentation") }}">
                        <a class="btn btn-outline-success btn-sm" href="#" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-download"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <form method="post" action="{{route('download', $video->id)}}">
                                @csrf
                                @foreach(json_decode($video->sources, true) as $source)
                                    @if(is_array($source['video']) && $loop->first)
                                        @foreach($source['video'] as $key => $source)
                                            <button class="dropdown-item btn btn-outline-primary btn-sm" name="res"
                                                    value="{{$key}}"><i class="fas fa-download"></i>
                                                {{$key}}p
                                            </button>
                                        @endforeach
                                    @elseif($loop->first)
                                        <button class="dropdown-item btn btn-outline-primary btn-sm" name="res"
                                                value="999">
                                            <i class="fas fa-download"></i> 720p
                                        </button>
                                    @endif
                                @endforeach
                            </form>
                        </div>
                    </div>
                @endif
            @endif
            @if (isset($manage) && $manage)
                @if ($video->editable() or $video->edit_setting)
                    <div class="ml-1">
                        <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip"
                           title="{{ __('Edit presentation') }}" class="btn btn-outline-info btn-sm"><i
                                    class="far fa-edit"></i></a>
                    </div>
                @endif
                @if ($video->deletable() or $video->delete_setting)
                    <div class="ml-1">
                        <form>
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <a href="#" data-toggle="tooltip" title="{{ __("Delete presentation") }}"
                               class="btn btn-outline-danger btn-sm delete"><i
                                        class="far fa-trash-alt"></i></a>
                        </form>
                    </div>
                @endif
            @endif
        </div>
        @if ($video->description)
            <p class="m-1 line-1rem text-shrink"><small>{{$video->description}}</small></p>
        @endif
        @if (!App::environment('production'))
            <p class="mx-1 my-0 d-inline-block"><small>id: {{$video->id}}</small></p>
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
