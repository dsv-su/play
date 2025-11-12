<div class="space-y-4"
     wire:init="refreshStatuses"
     wire:poll.10s="refreshStatuses">

    <div class="max-w-[85rem] px-4 py-8 sm:px-6 lg:px-8 lg:py-12 mx-auto">
        <!-- Responsive grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 sm:gap-6">

            @foreach($recorders as $cattura)
                @php
                    $status = strtoupper($cattura['status'] ?? 'UNKNOWN');
                    $statusBg = $this->badgeClass($cattura['status'] ?? 'UNKNOWN');
                @endphp

                <a @can('admin-content') href="{{ $cattura['url'] }}" @endcan
                   class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition-shadow
                  dark:bg-neutral-900 dark:border-neutral-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <div class="p-3 md:p-3 flex gap-4">
                        <!-- Status icon -->
                        <div class="shrink-0 flex justify-center items-center size-11 {{ $statusBg }} rounded-lg dark:bg-neutral-800">
                            <svg class="w-6 h-6  dark:text-white" aria-hidden="true" viewBox="0 0 24 24" fill="none">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M14 6H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1Zm7 11-6-2V9l6-2v10Z"/>
                            </svg>
                        </div>

                        <!-- Text block -->
                        <div class="grow min-w-0">
                            <!-- Recorder -->
                            <p class="text-xs sm:text-sm uppercase font-semibold tracking-wide text-blue-600 dark:text-neutral-400 truncate">
                                {{ $cattura['recorder'] }}
                            </p>

                            <!-- Status -->
                            <h3 class="mt-1 text-lg sm:text-2xl font-semibold text-gray-800 dark:text-neutral-100">
                                {{ $status }}
                            </h3>

                            <!-- Badges: always under the status, wrap on small screens -->
                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-medium
                                               border-blue-300 {{ $this->spaceClass($cattura['details']['free_pct'] ?? 0) }} dark:text-blue-300 dark:border-blue-500">
                                  {{ __('Available space:') }} {{ $cattura['details']['free_pct'] }}%
                                </span>

                                @if($cattura['details']['internet'])
                                    <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-medium
                                                border-emerald-300 text-emerald-800 dark:text-emerald-300 dark:border-emerald-500">
                                        {{ __('Connected') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-medium
                                                 border-red-300 text-red-800 dark:text-red-300 dark:border-red-500">
                                        {{ __('Offline') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
</div>
