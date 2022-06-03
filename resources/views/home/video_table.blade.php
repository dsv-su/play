<!-- Video - child view - will inherit all data available in the parent view-->
<div class="videotable p-0 mb-0 bg-white overflow-hidden row mx-1 w-100 border-bottom-grey d-flex align-content-center @if($video->hidden) faded @endif"
     id="{{$video->id}}">
    <div class="col-12 col-sm-8 col-md info p-2">
        <!-- Group Permissions icons-->
        <h4 class="card-text font-1rem py-1 my-auto" style="line-height: 1.6em;">
            @if($video->permission_type == 'dsv')
                <span class="permission d-inline-block mx-1" data-toggle="tooltip"
                      title="{{__("DSV students & staff playback")}}">
                <i class="fas fa-users"></i>
            </span>
            @elseif($video->permission_type == 'dsv_staff')
                <span class="permission d-inline-block mx-1" data-toggle="tooltip" title="{{__("DSV staff playback")}}">
                <i class="fas fa-house-user"></i>
            </span>
            @elseif($video->permission_type == 'public')
                <span class="permission d-inline-block mx-1" data-toggle="tooltip" title="{{__("Public playback")}}">
                <i class="fas fa-globe"></i>
            </span>
            @elseif($video->permission_type == 'custom')
                <span class="permission d-inline-block mx-1" data-toggle="tooltip" title="{{__("Custom playback")}}">
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
                <span class="visibility d-inline-block mx-1" data-toggle="tooltip"
                      title="{{__('Presentation is hidden')}}">
                <i class="fas fa-eye-slash"></i>
            </span>
            @endif
            <a href="{{ route('player', ['video' => $video]) }}" class="link">{{ $video->LangTitle }}</a>
            <span class="badge badge-light">{{$video->duration}}</span>

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
        </h4>
    </div>
    <!-- Stats -->
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
    <div class="col col-sm-2 col-md-auto p-1 my-auto">
        <span class="card-text text-font-size-80 font-weight-normal py-2">{{$video->getCreationDate()}}</span>
    </div>
    <div class="col-auto col-sm-2 col-md-auto action p-1 d-flex justify-content-center">
        <div id="action-icons" class="d-flex flex-row my-auto flex-wrap">
            <div class="mr-1"><span data-placement="left" data-toggle="tooltip" data-title="{{__("Share presentation")}}">
                <a href="#" data-toggle="modal" data-target="#shareModal{{$video->id}}"
                   title="{{ __('Share presentation') }}" class="btn btn-sm">
                    <i class="fas fa-external-link-alt fa-fw"></i>
                </a></span>
            </div>
            @if ($video->download)
                <div class="dropdown mr-1"><span data-placement="left" data-toggle="tooltip"
                                                 data-title="{{ __("Download presentation") }}">
                    <a href="#" data-toggle="modal" data-target="#downloadModal{{$video->id}}"
                       title="{{ __('Download presentation') }}" class="btn btn-sm">
                        <i class="fas fa-download fa-fw"></i>
                    </a></span>
                </div>
            @endif
            @if ($video->edit)
                <div class="mr-1">
                    <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip" data-placement="left"
                       data-title="{{ __('Edit presentation') }}" class="btn btn-sm">
                        <i class="far fa-edit fa-fw"></i>
                    </a>
                </div>
            @endif
            @if ($video->delete)
                <div class="mr-1">
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
<!-- Modal Share-->
<div wire:ignore.self class="modal fade" id="shareModal{{$video->id}}" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel"
     aria-hidden="true" data-backdrop="false">
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
    <div wire:ignore.self class="modal fade" id="downloadModal{{$video->id}}" tabindex="-1" role="dialog"
         aria-labelledby="downloadModalLabel"
         data-backdrop="false"
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
    <div wire:ignore.self class="modal fade" id="deleteModal{{$video->id}}" tabindex="-1" role="dialog"
         aria-labelledby="deleteModalLabel"
         data-backdrop="false"
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
