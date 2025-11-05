<div class="relative aspect-video w-full overflow-hidden rounded-t-sm select-none pointer-events-none">
    <img
        class="absolute inset-0 h-full w-full object-cover
               @if($video->hidden) opacity-50 @endif"
        loading="lazy"
        decoding="async"
        src="{{ asset($video->thumb . '?' . time()) }}"
        alt="Presentation thumb-{{$loop->index}}">
</div>
