@if ($video->edit && $video->state)
    <div class="flex space-x-1">
        <!-- Playback Metric -->
        <button
            type="button"
            onclick="Livewire.dispatch('open-chart-modal', { videoId: @js($video->id) })"
            class="flex items-center justify-center w-8 h-8 hover:bg-neutral-100 active:bg-white focus:bg-white
                    focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2
                    disabled:opacity-50 disabled:pointer-events-none">

            <div data-tooltip-target="metrics-tooltip"
                 class="inline-flex text-blue-500 rounded-md shadow-sm space-x-0.5"
                 role="group">

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" class="size-3.5">
                    <path d="M15.5 2A1.5 1.5 0 0 0 14 3.5v13a1.5 1.5 0 0 0
                             1.5 1.5h1a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0
                             16.5 2h-1ZM9.5 6A1.5 1.5 0 0 0 8 7.5v9A1.5 1.5 0 0 0
                             9.5 18h1a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0
                             10.5 6h-1ZM3.5 10A1.5 1.5 0 0 0 2 11.5v5A1.5 1.5 0 0 0
                             3.5 18h1A1.5 1.5 0 0 0 6 16.5v-5A1.5 1.5 0 0 0
                             4.5 10h-1Z" />
                </svg>

                <p class="text-xs text-gray-500 dark:text-neutral-400">
                    {{ $video->videoStats->playback ?? 0 }}
                </p>
            </div>
        </button>

        <!-- Download Metric -->
        <div class="flex items-center justify-center w-8 h-8 hover:bg-neutral-100 active:bg-white focus:bg-white
                    focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2
                    disabled:opacity-50 disabled:pointer-events-none">

            <div data-tooltip-target="download-metrics-tooltip"
                 class="inline-flex text-red-500 rounded-md shadow-sm space-x-0.5"
                 role="group">

                <svg class="w-4 h-4 text-red-500 dark:text-white"
                     xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round"
                          stroke-linejoin="round" stroke-width="2"
                          d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                </svg>

                <p class="text-xs text-gray-500 dark:text-neutral-400">
                    {{ $video->videoStats->download ?? 0 }}
                </p>
            </div>
        </div>
    </div>
    <!-- Metrics chart -->
    <livewire:stats.video-stats :video="$video" :key="'video-stats-'.$video->id" />
    <!-- end chart -->
@endif
