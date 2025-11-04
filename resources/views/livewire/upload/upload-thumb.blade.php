<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    [data-hs-file-upload-previews]:has(img[data-dz-thumbnail]) span {
        display: none;
    }
</style>
<div data-module="thumb-uploader"
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

    <!-- preview template can keep its <div> wrapper -->
    <template data-hs-file-upload-preview="">
        <div class="w-full h-full flex justify-center items-center">
            <img class="object-contain max-w-full max-h-full mx-auto" data-dz-thumbnail="">
        </div>
    </template>

    <!-- use a DIV as the preview container -->
    <div class="flex flex-col items-center gap-2">
        <div data-hs-file-upload-previews=""
             data-hs-file-upload-pseudo-trigger=""
             class="flex justify-center items-center size-48 border-2 border-dotted border-gray-300 text-gray-600 cursor-pointer hover:bg-gray-50 dark:border-neutral-700 dark:text-neutral-600 dark:hover:bg-neutral-700/50 relative overflow-hidden">
            <span class="absolute inset-0 flex items-center justify-center text-center">{{__('Thumb will be generated or Upload a custom thumbnail')}}</span>
        </div>

        <div class="flex items-center gap-x-2">
            <button type="button"
                    class="py-1 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg text-gray-900 hover:bg-blue-700 hover:text-white focus:outline-hidden focus:bg-blue-700 focus:text-white disabled:opacity-50 disabled:pointer-events-none"
                    data-hs-file-upload-trigger="">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" x2="12" y1="3" y2="15"></line>
                </svg>
                {{__('Upload custom thumb')}}
            </button>
            <button type="button"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-semibold bg-white text-gray-500 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    data-hs-file-upload-clear="">
                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"></path>
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                    <line x1="10" x2="10" y1="11" y2="17"></line>
                    <line x1="14" x2="14" y1="11" y2="17"></line>
                </svg>
            </button>
        </div>
    </div>
</div>
