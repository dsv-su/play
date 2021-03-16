<!-- Video - child view - will inherit all data available in the parent view-->
<div class="card video m-auto" >
    <a href="{{ route('player', ['video' => $video]) }}">
        <div class="card-header position-relative"
             style="background-image: url({{ asset($video->thumb)}}); height:200px;">
            <div class="title">{{ $video->title }}</div>
            <!-- For testing permission handling -->

            @if($permissions ?? '')
                @foreach($permissions as $permission)
                    @if($video->id == $permission->video_id && $permission->type == 'private')
                        <div class="permission">Låst</div>
                    @endif
                    @if($video->id == $permission->video_id && $permission->type == 'external')
                            <div class="permission">Publik</div>
                    @endif
            @endforeach
            @endif
            <!-- end permission handling -->
            <p class="p-1"> {{$video->duration}} </p>
        </div>
    </a>
    <div class="card-body p-1">
        <p class="card-text">
            @foreach($video->video_course as $vc)
                <a href="/course/{{$vc->course_id}}" class="badge badge-primary">{{\App\Course::find($vc->course_id)->designation}}</a>
            @endforeach
        </p>
        @if(!$video->category->category_name == 'Okategoriserad') <!-- For now hide category -->
            <button id="presenter_btn" class="transparent_btn presenter_btn"><i class="far fa-user"></i></button>
        <p class="card-text">
            <span class="badge badge-light">{{$video->category->category_name}}</span>
        </p>
        @endif
        <p class="card-text">
            @foreach($video->presenters() as $presenter)
                <a href="/presenter/{{$presenter->id}}" class="badge badge-light">{{$presenter->name}}</a>
            @endforeach
        </p>
        <p class="card-text" id="tags">
            @foreach($video->tags() as $tag)
                <a href="/tag/{{$tag->id}}" class="badge badge-secondary">{{$tag->name}}</a>
            @endforeach
        </p>
    </div>
</div>
