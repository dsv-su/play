<div wire:poll.15s.visible>
    <a
        href="{{route('pending.presentations')}}"
        aria-label="View pending presentations"
        class="relative inline-flex items-center justify-center w-11 h-11 rounded-lg p-0.5
         text-gray-600 hover:text-gray-900 hover:bg-gray-100
         dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700
         focus:outline-none focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
    >
        <!-- Bell icon -->
        <svg class="w-6 h-6 text-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 21">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                  d="M8 3.464V1.1m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175C15 15.4 15 16 14.462 16H1.538C1 16 1 15.4 1 14.807c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 8 3.464ZM4.54 16a3.48 3.48 0 0 0 6.92 0H4.54Z"/>
        </svg>
        @if($pending > 0)
        <!-- Notification badge (top-left) -->
        <span class="pointer-events-none absolute top-0 left-0
           -translate-x-[3%] -translate-y-[3%]
           inline-flex items-center justify-center">
            <!-- Ping ring -->
            <span class="motion-safe:animate-ping absolute inline-flex rounded-full
                     bg-blue-500 dark:bg-blue-600 opacity-75
                     h-3 w-3 sm:h-3.5 sm:w-3.5"></span>
                <!-- Count dot -->
            <span
                class="relative inline-flex items-center justify-center rounded-full
                     bg-blue-600 text-white dark:bg-blue-500
                     h-3 w-3 sm:h-4 sm:w-4
                     text-[10px] sm:text-xs font-medium leading-none">
              {{$pending}}
            </span>
        </span>
        @endif
    </a>
</div>
