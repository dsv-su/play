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
