<div
    data-widget="download-status"
    data-video-id="{{ $video->id }}"
    data-start-url="{{ route('presentation.download', $video) }}"      {{-- GET: enqueue job --}}
    data-status-url="{{ route('presentation.download.status', $video) }}"{{-- GET: progress JSON --}}
    data-download-url="{{ route('zip.download', $video) }}"             {{-- GET: final file --}}
    class="max-w-xl space-y-3 border rounded-xl p-4 mb-6"
>
    <div class="flex items-center justify-between">
        <span class="text-sm font-medium text-gray-700">Video #{{ $video->id }} — Preparation</span>
        <span data-role="status-text" class="text-xs text-gray-500">Idle</span>
    </div>

    <div class="w-full bg-gray-200/80 dark:bg-gray-800/60 rounded-full h-3 overflow-hidden">
        <div data-role="progress-bar" class="h-3 bg-blue-600 transition-[width] duration-500 ease-out" style="width:0%"></div>
    </div>

    <div class="flex items-center gap-3">

        <span data-role="status-detail" class="text-xs text-gray-500"></span>
    </div>
</div>


