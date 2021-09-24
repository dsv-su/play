<!-- Video - child view - will inherit all data available in the parent view-->
<div class="card video m-auto" @if (isset($manage) && $manage) id="{{$video->id}}" @endif>
    <a href="{{ route('player', ['video' => $video]) }}">
        <div class="card-header position-relative"
             style="background-image: @if ($video->visability == false) linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), @endif url({{ asset($video->thumb)}}); height:200px;">
            <div class="title">{{ $video->title }}</div>
            <!-- Group Permissions -->
            <div class="icons">
                @if($permissions ?? '')
                    @foreach($permissions as $permission)
                        @if($video->id == $permission->video_id && $permission->type == 'private')
                            <div class="permission"><i class="fas fa-user-lock"></i></div>
                        @endif
                        @if($video->id == $permission->video_id && $permission->type == 'external')
                            <div class="permission"><i class="fas fa-globe"></i></div>
                        @endif
                    @endforeach
                @endif
            <!-- end Group Permission -->
                <!-- Visability -->
                @if($video->visability == false)
                    <div class="visability"><i class="far fa-eye-slash"></i></div>
                @endif
            </div>
            @if ($video->visability == false)
                <div class="d-flex justify-content-center h-100">
                    <div class="d-inline alert alert-secondary m-auto"
                         role="alert">{{ __("Presentation hidden") }}</div>
                </div>
            @endif
            <p class="p-1"> {{$video->duration}} </p>
        </div>
    </a>
    <div class="card-body p-1">
        @if (!$video->video_course->isEmpty())
            <p class="card-text">
                @foreach($video->video_course as $vc)
                    <a href="/designation/{{\App\Course::find($vc->course_id)->designation}}"
                       class="badge badge-primary">{{\App\Course::find($vc->course_id)->designation}}</a>
                @endforeach
            </p>
        @endif
        @if(!$video->category->category_name == 'Okategoriserad') <!-- For now hide category -->
        <button id="presenter_btn" class="transparent_btn presenter_btn"><i class="far fa-user"></i></button>
        <p class="card-text">
            <span class="badge badge-light">{{$video->category->category_name}}</span>
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
            <div class="dropdown ml-1" data-toggle="tooltip" data-placement="top"
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
            @if (isset($manage) && $manage)
                <div class="ml-1">
                <a href="{{route('presentation_edit', $video->id)}}" data-toggle="tooltip"
                   title="{{ __('Edit Presentation') }}" class="btn btn-outline-primary btn-sm mb-1"><i
                            class="far fa-edit"></i></a>
                </div>
                {{--}}
                <a href="{{route('edit_permission', $video->id)}}" data-toggle="tooltip"
                   title="{{ __("Change rights for presentation") }}" class="btn btn-outline-secondary btn-sm mb-1"><i
                            class="far fa-hand-paper"></i></a>
                {{--}}
                <div class="ml-1">
                <form>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <a href="#" data-toggle="tooltip" title="{{ __("Delete presentation") }}"
                       class="btn btn-outline-danger btn-sm float-right delete"><i
                                class="far fa-trash-alt"></i></a>
                </form>
                </div>
            @endif
        </div>
        <p class="m-0"><small>{{$video->id}}</small></p>
    </div>
</div>
