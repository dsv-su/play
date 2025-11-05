<!-- Container: centers content and sets max width responsively -->
<div class="mx-auto w-full max-w-screen-xl px-1">
    <!-- Responsive grid -->
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
        <!-- Subtitles list -->
        <div class="min-w-0 bg-blue-50 border border-blue-500 text-sm text-gray-700 rounded-lg p-4 sm:p-5 lg:p-6 dark:bg-blue-600/[.15]">
            <h3 class="mb-3 text-base sm:text-lg font-semibold text-blue-700 dark:text-white">{{__("Subtitles list")}}</h3>
            @include('livewire.edit.partials.form.subtitle-files')
        </div>
        <!-- Upload -->
        <div class="min-w-0 border border-gray-300 text-sm text-gray-700 rounded-lg p-4 sm:p-5 lg:p-6 dark:bg-yellow-600/[.15]">
            <h3 class="mb-4 text-base sm:text-lg font-semibold text-blue-600 dark:text-white">{{__("Subtitles")}}</h3>

            <div x-data="fileUpload()">
            @include('livewire.edit.partials.form.subtitles-upload-progress')

            <!-- Dropzone -->
                <div
                    class="relative cursor-pointer p-4 sm:p-6 flex items-center justify-center bg-white border border-dashed border-gray-300 rounded-xl dark:bg-neutral-800 dark:border-neutral-600"
                    x-on:drop="isDroppingFile = false"
                    x-on:drop.prevent="handleFileDrop($event)"
                    x-on:dragover.prevent="isDroppingFile = true"
                    x-on:dragleave.prevent="isDroppingFile = false"
                >
                    <!-- Overlay while dragging -->
                    <div
                        class="absolute inset-0 z-30 flex items-center justify-center bg-blue-500/90"
                        x-show="isDropping"
                    >
                        <span class="text-2xl sm:text-3xl text-white">{{__("Release file to upload!")}}</span>
                    </div>

                    <label class="py-3 sm:py-4 flex flex-col items-center justify-center w-full bg-white dark:bg-neutral-800 border border-susecondary
                                    shadow cursor-pointer rounded-2xl hover:bg-slate-50 dark:hover:bg-neutral-700"
                            for="file-upload">
                        <span class="inline-flex justify-center items-center size-12 sm:size-16 bg-gray-100 text-gray-800 rounded-full dark:bg-neutral-700 dark:text-neutral-200">
                              <svg class="shrink-0 h-5 w-5 sm:h-6 sm:w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                   stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" x2="12" y1="3" y2="15"></line>
                              </svg>
                        </span>

                        <div class="mt-3 sm:mt-4 flex flex-col items-center text-center text-sm sm:text-base leading-6 text-gray-600 dark:text-neutral-300">
                                <span class="pe-1 font-medium text-gray-800 dark:text-neutral-200">
                                    {{ __("Drop your") }}
                                    <span class="bg-white dark:bg-neutral-800 font-semibold text-blue-600 dark:text-blue-500 hover:text-blue-700 dark:hover:text-blue-600 rounded-lg decoration-2 hover:underline focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2">
                                        {{ __("subtitle-files (WebVTT)") }}
                                    </span>
                                    {{ __("here or") }}
                                </span>
                                <span class="bg-white dark:bg-neutral-800 font-semibold text-blue-600 dark:text-blue-500 hover:text-blue-700 dark:hover:text-blue-600 rounded-lg decoration-2 hover:underline focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2">
                                    {{ __("browse") }}
                                </span>
                        </div>

                        <p class="mt-1 text-xs sm:text-sm text-gray-400 dark:text-neutral-400">
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
