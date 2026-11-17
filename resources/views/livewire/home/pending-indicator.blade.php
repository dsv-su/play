<div wire:poll.15s.visible
     class="relative"
     x-data="{ tooltipOpen: false }"
     x-id="['pending-presentations-tooltip']"
     @mouseenter="tooltipOpen = true"
     @mouseleave="if (!$el.contains(document.activeElement)) tooltipOpen = false"
     @focusin="tooltipOpen = true"
     @focusout="if (!$el.contains($event.relatedTarget) && !$el.matches(':hover')) tooltipOpen = false"
     @keydown.escape.stop="tooltipOpen = false">
    <a
        href="{{route('pending.presentations')}}"
        aria-label="{{ __('View pending presentations') }}{{ $pending > 0 ? ': '.$pending : '' }}"
        :aria-describedby="$id('pending-presentations-tooltip')"
        class="glass-nav-icon relative">
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
        <span aria-hidden="true" class="pointer-events-none absolute top-0 left-0
           -translate-x-[1%] -translate-y-[2%]
           inline-flex items-center justify-center">
            <!-- Count dot -->
            <span
                class="relative inline-flex items-center justify-center rounded-full
                     bg-blue-700 text-white dark:bg-blue-700
                     h-4 w-4 sm:h-3.5 sm:w-3.5 lg:h-5 lg:w-5
                     text-[11px] sm:text-[10px] lg:text-xs font-medium leading-none">
              {{$pending}}
            </span>
        </span>
        @endif
    </a>
    <span role="status" aria-atomic="true" class="sr-only">{{ __('Pending Presentations') }}: {{ $pending }}</span>
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
