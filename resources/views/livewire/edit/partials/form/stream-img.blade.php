<div class="aspect-[16/9] bg-gray-200 dark:bg-gray-700 relative">
    <img
        class="w-full h-full object-cover {{$stream['hidden'] ? 'opacity-25' : 'opacity-100'}}"
        src="{{ $stream['poster'] }}"
        alt="{{ $stream['title'] }}"
    >
    <!-- Img overlay -->
    @if($stream['hidden'])
        <span class="absolute inset-0 flex items-center justify-center bg-black/40">
            <span class="px-2 py-0.5 font-medium rounded bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-200">
                {{ __("Stream hidden") }}
            </span>
        </span>
    @endif
</div>
{{--}}
<!-- Testing rendering player in card -->
<div class="aspect-[16/9] bg-gray-200 dark:bg-gray-700 relative overflow-hidden">
    <multi-player
        class="absolute inset-0 w-full h-full {{ $stream['hidden'] ? 'opacity-25' : 'opacity-100' }}"
        style="width: 100%; height: 100%;"
        play="/presentation/{{ $video->id }}"
        @if(isset($playlist)) list="/playlist/{{ $playlist }}" @endif
        @if(isset($s)) s="{{ $s }}" @endif></multi-player>

    @if($stream['hidden'])
        <span class="absolute inset-0 flex items-center justify-center bg-black/40 z-10 pointer-events-none">
            <span class="px-2 py-0.5 font-medium rounded bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-200">
                {{ __("Stream hidden") }}
            </span>
        </span>
    @endif
</div>
 {{$streamUrl[$stream['id']]}}
<script src="{{ asset('js/multiplayer.js') }}" defer></script>

{{--}}
