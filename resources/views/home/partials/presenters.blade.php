@if (!$video->presenters->isEmpty())
    @foreach($video->presenters->take(2) as $presenter)
        <a href="/presenter/{{$presenter->username}}"
           class="px-1.5 py-0 text-[10px] font-medium text-blue-700 bg-gray-100 border-none rounded-sm shadow-sm">
            {{$presenter->name}}
        </a>
    @endforeach

    @if ($video->presenters->count() > 2)
        <span class="px-1.5 py-0 text-[10px] font-medium text-blue-700 bg-gray-100 border-none rounded-sm shadow-sm">
            +{{ $video->presenters->count() - 2 }} more
        </span>
    @endif
@endif
