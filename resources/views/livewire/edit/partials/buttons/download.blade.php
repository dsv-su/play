<!-- Download button -->
@if ($video->download && $video->state)
    <div
        data-widget="download-status"
        data-video-id="{{ $video->id }}"
        data-start-url="{{ route('presentation.download', $video) }}"
        data-status-url="{{ route('presentation.download.status', $video) }}"
        data-download-url="{{ route('zip.download', $video) }}">
        <!-- Status -->
        <div class="flex items-center justify-between">
            <span data-role="status-text" class="hidden text-xs text-gray-500">Idle</span>
        </div>
        <!-- Progress bar -->
        <div data-role="bar-container" class="hidden w-full bg-gray-200/80 dark:bg-gray-800/60 rounded-full h-3 overflow-hidden">
            <div data-role="progress-bar" class="h-3 bg-blue-600 transition-[width] duration-500 ease-out" style="width:0%"></div>
        </div>
        <!-- Button -->
        <div class="flex items-center gap-3">
            <button
                data-role="start-btn"
                data-tooltip-target="download-tooltip"
                data-tooltip-placement="top"
                class="inline-flex items-center gap-1 px-1 py-1 text-xs font-medium text-blue-800 bg-transparent
                       rounded-md hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700"
                title="{{ __('Download presentation') }}"
                aria-label="{{ __('Download presentation') }}">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                </svg>
            </button>

            <span data-role="status-detail" class="hidden text-xs text-gray-500"></span>

        </div>

    </div>
@endif

