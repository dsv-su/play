<div class="row">

        <label class="col-4 col-lg-3 mb-0">{{ __("Subtitles:") }}</label>
        <div class="col">
            @if(json_decode($video->subtitles))
                @foreach(json_decode($video->subtitles, true) as $key => $sub)
                    @if($purge[$key])
                        <span class="badge badge-danger">
                            {{__("Delete")}} - {{$key}}
                    @else
                        <span class="badge badge-primary">
                            {{$key}}
                    @endif
                        </span>

                    @if(!$purge[$key])
                        <span class="badge badge-pill badge-light mb-1">
                            <span data-toggle="tooltip"
                                  data-title="{{__("Download transcription file")}}">
                                <a href="{{route('download-subtitle-file', [$video, 'lang' => $key])}}" type="button" class="btn btn-outline-primary">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                </a>
                            </span>

                            <span data-toggle="tooltip"
                                  data-title="{{__("Delete transcription file")}}">
                                <a wire:click="remove('{{$key}}')" type="button" class="btn btn-outline-danger">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </span>
                        </span>
                    @endif
                @endforeach
            @else
                {{__("No subtitles")}}
            @endif
        </div>

</div>
