@if (!$video->tags->isEmpty())
    @foreach($video->tags as $tag)
        @if (!$video->hasCourseDesignation($tag->name))
            <a href="/tag/{{$tag->name}}"
               class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">
                {{$tag->name}}</a>
        @endif
    @endforeach
@endif
