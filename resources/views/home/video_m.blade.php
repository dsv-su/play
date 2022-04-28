<!-- Video - child view - will inherit all data available in the parent view-->
<div class="shadow-lg shadow-warning card video m-auto @if(isset($video['hidden'])) faded @endif"
     id="{{$video['id']}}">
    <div wire:ignore id="action-icons" class="flex-column m-1">
        @if (isset($video['edit']))
            <div wire:ignore class="" data-placement="left" data-toggle="tooltip" title="{{__("Share presentation")}}">
                <a href="#" data-toggle="modal" data-target="#shareModal{{$video['id']}}"
                   title="{{ __('Share presentation') }}" class="btn btn-dark btn-sm">
                    <i class="fas fa-external-link-alt fa-fw"></i>
                </a>
            </div>
        @endif
        @if (isset($video['download']))
            <div wire:ignore class="dropdown" data-placement="left" data-toggle="tooltip"
                 title="{{ __("Download presentation") }}">
                <a href="#" data-toggle="modal" data-target="#downloadModal{{$video['id']}}"
                   title="{{ __('Download presentation') }}" class="btn btn-dark btn-sm">
                    <i class="fas fa-download fa-fw"></i>
                </a>
            </div>
        @endif

        @if (app()->make('play_role') == 'Administrator')

            @if (isset($video['edit']))
                <div class="">
                    <a href="{{route('presentation_edit', $video['id'])}}" data-toggle="tooltip" data-placement="left"
                       title="{{ __('Edit presentation') }}" class="btn btn-dark btn-sm">
                        <i class="far fa-edit fa-fw"></i>
                    </a>
                </div>
            @endif
            @if (isset($video['delete']))
                <div>
                    <span data-toggle="tooltip" data-placement="left" data-title="{{__("Delete presentation")}}">
                        <a type="button" class="btn btn-dark btn-sm" data-toggle="modal"
                           data-target="#deleteModal{{$video['id']}}">
                            <i class="far fa-trash-alt fa-fw"></i>
                        </a>
                    </span>
                </div>
                <!--
                        <div class="">
                        <form>
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <a href="#" data-toggle="tooltip" data-placement="left" title="{{ __("Delete presentation") }}" class="btn btn-dark btn-sm delete">
                                <i class="far fa-trash-alt fa-fw"></i>
                            </a>
                        </form>
                    </div>
                    -->
            @endif
        @endif
    </div>
    <a target="_blank" rel="noopener noreferrer" href="{{ route('player', ['video' => $video['id']]) }}">
        <div class="card-header position-relative"
             style="background-image: @if (isset($video['hidden'])) linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), @endif url({{ asset($video['thumb'])}}); width: 100%; height: 0px; object-fit: contain; background-repeat: no-repeat; background-position: 50% 50%;">
            <!-- Icons -->
            <div class="icons m-1">
                <!-- Group Permissions icons-->
                @if($video['permission_type'] == 'dsv')
                    <div class="permission mx-1" data-toggle="tooltip" title="{{__("DSV students & staff playback")}}">
                        <i class="fas fa-users"></i>
                    </div>
                @elseif($video['permission_type'] == 'dsv_staff')
                    <div class="permission mx-1" data-toggle="tooltip" title="{{__("DSV staff playback")}}">
                        <i class="fas fa-house-user"></i>
                    </div>
                @elseif($video['permission_type'] == 'public')
                    <div class="permission mx-1" data-toggle="tooltip" title="{{__("Public playback")}}">
                        <i class="fas fa-globe"></i>
                    </div>
                @elseif($video['permission_type'] == 'custom')
                    <div class="permission mx-1" data-toggle="tooltip" title="{{__("Custom playback")}}">
                        <i class="fas fa-user-lock"></i>
                    </div>
                @elseif($video['permission_type'] == 'test')
                    <div class="permission mx-1" data-toggle="tooltip" title="{{__("Work in progress")}}">
                        <i class="fas fa-wrench"></i>
                    </div>
                @endif
                <!-- end Group Permission -->

                <!-- Visibility icon-->
                @if(isset($video['hidden']))
                    <div class="visibility mx-1" data-toggle="tooltip" title="{{__('Presentation is hidden')}}">
                        <i class="fas fa-eye-slash"></i>
                    </div>
                @endif
            </div>
            <!-- Visibility banner -->
            @if (isset($video['hidden']))
                <div class="d-flex justify-content-center h-100">
                    <div class="d-inline alert alert-secondary m-auto" role="alert">{{ __("Hidden") }}</div>
                </div>
            @endif
            <p class="m-1 px-1"> {{$video['duration']}} </p>
        </div>
    </a>

    <div class="card-body p-1 overflow-hidden">
        <div class="d-flex align-items-start">
            <div class="">
                <h4 class="card-text font-1rem font-weight-bold px-1 py-2">
                    <a href="{{ route('player', ['video' => $video['id']]) }}" class="link">{{ $video['title'] }}</a>
                </h4>
            </div>
            @if ($video['description'])
                <div class="ml-auto" id="showmore">
                    <a tabindex="0" class="btn btn-sm" role="button" data-toggle="popover"
                       data-trigger="focus"
                       data-original-title="{{__("Description")}}"
                       data-placement="bottom"
                       data-content="{{$video['description']}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>

        <p class="card-text">
            @if ($video['video_course'])
                @foreach($video['video_course'] as $vc)
                    <a href="/designation/{{$vc['course']['designation']}}"
                       class="badge badge-primary">{{$vc['course']['designation']}}</a>
                @endforeach
            @endif

            @if ($video['video_presenter'])

                @foreach($video['video_presenter'] as $presenter)
                    <a href="/presenter/{{$presenter['presenter']['username']}}"
                       class="badge badge-light">{{$presenter['presenter']['name']}}</a>
                @endforeach
            @endif
        </p>

    </div>
