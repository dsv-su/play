<div class="card video m-auto faded" id="{{$video->id}}"
     style="box-shadow: 0 1rem 3rem rgba(240, 173, 78, 1.5)!important;">
    <!-- hide action icons for now
                    <div id="action-icons" class="flex-column m-1">
                                <div class="mb-1">
                                    <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip" data-placement="left"
                                       title="{{ __('Edit presentation') }}" class="btn btn-dark btn-sm"><i
                                                class="far fa-edit fa-fw"></i></a>
                                </div>
                                <div class="mb-1">
                                    <form>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <a href="#" data-toggle="tooltip" data-placement="left"
                                           title="{{ __("Delete presentation") }}"
                                           class="btn btn-dark btn-sm delete"><i
                                                    class="far fa-trash-alt fa-fw"></i></a>
                                    </form>
                                </div>
                    </div>
-->
    <div class="card-header position-relative"
         style="">
        <div class="d-flex justify-content-center h-100">
            <div class="d-inline alert alert-secondary m-auto"
                 role="alert">{{ __("Processing") }}</div>
        </div>
        <p class="m-1 px-1"> @if(isset($video->mediasite_folder_id))
                {{\Carbon\Carbon::parse($video->duration/1000)->toTimeString()}}
            @else
                {{\Carbon\Carbon::parse($video->duration)->toTimeString()}}
            @endif</p>
    </div>
    <div class="card-body p-1 overflow-hidden">
        <div class="d-flex align-items-start">
            <div class="">
                <h4 class="card-text font-1rem px-1 py-2">{{ $video->LangTitle }} ({{$video->created_at}})</h4>
            </div>
            @if ($video->description)
                <div class="ml-auto showmore">
                    <a tabindex="0" class="btn btn-sm" role="button" data-toggle="popover"
                       data-trigger="focus"
                       data-original-title="Description"
                       data-placement="bottom"
                       data-content="{{$video->description}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                             fill="currentColor"
                             class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>

        <p class="card-text">
            @if ($video->courses)
                @foreach($video->courses as $designation)
                    <a href="/designation/{{$designation}}"
                       class="badge badge-primary">{{$designation}}</a>
                @endforeach
            @endif
            @if ($video->presenters)
                @foreach($video->presenters as $username)
                    <span class="badge badge-light">{{$username}}</span>
                @endforeach
            @endif
            <!-- Hide tags for now
            @if ($video->tags)
                @foreach($video->tags as $tag)
                    <span class="badge badge-secondary">{{$tag}}</span>

                @endforeach
            @endif
            -->
        </p>
    </div>
</div>
