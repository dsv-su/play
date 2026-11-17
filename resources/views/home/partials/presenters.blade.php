@if (!$video->presenters->isEmpty())
    @foreach($video->presenters->take(2) as $presenter)
        <a href="/presenter/{{$presenter->username}}"
           data-tooltip-target="presenter-tooltip"
           class="presentation-card-chip">
            {{$presenter->name}}
        </a>
    @endforeach

    @if ($video->presenters->count() > 2)
        <span class="presentation-card-chip">
            +{{ $video->presenters->count() - 2 }} <span class="sr-only">{{ __('more presenters') }}</span>
        </span>
    @endif
@endif
