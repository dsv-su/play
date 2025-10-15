<div class="flex flex-row gap-x-4">
    <div class="flex flex-col gap-y-1 w-1/2">
        <div class="bg-blue-50 border border-blue-500 text-sm text-gray-500 rounded-lg p-5 dark:bg-blue-600/[.15]">
            <div class="flex">
                <svg class="flex-shrink-0 h-4 w-4 text-blue-600 mt-0.5 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 16v-4"></path>
                    <path d="M12 8h.01"></path>
                </svg>
                <div class="ms-3">
                    <h3 class="text-blue-600 font-semibold dark:font-medium dark:text-white">Please note!</h3>
                    <p class="mt-2 text-gray-800 dark:text-slate-400">
                        {{__("Enabling this option will allow all selected presentations to be downloaded.")}}
                    </p>

                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-y-1 w-1/2">
        <!-- Top Label + Info Button -->
        <label for="hs-xs-switch-download"
               class="font-sans text-sm font-medium text-gray-900 dark:text-white flex items-center gap-x-1">
            {{ __("Downloadable") }}
            <button id="bulk-download-button" data-modal-toggle="bulk-download-modal" class="inline-flex" type="button">
                <svg class="w-[16px] h-[16px] text-gray-800 dark:text-white"
                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                          d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </button>
        </label>

        <!-- Switch + Right Label -->
        <div class="flex items-center gap-x-2">
            <!-- Smaller Switch -->
            <label for="hs-xs-switch-download"
                   class="relative inline-block w-10 h-5 sm:w-11 sm:h-5 md:w-12 md:h-6 cursor-pointer">
                <input
                    type="checkbox"
                    id="hs-xs-switch-download"
                    class="peer sr-only"
                    name="download"
                    wire:model.live="download"
                >
                <!-- Track -->
                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors
                         peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500"></span>

                <!-- Thumb -->
                <span class="absolute top-1/2 start-0.5 -translate-y-1/2
                         size-4 sm:size-4.5 md:size-5
                         bg-white rounded-full shadow transition-transform
                         peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
            </label>

            <!-- Right-side label -->
            @if($download)
                <span class="px-1.5 py-0 text-[0.8125rem]/5 font-medium text-white bg-suprimary border border-suprimary rounded shadow-md
                                    inline-flex items-center gap-1 truncate dark:bg-blue-500">
            {{__("Downloadable")}}
        </span>
            @else
                <span class="px-1.5 py-0 text-[0.8125rem]/5 font-medium text-white bg-red-600
                                    border border-red-600 rounded shadow-md inline-flex items-center gap-1 truncate">
            {{__("Not Downloadable")}}
        </span>
            @endif

        </div>
    </div>
    <input type="hidden" name="download"  value="{{ $download }}" >

</div>