</div>
<!-- Modal Share-->
@if (isset($video['edit']))
    <div wire:ignore class="modal fade" id="shareModal{{$video['id']}}" tabindex="-1" role="dialog"
         aria-labelledby="shareModalLabel"
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
                                  value="">{{url("/multiplayer?p={$video['id']}")}} </textarea>
                        <small id="staticLinkHelp"
                               class="form-text text-muted">{{ __("Permalink to this presentation") }}</small>
                    </div>
                    <div class="form-group">
                        <label for="embedCode">{{__("Embed ilearn")}}</label>
                        <textarea readonly class="form-control text-muted" rows="5" id="embedCode"><a target="_blank" href="{{ route('player', ['video' => $video['id']]) }}"><img src="{{ asset($video['thumb'])}}" width="560" height="315"></a></textarea>
                        <small id="embbedCodeHelp"
                               class="form-text text-muted">{{ __("Use this embed code to insert the video in iLearn") }}</small>
                    </div>
                    @if(!isset($video['course_permission']))
                        <div class="form-group">
                            <label for="permissions">{{__("Permissions")}}
                                @if (isset($video['edit']))
                                    <a href="{{route('presentation_edit', $video['id'])}}" data-toggle="tooltip"
                                       title="{{ __('Edit presentation') }}" class="btn btn-info btn-sm">{{__('Edit')}}
                                        <i
                                                class="far fa-edit"></i></a>
                                @endif</label>
                            <p class="font-1rem">
                                {{--}}
                                @foreach ($video->permissions() as $permission)
                                    <span class="d-block">{{$permission->scope}}</span>
                                @endforeach
                                {{--}}
                            </p>
                            <p class="font-1rem">
                                {{--}}
                                @foreach($video->coursepermissions as $cpermission)
                                    <span class="d-block">{{$cpermission->name}} ({{$cpermission->username}}): <span
                                                class="text-capitalize badge badge-light">{{__('Manager')}}</span></span>
                                @endforeach
                                @foreach ($video->ipermissions as $ipermission)
                                    <span class="d-block">{{$ipermission->name}} ({{$ipermission->username}}): <span
                                                class="text-capitalize badge badge-light">{{$ipermission->permission}}</span></span>
                                @endforeach
                                {{--}}
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
@endif
<!-- -->

@if (isset($video['download']))
    <div class="modal fade" id="downloadModal{{$video['id']}}" tabindex="-1" role="dialog"
         aria-labelledby="downloadModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel">{{__("Download presentation")}}
                        <strong>{{$video['title']}}</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="staticLink">{{__("Choose a resolution")}}</label>
                        <div class="dropdown">
                            @csrf
                            @foreach(json_decode($video['sources'], true) as $source)
                                @if(is_array($source['video']) && $loop->first)
                                    @foreach($source['video'] as $key => $source)
                                        <button class="btn btn-outline-primary btn-sm" name="res"
                                                data-dismiss="modal"
                                                onclick="downloadPresentation('<?php echo $video['id'];?>','<?php echo $key;?>')"
                                                value="{{$key}}"><i class="fas fa-download"></i>
                                            {{$key}}p
                                        </button>
                                    @endforeach
                                @elseif($loop->first)
                                    <button class="btn btn-outline-primary btn-sm" name="res"
                                            onclick="downloadPresentation('<?php echo $video['id'];?>','<?php echo $key;?>')"
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
@if (isset($video['delete']))
    <div class="modal fade" id="deleteModal{{$video['id']}}" tabindex="-1" role="dialog"
         aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="post" action="{{route('presentation.delete', $video['id'])}}">
                @csrf
                <input type="hidden" name="video_id" value="{{$video['id']}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">{{__("Delete presentation")}}
                            "{{$video['title']}}"?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="retype{{$video['id']}}" class="form-control-label">
                                {{_("To confirm deletion, type the presentation title:")}}</label>
                            <input type="text" class="form-control" id="retype{{$video['id']}}">
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
    $("#retype{{$video['id']}}").on('change input', function ($this) {
        var title = "{{$video['title']}}";
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
    $("#retype{{$video['id']}}").on('paste', function ($this) {
        alert('You need to manually type it in!')
        return false;
    });
</script>
