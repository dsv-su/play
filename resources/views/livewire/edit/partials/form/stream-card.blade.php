<div class="space-y-4 p-4">
    <div class="flex items-center justify-between gap-2">
        <h3 class="truncate text-sm font-semibold text-slate-950 dark:text-white">
            {{ $stream['title'] }}
        </h3>
        @if($stream['hidden'])
            <span class="rounded-full border border-red-200 bg-red-50 px-2.5 py-1 text-[0.7rem] font-semibold text-red-700 dark:border-red-900/70 dark:bg-red-950 dark:text-red-300">
                {{__("Hidden")}}
            </span>
        @else
            <span class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[0.7rem] font-semibold text-emerald-700 dark:border-emerald-900/70 dark:bg-emerald-950 dark:text-emerald-300">
                {{__("Live")}}
            </span>
        @endif

    </div>
    <div class="grid grid-cols-2 gap-3">
        <div class="rounded-lg border border-slate-200 bg-slate-50 p-3 dark:border-neutral-700 dark:bg-neutral-900">
            <label for="hs-xs-switch-{{ $key }}" class="relative inline-block h-5 w-9 cursor-pointer">
                <input
                    type="checkbox"
                    name="audio[{{$stream['title']}}]"
                    id="hs-xs-switch-{{ $key }}"
                    class="peer sr-only"
                    wire:model.live="audio.{{ $key }}"
                >
                <span class="absolute inset-0 rounded-full bg-slate-200 transition-colors peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500"></span>
                <span class="absolute start-0.5 top-1/2 size-4 -translate-y-1/2 rounded-full bg-white shadow-sm transition-transform peer-checked:translate-x-full dark:bg-neutral-300 dark:peer-checked:bg-white"></span>
            </label>
            <label for="hs-xs-switch-{{ $key }}" class="mt-2 block text-xs font-medium text-slate-600 dark:text-neutral-400">{{__("Audio")}}</label>
        </div>

        <div class="rounded-lg border border-slate-200 bg-slate-50 p-3 dark:border-neutral-700 dark:bg-neutral-900">
            <label for="hs-xs-switch-visibility-{{ $key }}" class="relative inline-block h-5 w-9 cursor-pointer">
                <input
                    type="checkbox"
                    name="streamVisibility[{{$stream['title']}}]"
                    id="hs-xs-switch-visibility-{{ $key }}"
                    class="peer sr-only"
                    wire:model.live="streamVisibility.{{ $key }}"
                >
                <span class="absolute inset-0 rounded-full bg-slate-200 transition-colors peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500"></span>
                <span class="absolute start-0.5 top-1/2 size-4 -translate-y-1/2 rounded-full bg-white shadow-sm transition-transform peer-checked:translate-x-full dark:bg-neutral-300 dark:peer-checked:bg-white"></span>
            </label>
            <label for="hs-xs-switch-visibility-{{ $key }}" class="mt-2 block text-xs font-medium text-slate-600 dark:text-neutral-400">{{__("Hidden")}}</label>
        </div>
    </div>

    <div wire:ignore
         data-edit-stream-uploader
         data-stream-id="{{ $stream['id'] }}"
         data-hs-file-upload='{
  "url": "{{ route('presentation.stream-upload', $video, false) }}?edit_presentation_id={{ $editPresentationId }}&stream_id={{ $stream['id'] }}",
  "headers": { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
  "acceptedFiles": "video/*",
  "parallelUploads": 1,
  "maxFiles": 1,
  "chunking": true,
  "forceChunking": true,
  "maxFilesize": 5000,
  "parallelChunkUploads": false,
  "chunkSize": 2000000,
  "retryChunks": true,
  "retryChunksLimit": 5,
  "createImageThumbnails": false,
  "paramName": "file",
  "autoHideTrigger": false,
  "extensions": {
    "default": { "class": "shrink-0 size-5" },
    "mp4": { "class": "shrink-0 size-5" },
    "mov": { "class": "shrink-0 size-5" },
    "m4v": { "class": "shrink-0 size-5" },
    "webm": { "class": "shrink-0 size-5" }
  }
}'>
        <template data-hs-file-upload-preview>
            <div class="mt-3 rounded-lg border border-slate-200 bg-slate-50 p-3 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="mb-1 flex items-center justify-between gap-3 text-xs text-slate-600 dark:text-neutral-400">
                    <div class="min-w-0">
                        <div class="truncate text-sm font-medium text-slate-800 dark:text-neutral-100" data-dz-name></div>
                        <div class="text-xs text-slate-500 dark:text-neutral-400" data-dz-size></div>
                    </div>
                    <span class="shrink-0 text-sm text-slate-800 dark:text-white">
                        <span data-hs-file-upload-progress-bar-value>0</span>%
                    </span>
                </div>
                <div class="h-2 overflow-hidden rounded-full bg-slate-200 dark:bg-neutral-800"
                     role="progressbar"
                     aria-valuenow="0"
                     aria-valuemin="0"
                     aria-valuemax="100"
                     data-hs-file-upload-progress-bar>
                    <div class="h-full w-0 rounded-full bg-blue-600 transition-all duration-300 hs-file-upload-complete:bg-green-500"
                         data-hs-file-upload-progress-bar-pane></div>
                </div>
            </div>
        </template>

        <div data-stream-dropzone
             data-hs-file-upload-trigger
             class="relative flex min-h-28 cursor-pointer flex-col items-center justify-center overflow-hidden rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4 text-center transition hover:border-blue-400 hover:bg-blue-50/60 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20 dark:border-neutral-700 dark:bg-neutral-900 dark:hover:border-blue-500 dark:hover:bg-blue-950/30">
            <span class="absolute inset-0 hidden items-center justify-center bg-blue-600/90 text-sm font-semibold text-white"
                  data-stream-drop-overlay>
                {{ __('Drop video to upload') }}
            </span>

            <span class="relative z-10 inline-flex size-10 items-center justify-center rounded-full bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2.5M7 10l5-5m0 0 5 5m-5-5v12" />
                </svg>
            </span>
            <span class="relative z-10 mt-3 max-w-full truncate text-sm font-medium text-slate-800 dark:text-neutral-100"
                  data-stream-file-name>{{ __('Drop a replacement stream here or browse') }}</span>
            <span class="relative z-10 mt-1 text-xs text-slate-500 dark:text-neutral-400">{{ __('MP4, MOV, M4V, or WebM.') }}</span>
        </div>

        <div data-hs-file-upload-previews></div>

        <input type="hidden"
               data-uploaded-stream-path
               name="uploaded_stream[{{ $stream['id'] }}][video]"
               value="">

        <div class="mt-3 hidden" data-stream-upload-status>
            <div class="mb-1 flex items-center justify-between gap-3 text-xs text-slate-600 dark:text-neutral-400">
                <span class="inline-flex items-center gap-2">
                    <span class="size-3 animate-spin rounded-full border-2 border-blue-600 border-t-transparent" data-stream-upload-spinner></span>
                    <span data-stream-upload-label>{{ __('Uploading') }}</span>
                </span>
                <span class="inline-flex items-center gap-2">
                    <button type="button"
                            class="hidden text-xs font-semibold text-slate-600 underline-offset-2 hover:text-slate-950 hover:underline dark:text-neutral-400 dark:hover:text-white"
                            data-stream-replacement-cancel>
                        {{ __('Cancel') }}
                    </button>
                    <span data-stream-upload-percent>0%</span>
                </span>
            </div>
            <div class="h-2 overflow-hidden rounded-full bg-slate-200 dark:bg-neutral-800">
                <div class="h-full w-0 rounded-full bg-blue-600 transition-all duration-300" data-stream-upload-bar></div>
            </div>
        </div>

        <p class="mt-2 hidden text-sm leading-6 text-red-600" data-stream-upload-error></p>

        @error('uploaded_stream.' . $stream['id'] . '.video')
        <p class="mt-2 text-sm leading-6 text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
