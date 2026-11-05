<div wire:poll.15s.visible
     class="relative"
     x-data="{ tooltipOpen: false }"
     x-id="['pending-presentations-tooltip']"
     @mouseenter="tooltipOpen = true"
     @mouseleave="tooltipOpen = false"
     @focusin="tooltipOpen = true"
     @focusout="tooltipOpen = false"
     @keydown.escape.window="tooltipOpen = false">
    <a
        href="{{route('pending.presentations')}}"
        aria-label="{{ __('View pending presentations') }}"
        :aria-describedby="$id('pending-presentations-tooltip')"
        class="relative inline-flex items-center justify-center w-11 h-11 rounded-lg p-0.5
         text-gray-600 hover:text-gray-900 hover:bg-gray-100
         dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700
         focus:outline-none focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
        <!-- Presentation with a clock to indicate pending processing -->
        <svg class="w-6 h-6 text-gray-800 dark:text-white"
             aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M10 17H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v6M8 7l5 3-5 3V7Z"/>
                <circle cx="17" cy="17" r="5"/>
                <path d="M17 14v3l2 1"/>
            </g>
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
    <div :id="$id('pending-presentations-tooltip')" role="tooltip"
         x-show="tooltipOpen"
         x-transition.opacity
         style="display: none;"
         class="absolute right-0 top-full z-30 w-max max-w-[calc(100vw-2rem)] pt-2">
        <div class="rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white shadow-sm dark:bg-gray-700">
            {{ __('Pending Presentations') }}
        </div>
    </div>
</div>
