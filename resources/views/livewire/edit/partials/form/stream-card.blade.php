<div class="p-3">
    <div class="flex items-center justify-between gap-2">
        <h3 class="text-sm font-semibold truncate">
            {{ $stream['title'] }}
        </h3>
        @if($stream['hidden'])
            <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-200">
                                    {{__("HIDDEN")}}
                                </span>
        @else
            <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-200">
                                    {{__("LIVE")}}
                                </span>
        @endif

    </div>
    <div class="flex items-center justify-between w-full">
        <!-- Audio -->
        <div class="flex items-center gap-x-2">
            <label for="hs-xs-switch-{{ $key }}" class="relative inline-block w-7 h-4 cursor-pointer">
                <input
                    type="checkbox"
                    name="audio[{{$stream['title']}}]"
                    id="hs-xs-switch-{{ $key }}"
                    class="peer sr-only"
                    wire:model.live="audio.{{ $key }}"
                >
                <!-- Track -->
                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500"></span>
                <!-- Thumb -->
                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-3 bg-white rounded-full shadow-xs transition-transform peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
            </label>
            <label for="hs-xs-switch-{{ $key }}" class="text-xs text-gray-500 dark:text-neutral-400">{{__("Audio")}}</label>
        </div>

        <!-- Visibility -->
        <div class="flex items-center gap-x-2">
            <label for="hs-xs-switch-visibility-{{ $key }}" class="relative inline-block w-7 h-4 cursor-pointer">
                <input
                    type="checkbox"
                    name="streamVisibility[{{$stream['title']}}]"
                    id="hs-xs-switch-visibility-{{ $key }}"
                    class="peer sr-only"
                    wire:model.live="streamVisibility.{{ $key }}"
                >
                <!-- Track -->
                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500"></span>
                <!-- Thumb -->
                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-3 bg-white rounded-full shadow-xs transition-transform peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
            </label>
            <label for="hs-xs-switch-visibility-{{ $key }}" class="text-xs text-gray-500 dark:text-neutral-400">{{__("Hidden")}}</label>
        </div>
    </div>
</div>
