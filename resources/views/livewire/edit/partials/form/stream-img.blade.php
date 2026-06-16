<div class="relative aspect-video bg-slate-200 dark:bg-neutral-800" data-stream-poster="{{ $stream['id'] }}">
    <img
        class="h-full w-full object-cover transition duration-300 {{$stream['hidden'] ? 'opacity-25' : 'opacity-100'}}"
        data-stream-poster-image
        src="{{ $stream['poster'] }}"
        alt="{{ $stream['title'] }}"
    >
    <span class="absolute inset-0 hidden items-center justify-center bg-slate-950/45 backdrop-blur-sm" data-stream-replaced-overlay>
        <span class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 dark:border-blue-900/70 dark:bg-blue-950 dark:text-blue-300">
            {{ __("Replaced") }}
        </span>
    </span>
    @if($stream['hidden'])
        <span class="absolute inset-0 flex items-center justify-center bg-black/40">
            <span class="rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 dark:border-red-900/70 dark:bg-red-950 dark:text-red-300">
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
