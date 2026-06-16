<div class="min-w-0">
    <label for="hs-xs-switch-download"
           class="mb-2 flex items-center gap-x-1 text-sm font-medium text-slate-900 dark:text-white">
        {{ __("Downloadable") }}
        <button id="download-button" data-modal-toggle="download-modal" class="inline-flex size-5 items-center justify-center text-slate-500 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-neutral-400 dark:hover:text-white" type="button" aria-label="{{ __('More info about downloads') }}">
            <svg class="size-4"
                 aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                      d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </button>
    </label>

    <div class="flex min-h-[3rem] items-center gap-x-3 rounded-lg border border-slate-200 bg-slate-50 px-3 dark:border-neutral-700 dark:bg-neutral-950">
        <label for="hs-xs-switch-download"
               class="relative inline-block h-6 w-11 shrink-0 cursor-pointer">
            <input
                type="checkbox"
                id="hs-xs-switch-download"
                class="peer sr-only"
                name="download"
                wire:model.live="download"
            >
            <span class="absolute inset-0 rounded-full bg-slate-200 transition-colors
                         peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500"></span>

            <span class="absolute start-0.5 top-1/2 size-5 -translate-y-1/2 rounded-full bg-white shadow-sm transition-transform peer-checked:translate-x-full dark:bg-neutral-300 dark:peer-checked:bg-white"></span>
        </label>

        @if($download)
            <span class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 dark:border-blue-900/70 dark:bg-blue-950 dark:text-blue-300">
            {{__("Downloadable")}}
        </span>
        @else
            <span class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 dark:border-red-900/70 dark:bg-red-950 dark:text-red-300">
            {{__("Not Downloadable")}}
        </span>
        @endif
    </div>
</div>
<input type="hidden" name="download"  value="{{ $download }}" >

