<div class="space-y-4 p-4">
    <div class="flex items-center justify-between gap-2">
        <h3 class="truncate text-sm font-semibold text-slate-950 dark:text-white">
            {{ $stream['title'] }}
        </h3>
        @if($stream['hidden'])
            <span class="rounded-full border border-red-200 bg-red-50 px-2.5 py-1 text-[0.7rem] font-semibold text-red-700 dark:border-red-900/70 dark:bg-red-950 dark:text-red-300">
                {{__("Hidden")}}
            </span>
        @else
            <span class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[0.7rem] font-semibold text-emerald-700 dark:border-emerald-900/70 dark:bg-emerald-950 dark:text-emerald-300">
                {{__("Live")}}
            </span>
        @endif

    </div>
    <div class="grid grid-cols-2 gap-3">
        <div class="rounded-lg border border-slate-200 bg-slate-50 p-3 dark:border-neutral-700 dark:bg-neutral-900">
            <label for="hs-xs-switch-{{ $key }}" class="relative inline-block h-5 w-9 cursor-pointer">
                <input
                    type="checkbox"
                    name="audio[{{$stream['title']}}]"
                    id="hs-xs-switch-{{ $key }}"
                    class="peer sr-only"
                    wire:model.live="audio.{{ $key }}"
                >
                <span class="absolute inset-0 rounded-full bg-slate-200 transition-colors peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500"></span>
                <span class="absolute start-0.5 top-1/2 size-4 -translate-y-1/2 rounded-full bg-white shadow-sm transition-transform peer-checked:translate-x-full dark:bg-neutral-300 dark:peer-checked:bg-white"></span>
            </label>
            <label for="hs-xs-switch-{{ $key }}" class="mt-2 block text-xs font-medium text-slate-600 dark:text-neutral-400">{{__("Audio")}}</label>
        </div>

        <div class="rounded-lg border border-slate-200 bg-slate-50 p-3 dark:border-neutral-700 dark:bg-neutral-900">
            <label for="hs-xs-switch-visibility-{{ $key }}" class="relative inline-block h-5 w-9 cursor-pointer">
                <input
                    type="checkbox"
                    name="streamVisibility[{{$stream['title']}}]"
                    id="hs-xs-switch-visibility-{{ $key }}"
                    class="peer sr-only"
                    wire:model.live="streamVisibility.{{ $key }}"
                >
                <span class="absolute inset-0 rounded-full bg-slate-200 transition-colors peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500"></span>
                <span class="absolute start-0.5 top-1/2 size-4 -translate-y-1/2 rounded-full bg-white shadow-sm transition-transform peer-checked:translate-x-full dark:bg-neutral-300 dark:peer-checked:bg-white"></span>
            </label>
            <label for="hs-xs-switch-visibility-{{ $key }}" class="mt-2 block text-xs font-medium text-slate-600 dark:text-neutral-400">{{__("Hidden")}}</label>
        </div>
    </div>
</div>
