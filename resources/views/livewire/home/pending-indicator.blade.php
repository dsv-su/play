<div wire:poll.15s.visible>
    <a
        href="{{route('pending.presentations')}}"
        aria-label="View pending presentations"
        class="relative inline-flex items-center justify-center w-11 h-11 rounded-lg p-0.5
         text-gray-600 hover:text-gray-900 hover:bg-gray-100
         dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700
         focus:outline-none focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
        <!-- icon -->
        <svg class="w-6 h-6 text-gray-800 dark:text-white"
             data-tooltip-target="incoming-tooltip"
             aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
        </svg>

    @if($pending > 0)
        <!-- Notification badge (top-left) -->
        <span class="pointer-events-none absolute top-0 left-0
           -translate-x-[1%] -translate-y-[2%]
           inline-flex items-center justify-center">
            <!-- Ping ring -->
            <span
                class="motion-safe:animate-ping absolute inline-flex rounded-full
                     bg-blue-500 dark:bg-blue-600 opacity-75
                     h-3.5 w-3.5 sm:h-3 sm:w-3 lg:h-4 lg:w-4">
            </span>
            <!-- Count dot -->
            <span
                class="relative inline-flex items-center justify-center rounded-full
                     bg-blue-600 text-white dark:bg-blue-500
                     h-4 w-4 sm:h-3.5 sm:w-3.5 lg:h-5 lg:w-5
                     text-[11px] sm:text-[10px] lg:text-xs font-medium leading-none">
              {{$pending}}
            </span>
        </span>
        @endif
    </a>
    <div id="incoming-tooltip" role="tooltip"
         class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
         data-popper-placement="top">{{ __('Pending Presentations') }}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</div>
