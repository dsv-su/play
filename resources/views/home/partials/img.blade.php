<div class="relative aspect-video w-full overflow-hidden rounded-t-sm">
    <img
        class="absolute inset-0 h-full w-full object-cover
               @if($video->hidden) opacity-75 @endif"
        src="{{ asset($video->thumb . '?' . time()) }}"
        alt="Presentation thumb-{{$loop->index}}">
</div>
