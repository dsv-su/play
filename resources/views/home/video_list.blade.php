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
        <h4 class="card-text font-1rem font-weight-bold py-2 float-left">
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


    <div class="col-auto action p-2">
        <div id="action-icons" class="flex-column">
            <div class="my-1"><span data-placement="left" data-toggle="tooltip" title="{{__("Share presentation")}}">
                <a href="#" data-toggle="modal" data-target="#shareModal{{$video->id}}"
                   title="{{ __('Share presentation') }}" class="btn btn-sm">
                    <i class="fas fa-external-link-alt fa-fw"></i>
                </a></span>
            </div>
            @if ($video->download)
                <div class="dropdown my-1"><span data-placement="left" data-toggle="tooltip" title="{{ __("Download presentation") }}">
                    <a href="#" data-toggle="modal" data-target="#downloadModal{{$video->id}}"
                       title="{{ __('Download presentation') }}" class="btn btn-sm">
                        <i class="fas fa-download fa-fw"></i>
                    </a></span>
                </div>
            @endif
            @if ($video->edit)
                <div class="my-1">
                    <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip" data-placement="left"
                       title="{{ __('Edit presentation') }}" class="btn btn-sm">
                        <i class="far fa-edit fa-fw"></i>
                    </a>
                </div>
            @endif
            @if ($video->delete)
                <div class="my-1">
                <span data-toggle="tooltip" data-placement="left" title="{{__("Delete presentation")}}">
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
<!-- Modal Share-->
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
                    <textarea readonly class="form-control" id="staticLink"
                              value="">{{url("/multiplayer?p={$video->id}")}} </textarea>
                    <small id="staticLinkHelp"
                           class="form-text text-muted">{{ __("Permalink to this presentation") }}</small>
                </div>
                <div class="form-group">
                    <label for="embedCode">{{__("Embed ilearn")}}</label>
                    <textarea readonly class="form-control text-muted" rows="5" id="embedCode"><a target="_blank" href="{{ route('player', ['video' => $video]) }}"><img src="{{ asset($video->thumb)}}" width="560" height="315"></a></textarea>
                    <small id="embbedCodeHelp"
                           class="form-text text-muted">{{ __("Use this embed code to insert the video in iLearn") }}</small>
                </div>
                @if(!$video->course_permission)
                    <div class="form-group">
                        <label for="permissions">{{__("Permissions")}}
                            @if ($video->edit)
                                <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip"
                                   title="{{ __('Edit presentation') }}" class="btn btn-info btn-sm">{{__('Edit')}}
                                    <i
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
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal download -->
@if ($video->download)
    <div class="modal fade" id="downloadModal{{$video->id}}" tabindex="-1" role="dialog"
         aria-labelledby="downloadModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel">{{__("Download presentation")}}
                        <strong>{{$video->LangTitle}}</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="staticLink">{{__("Choose a resolution")}}</label>
                        <div class="dropdown">
                            @csrf
                            @foreach(json_decode($video->sources, true) as $source)
                                @if(is_array($source['video']) && $loop->first)
                                    @foreach($source['video'] as $key => $source)
                                        <button class="btn btn-outline-primary btn-sm" name="res"
                                                data-dismiss="modal"
                                                onclick="downloadPresentation('<?php echo $video->id;?>','<?php echo $key;?>')"
                                                value="{{$key}}"><i class="fas fa-download"></i>
                                            {{$key}}p
                                        </button>
                                    @endforeach
                                @elseif($loop->first)
                                    <button class="btn btn-outline-primary btn-sm" name="res"
                                            onclick="downloadPresentation('<?php echo $video->id;?>','<?php echo $key;?>')"
                                            data-dismiss="modal"
                                            value="999">
                                        <i class="fas fa-download"></i> 720p
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("Close")}}</button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Modal delete -->
@if ($video->delete)
    <div class="modal fade" id="deleteModal{{$video->id}}" tabindex="-1" role="dialog"
         aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="post" action="{{route('presentation.delete', $video->id)}}">
                @csrf
                <input type="hidden" name="video_id" value="{{$video->id}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">{{__("Delete presentation")}}
                            "{{$video->LangTitle}}"?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="retype{{$video->id}}" class="form-control-label">
                                {{_("To confirm deletion, type the presentation title:")}}</label>
                            <input type="text" class="form-control" id="retype{{$video->id}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="delete" type="button"
                                class="btn btn-primary disabled">{{_("Confirm deletion")}}</button>
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{__("Close")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif


<script>
    $("#retype{{$video->id}}").on('change input', function ($this) {
        var title = "{{$video->LangTitle}}";
        if ($(this).val().toLowerCase() == title.toLowerCase()) {
            $(this).addClass('is-valid');
            $(this).removeClass('is-invalid');
            $(this).closest('.modal-content').find('#delete').removeClass('disabled');
            $(this).closest('.modal-content').find('#delete').prop('type', 'submit');
        } else {
            $(this).closest('.modal-content').find('#delete').addClass('disabled');
            $(this).closest('.modal-content').find('#delete').prop('type', 'button');
            $(this).removeClass('is-valid');
            $(this).addClass('is-invalid');
        }
    });
    $("#retype{{$video->id}}").on('paste', function ($this) {
        alert('You need to manually type it in!')
        return false;
    });
</script>
