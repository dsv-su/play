<style>
    @keyframes rotate {
        100% {
            transform: rotate(1turn);
        }
    }
</style>
<div class="pending_box">
    <div class="card video m-auto faded" id="{{$video->id}}">
        <div class="card-header position-relative"
             style="background-image: @if ($video->hidden) linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), @endif url({{ asset($video->thumb)}}); width: 100%; height: 0; object-fit: cover; background-repeat: no-repeat; background-position: 50% 50%;">
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
                    <h4 class="card-text font-1rem px-1 py-2">{{ Str::limit($video->LangTitle, 25) }} </h4>
                    <p class="card-text badge badge-light">{{$video->created_at}}</p>
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


            </p>
        </div>
    </div>
</div>

