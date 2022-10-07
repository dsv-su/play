<!-- Modal Share-->
<div wire:ignore class="modal fade" id="shareModal{{$video->id}}" tabindex="-1" role="dialog"
     aria-labelledby="shareModalLabel"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered"  role="document">
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
    <div wire:ignore class="modal fade" id="downloadModal{{$video->id}}" tabindex="-1" role="dialog"
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
    <div wire:ignore class="modal fade" id="deleteModal{{$video->id}}" tabindex="-1" role="dialog"
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
