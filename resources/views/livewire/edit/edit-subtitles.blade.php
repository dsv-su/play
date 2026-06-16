<div class="mx-auto w-full">
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
        <div class="min-w-0 rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-300 sm:p-5">
            <h3 class="text-sm font-semibold text-slate-950 dark:text-white">{{__("Subtitle files")}}</h3>
            <p class="mt-1 mb-4 text-sm text-slate-500 dark:text-neutral-400">{{__("Review existing subtitles and staged subtitle uploads before saving.")}}</p>
            @include('livewire.edit.partials.form.subtitle-files')
        </div>
        <div class="min-w-0 rounded-lg border border-slate-200 bg-white p-4 text-sm text-slate-700 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-300 sm:p-5">
            <h3 class="text-sm font-semibold text-slate-950 dark:text-white">{{__("Upload subtitles")}}</h3>
            <p class="mt-1 mb-4 text-sm text-slate-500 dark:text-neutral-400">{{__("Add WebVTT files and assign language metadata when needed.")}}</p>

            <div x-data="fileUpload()">
            @include('livewire.edit.partials.form.subtitles-upload-progress')

                <div
                    class="relative flex cursor-pointer items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4 dark:border-neutral-700 dark:bg-neutral-900 sm:p-6"
                    x-on:drop="isDroppingFile = false"
                    x-on:drop.prevent="handleFileDrop($event)"
                    x-on:dragover.prevent="isDroppingFile = true"
                    x-on:dragleave.prevent="isDroppingFile = false"
                >
                    <!-- Overlay while dragging -->
                    <div
                        class="absolute inset-0 z-30 flex items-center justify-center rounded-lg bg-blue-600/90"
                        x-show="isDropping"
                    >
                        <span class="text-lg font-semibold text-white sm:text-xl">{{__("Release file to upload")}}</span>
                    </div>

                    <label class="flex w-full cursor-pointer flex-col items-center justify-center rounded-lg border border-slate-200 bg-white py-5 text-center shadow-sm hover:bg-slate-50 dark:border-neutral-700 dark:bg-neutral-950 dark:hover:bg-neutral-900"
                            for="file-upload">
                        <span class="inline-flex size-12 items-center justify-center rounded-full bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                              <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                   stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" x2="12" y1="3" y2="15"></line>
                              </svg>
                        </span>

                        <div class="mt-3 flex flex-col items-center text-center text-sm leading-6 text-slate-600 dark:text-neutral-300">
                                <span class="pe-1 font-medium text-slate-800 dark:text-neutral-200">
                                    {{ __("Drop your") }}
                                    <span class="font-semibold text-blue-700 dark:text-blue-300">
                                        {{ __("subtitle-files (WebVTT)") }}
                                    </span>
                                    {{ __("here or") }}
                                </span>
                                <span class="font-semibold text-blue-700 dark:text-blue-300">
                                    {{ __("browse") }}
                                </span>
                        </div>

                        <p class="mt-1 text-xs text-slate-400 dark:text-neutral-500">
                            {{__("Allowed file types: .vtt")}}
                        </p>
                    </label>

                    <input type="file" id="file-upload" multiple @change="handleFileSelect" class="hidden" />
                </div>

                <script>
                    function fileUpload() {
                        return {
                            isDropping: false,
                            isUploading: false,
                            progress: 0,
                            handleFileSelect(event) {
                                if (event.target.files.length) this.uploadFiles(event.target.files)
                            },
                            handleFileDrop(event) {
                                if (event.dataTransfer.files.length > 0) this.uploadFiles(event.dataTransfer.files)
                            },
                            uploadFiles(files) {
                                const $this = this;
                                this.isUploading = true
                            @this.uploadMultiple('files', files,
                                function () {
                                    $this.isUploading = false
                                    $this.progress = 0
                                    $this.files = []
                                },
                                function (error) { console.log('error', error) },
                                function (event) { $this.progress = event.detail.progress }
                            )
                            @this.checkToggle();
                            },
                            removeUpload(filename) { @this.removeUpload('files', filename); },
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</div>
