<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    [data-module="thumb-uploader"] [data-hs-file-upload-previews]:has(img[data-dz-thumbnail]) [data-empty-thumb-placeholder] {
        display: none;
    }
</style>
<div data-module="thumb-uploader"
     role="group"
     aria-labelledby="thumbnail-upload-label"
     aria-describedby="thumbnail-upload-description"
     data-hs-file-upload='{
  "headers": { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
  "url": "thumb/upload?thumbdir={{$presentation->local}}",
  "acceptedFiles": "image/*",
  "paramName": "thumb",
  "maxFiles": 1,
  "parallelUploads": 1,
  "chunking": true,
  "forceChunking": true,
  "maxFilesize": 100,
  "parallelChunkUploads": false,
  "chunkSize": 2000000,
  "retryChunks": true,
  "retryChunksLimit": 5
}'>

    <template data-hs-file-upload-preview="">
        <div class="relative aspect-video w-full overflow-hidden">
            <img class="absolute inset-0 h-full w-full object-cover" data-dz-thumbnail="">
        </div>
    </template>

    <div class="space-y-3">
        <div data-hs-file-upload-previews=""
             data-hs-file-upload-pseudo-trigger=""
             role="button"
             tabindex="0"
             aria-labelledby="thumbnail-upload-label"
             aria-describedby="thumbnail-upload-description"
             onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); this.click(); }"
             class="relative flex aspect-video w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg border border-dashed border-slate-300 bg-slate-50 text-center transition hover:border-blue-400 hover:bg-blue-50/60 focus:outline-none focus-visible:border-blue-500 focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20 dark:border-neutral-700 dark:bg-neutral-900 dark:hover:border-blue-500 dark:hover:bg-blue-950/30 dark:focus-visible:ring-offset-neutral-950">
            <div data-empty-thumb-placeholder class="absolute inset-0 flex flex-col items-center justify-center p-4">
                <span class="inline-flex size-11 items-center justify-center rounded-full bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2.5M7 10l5-5m0 0 5 5m-5-5v12" />
                    </svg>
                </span>
                <span id="thumbnail-upload-label" class="mt-3 text-sm font-medium text-slate-800 dark:text-neutral-100">{{ __('Drop an image here or browse') }}</span>
                <span id="thumbnail-upload-description" class="mt-1 text-xs text-slate-500 dark:text-neutral-400">{{ __('A thumbnail can also be generated automatically.') }}</span>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button type="button"
                    class="inline-flex min-h-9 items-center justify-center gap-x-2 rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white disabled:pointer-events-none disabled:opacity-50 dark:bg-blue-500 dark:hover:bg-blue-400 dark:focus-visible:ring-offset-neutral-950"
                    data-hs-file-upload-trigger="">
                <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" x2="12" y1="3" y2="15"></line>
                </svg>
                {{ __('Upload thumbnail') }}
            </button>
            <button type="button"
                    class="inline-flex size-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-white"
                    data-hs-file-upload-clear=""
                    aria-label="{{ __('Remove thumbnail') }}">
                <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M3 6h18"></path>
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                    <line x1="10" x2="10" y1="11" y2="17"></line>
                    <line x1="14" x2="14" y1="11" y2="17"></line>
                </svg>
            </button>
        </div>

        <p class="text-xs leading-5 text-slate-500 dark:text-neutral-400">
            {{ __('JPG, PNG, or WebP. Recommended 16:9.') }}
        </p>
    </div>
</div>
