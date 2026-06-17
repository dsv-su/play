<div>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
    @foreach ($streams as $key => $stream)
            <div class="w-full">
                <div class="flex h-full flex-col overflow-hidden rounded-lg border border-susecondary bg-white shadow-sm dark:border-susecondary dark:bg-neutral-950">
                    @include('livewire.edit.partials.form.stream-img')

                    @include('livewire.edit.partials.form.stream-card')
                </div>
            </div>
        @endforeach
    </div>
</div>

@once
    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                const uploaders = document.querySelectorAll('[data-edit-stream-uploader]');
                const form = document.getElementById('presentation-edit-Form');
                const saveButton = document.getElementById('presentation-save-button');
                const saveStatus = document.getElementById('edit-stream-upload-status');
                const activeUploads = new Set();
                const defaultDropText = @js(__('Drop a replacement stream here or browse'));

                const setSaveState = () => {
                    const isUploading = activeUploads.size > 0;

                    if (saveButton) {
                        saveButton.disabled = isUploading;
                        saveButton.classList.toggle('pointer-events-none', isUploading);
                    }

                    if (saveStatus) {
                        saveStatus.classList.toggle('hidden', !isUploading);
                    }
                };

                const posterParts = (uploader) => {
                    const poster = document.querySelector(`[data-stream-poster="${uploader.dataset.streamId}"]`);

                    return {
                        image: poster?.querySelector('[data-stream-poster-image]'),
                        overlay: poster?.querySelector('[data-stream-replaced-overlay]'),
                    };
                };

                const setProgress = (uploader, value) => {
                    const percent = Math.max(0, Math.min(100, Math.round(value)));
                    uploader.querySelector('[data-stream-upload-status]')?.classList.remove('hidden');
                    uploader.querySelector('[data-stream-upload-percent]').textContent = `${percent}%`;
                    uploader.querySelector('[data-stream-upload-bar]').style.width = `${percent}%`;
                };

                const setUploadComplete = (uploader, response) => {
                    const spinner = uploader.querySelector('[data-stream-upload-spinner]');
                    const label = uploader.querySelector('[data-stream-upload-label]');
                    const pathInput = uploader.querySelector('[data-uploaded-stream-path]');
                    const cancelButton = uploader.querySelector('[data-stream-replacement-cancel]');
                    const poster = posterParts(uploader);

                    spinner?.classList.add('hidden');
                    if (label) label.textContent = @js(__('Upload complete'));
                    if (pathInput) pathInput.value = response.video || '';
                    cancelButton?.classList.remove('hidden');
                    poster.image?.classList.add('blur-sm');
                    poster.overlay?.classList.remove('hidden');
                    poster.overlay?.classList.add('flex');
                    setProgress(uploader, 100);
                    activeUploads.delete(uploader.dataset.streamId);
                    setSaveState();
                };

                const getDropzone = (uploader) => {
                    const instance = window.HSFileUpload?.getInstance(uploader, true);

                    return instance?.element?.dropzone || instance?.dropzone || null;
                };

                const resetReplacement = (uploader, removeFiles = true) => {
                    const fileName = uploader.querySelector('[data-stream-file-name]');
                    const pathInput = uploader.querySelector('[data-uploaded-stream-path]');
                    const status = uploader.querySelector('[data-stream-upload-status]');
                    const spinner = uploader.querySelector('[data-stream-upload-spinner]');
                    const label = uploader.querySelector('[data-stream-upload-label]');
                    const percent = uploader.querySelector('[data-stream-upload-percent]');
                    const bar = uploader.querySelector('[data-stream-upload-bar]');
                    const error = uploader.querySelector('[data-stream-upload-error]');
                    const cancelButton = uploader.querySelector('[data-stream-replacement-cancel]');
                    const poster = posterParts(uploader);

                    if (removeFiles) {
                        getDropzone(uploader)?.removeAllFiles(true);
                    }

                    if (fileName) fileName.textContent = defaultDropText;
                    if (pathInput) pathInput.value = '';
                    status?.classList.add('hidden');
                    spinner?.classList.remove('hidden');
                    if (label) label.textContent = @js(__('Uploading'));
                    if (percent) percent.textContent = '0%';
                    if (bar) bar.style.width = '0%';
                    error?.classList.add('hidden');
                    cancelButton?.classList.add('hidden');
                    poster.image?.classList.remove('blur-sm');
                    poster.overlay?.classList.add('hidden');
                    poster.overlay?.classList.remove('flex');
                    activeUploads.delete(uploader.dataset.streamId);
                    setSaveState();
                };

                const setUploadError = (uploader, message) => {
                    const error = uploader.querySelector('[data-stream-upload-error]');
                    const spinner = uploader.querySelector('[data-stream-upload-spinner]');
                    const label = uploader.querySelector('[data-stream-upload-label]');

                    spinner?.classList.add('hidden');
                    if (label) label.textContent = @js(__('Upload failed'));
                    if (error) {
                        error.textContent = String(message || @js(__('The upload could not be completed.'))).slice(0, 180);
                        error.classList.remove('hidden');
                    }
                    activeUploads.delete(uploader.dataset.streamId);
                    setSaveState();
                };

                const parseResponse = (response) => {
                    if (!response) {
                        return {};
                    }

                    if (typeof response === 'string') {
                        try {
                            return JSON.parse(response);
                        } catch (_) {
                            return { message: response };
                        }
                    }

                    return response;
                };

                const payloadFromFile = (file, response, xhr) => {
                    const candidates = [
                        response,
                        xhr?.responseText,
                        file?.xhr?.responseText,
                        ...(file?.upload?.chunks || []).map((chunk) => chunk?.response),
                    ];

                    for (const candidate of candidates) {
                        const payload = parseResponse(candidate);

                        if (payload.video || payload.message || payload.error) {
                            return payload;
                        }
                    }

                    return {};
                };

                const bindUploader = (uploader) => {
                    const dropzone = getDropzone(uploader);

                    if (!dropzone || uploader.dataset.streamUploaderBound === 'true') {
                        return Boolean(dropzone);
                    }

                    uploader.dataset.streamUploaderBound = 'true';

                    dropzone.on('addedfile', (file) => {
                        uploader.querySelector('[data-stream-file-name]').textContent = file.name;
                        uploader.querySelector('[data-uploaded-stream-path]').value = '';
                        uploader.querySelector('[data-stream-upload-error]')?.classList.add('hidden');
                    });

                    dropzone.on('processing', () => {
                        activeUploads.add(uploader.dataset.streamId);
                        setProgress(uploader, 0);
                        setSaveState();
                    });

                    dropzone.on('uploadprogress', (_file, progress) => {
                        setProgress(uploader, progress);
                    });

                    dropzone.on('success', (file, response, xhr) => {
                        const payload = payloadFromFile(file, response, xhr);

                        if (payload.video) {
                            setUploadComplete(uploader, payload);
                        }
                    });

                    dropzone.on('complete', (file) => {
                        if (uploader.querySelector('[data-uploaded-stream-path]')?.value) {
                            return;
                        }

                        const payload = payloadFromFile(file);

                        if (payload.video) {
                            setUploadComplete(uploader, payload);
                            return;
                        }

                        if (file.status === 'success') {
                            setUploadError(uploader, @js(__('The upload finished but no video path was returned.')));
                        }
                    });

                    dropzone.on('error', (_file, message, xhr) => {
                        const payload = parseResponse(xhr?.responseText || message);
                        setUploadError(uploader, payload.message || payload.error || message);
                    });

                    dropzone.on('canceled', () => resetReplacement(uploader, false));
                    dropzone.on('removedfile', () => {
                        if (!uploader.querySelector('[data-uploaded-stream-path]')?.value) {
                            resetReplacement(uploader, false);
                        }
                    });

                    uploader.querySelector('[data-stream-replacement-cancel]')?.addEventListener('click', () => {
                        resetReplacement(uploader);
                    });

                    return true;
                };

                form?.addEventListener('submit', (event) => {
                    if (activeUploads.size === 0) {
                        return;
                    }

                    event.preventDefault();
                    setSaveState();
                });

                const interval = window.setInterval(() => {
                    const allBound = Array.from(uploaders).every(bindUploader);

                    if (allBound) {
                        window.clearInterval(interval);
                    }
                }, 100);

                document.addEventListener('edit-stream-replacements:reset', () => {
                    uploaders.forEach((uploader) => resetReplacement(uploader));
                });
            });
        </script>
    @endpush
@endonce
