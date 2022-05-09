<!-- ManageVideo - child view - will inherit all data available in the parent view-->
<!-- Not used anymore -->
<div class="col my-3">
    <!--<style>.btn-sm { height: 3vh; width: 5vh; }</style>-->
    <div class="card video m-auto" id="{{$video->id}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <a href="{{ route('player', ['video' => $video]) }}">
            <div class="card-header position-relative"
                 style="background-image: url({{ asset($video->thumb)}}); height:200px;">
                <div class="title">{{ $video->LangTitle }}</div>
                <p class="p-1"> {{$video->duration}} </p>
            </div>
        </a>
        <div class="card-body p-1">
            <p class="card-text" id="courses">
                @foreach($video->video_course as $vc)
                    <a href="/designation/{{\App\Course::find($vc->course_id)->designation}}"
                       class="badge badge-primary">{{\App\Course::find($vc->course_id)->designation}}</a> @endforeach
            </p>
            <p class="card-text">
                @foreach($video->presenters() as $presenter)
                    <a href="/presenter/{{$presenter->username}}" class="badge badge-light">{{$presenter->name}}</a>
                @endforeach</p>
            <p class="card-text" id="tags">@foreach($video->tags() as $tag) <a
                        href="/tag/{{$tag->name}}"
                        class="badge badge-secondary">{{$tag->name}}</a> @endforeach</p>

            <div class="d-inline">
                <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip"
                   title="Redigera presentation" class="btn btn-outline-primary btn-sm mb-1"><i
                            class="far fa-edit"></i></a>
                <a href="{{route('edit_permission', $video->id)}}" data-toggle="tooltip"
                   title="{{ __("Change rights for presentation") }}" class="btn btn-outline-secondary btn-sm mb-1"><i
                            class="far fa-hand-paper"></i></a>
                <div class="dropdown d-inline" data-toggle="tooltip" data-placement="top"
                     title="{{ __("Download presentation") }}">
                    <a class="btn btn-outline-info btn-sm mb-1" href="#" role="button" data-toggle="dropdown"
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
                                    <button class="dropdown-item btn btn-outline-primary btn-sm" name="res" value="999">
                                        <i class="fas fa-download"></i> 720p
                                    </button>
                                @endif
                            @endforeach
                        </form>
                    </div>
                </div>
                <a href="#" data-toggle="tooltip" title="{{ __("Delete presentation") }}"
                   class="btn btn-outline-danger btn-sm ml-1 mb-1 float-right"><i
                            class="far fa-trash-alt"></i></a>
            </div>
            <p class="m-0"><small>{{$video->id}}</small></p>
        </div>
    </div>
</div>
