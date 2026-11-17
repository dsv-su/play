<h3 class="presentation-card-title">
    @if($video->state)
        <a target="_blank" rel="noopener noreferrer" href="{{ route('player.show', ['video' => $video]) }}"
           aria-label="{{ __('Open :title in a new tab', ['title' => $video->LangTitle]) }}">{{ $video->LangTitle }}</a>
    @else
        {{ $video->LangTitle }}
    @endif
</h3>
