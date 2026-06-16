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
            document.addEventListener('DOMContentLoaded', () => {
                const uploaders = document.querySelectorAll('[data-edit-stream-uploader]');
                const form = document.getElementById('presentation-edit-Form');
                const saveButton = document.getElementById('presentation-save-button');
                const saveStatus = document.getElementById('edit-stream-upload-status');
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const activeUploads = new Set();
                const chunkSize = 2000000;
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

                form?.addEventListener('submit', (event) => {
                    if (activeUploads.size === 0) {
                        return;
                    }

                    event.preventDefault();
                    setSaveState();
                });

                const uuid = () => {
                    if (window.crypto?.randomUUID) {
                        return window.crypto.randomUUID();
                    }

                    return `${Date.now()}-${Math.random().toString(16).slice(2)}`;
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
                    const poster = document.querySelector(`[data-stream-poster="${uploader.dataset.streamId}"]`);
                    const posterImage = poster?.querySelector('[data-stream-poster-image]');
                    const replacedOverlay = poster?.querySelector('[data-stream-replaced-overlay]');

                    spinner?.classList.add('hidden');
                    if (label) label.textContent = @js(__('Upload complete'));
                    if (pathInput) pathInput.value = response.video || '';
                    cancelButton?.classList.remove('hidden');
                    posterImage?.classList.add('blur-sm');
                    replacedOverlay?.classList.remove('hidden');
                    replacedOverlay?.classList.add('flex');
                    setProgress(uploader, 100);
                };

                const resetReplacement = (uploader) => {
                    const fileInput = uploader.querySelector('[data-stream-file-input]');
                    const fileName = uploader.querySelector('[data-stream-file-name]');
                    const pathInput = uploader.querySelector('[data-uploaded-stream-path]');
                    const status = uploader.querySelector('[data-stream-upload-status]');
                    const spinner = uploader.querySelector('[data-stream-upload-spinner]');
                    const label = uploader.querySelector('[data-stream-upload-label]');
                    const percent = uploader.querySelector('[data-stream-upload-percent]');
                    const bar = uploader.querySelector('[data-stream-upload-bar]');
                    const error = uploader.querySelector('[data-stream-upload-error]');
                    const cancelButton = uploader.querySelector('[data-stream-replacement-cancel]');
                    const poster = document.querySelector(`[data-stream-poster="${uploader.dataset.streamId}"]`);
                    const posterImage = poster?.querySelector('[data-stream-poster-image]');
                    const replacedOverlay = poster?.querySelector('[data-stream-replaced-overlay]');

                    if (fileInput) fileInput.value = '';
                    if (fileName) fileName.textContent = defaultDropText;
                    if (pathInput) pathInput.value = '';
                    status?.classList.add('hidden');
                    spinner?.classList.remove('hidden');
                    if (label) label.textContent = @js(__('Uploading'));
                    if (percent) percent.textContent = '0%';
                    if (bar) bar.style.width = '0%';
                    error?.classList.add('hidden');
                    cancelButton?.classList.add('hidden');
                    posterImage?.classList.remove('blur-sm');
                    replacedOverlay?.classList.add('hidden');
                    replacedOverlay?.classList.remove('flex');
                };

                const setUploadError = (uploader, message) => {
                    const error = uploader.querySelector('[data-stream-upload-error]');
                    const spinner = uploader.querySelector('[data-stream-upload-spinner]');
                    const label = uploader.querySelector('[data-stream-upload-label]');

                    spinner?.classList.add('hidden');
                    if (label) label.textContent = @js(__('Upload failed'));
                    if (error) {
                        error.textContent = message;
                        error.classList.remove('hidden');
                    }
                };

                const uploadFile = async (uploader, file) => {
                    if (!file) return;

                    const uploadId = uuid();
                    const streamId = uploader.dataset.streamId;
                    const uploadUrl = uploader.dataset.uploadUrl;
                    const draftId = uploader.dataset.draftId;
                    const totalChunks = Math.max(1, Math.ceil(file.size / chunkSize));
                    const fileName = uploader.querySelector('[data-stream-file-name]');
                    const error = uploader.querySelector('[data-stream-upload-error]');
                    const spinner = uploader.querySelector('[data-stream-upload-spinner]');
                    const label = uploader.querySelector('[data-stream-upload-label]');
                    const pathInput = uploader.querySelector('[data-uploaded-stream-path]');

                    if (fileName) fileName.textContent = file.name;
                    if (pathInput) pathInput.value = '';
                    error?.classList.add('hidden');
                    spinner?.classList.remove('hidden');
                    if (label) label.textContent = @js(__('Uploading'));

                    activeUploads.add(uploadId);
                    setSaveState();
                    setProgress(uploader, 0);

                    try {
                        let finalResponse = null;

                        for (let index = 0; index < totalChunks; index++) {
                            const start = index * chunkSize;
                            const end = Math.min(file.size, start + chunkSize);
                            const formData = new FormData();

                            formData.append('edit_presentation_id', draftId);
                            formData.append('stream_id', streamId);
                            formData.append('dzuuid', uploadId);
                            formData.append('dzchunkindex', index);
                            formData.append('dztotalchunkcount', totalChunks);
                            formData.append('dzchunksize', chunkSize);
                            formData.append('dzchunkbyteoffset', start);
                            formData.append('dztotalfilesize', file.size);
                            formData.append('file', file.slice(start, end), file.name);

                            const response = await fetch(uploadUrl, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                },
                                body: formData,
                            });

                            const contentType = response.headers.get('content-type') || '';

                            if (!response.ok) {
                                if (contentType.includes('application/json')) {
                                    const errorResponse = await response.json();
                                    throw new Error(errorResponse.message || @js(__('The upload could not be completed.')));
                                }

                                const errorText = await response.text();
                                throw new Error(errorText.slice(0, 160) || @js(__('The upload could not be completed.')));
                            }

                            if (!contentType.includes('application/json')) {
                                const responseText = await response.text();
                                throw new Error(responseText.slice(0, 160) || @js(__('The upload did not return JSON.')));
                            }

                            finalResponse = await response.json();
                            setProgress(uploader, finalResponse.done || ((index + 1) / totalChunks) * 100);
                        }

                        setUploadComplete(uploader, finalResponse || {});
                    } catch (error) {
                        setUploadError(uploader, error.message || @js(__('The upload could not be completed.')));
                    } finally {
                        activeUploads.delete(uploadId);
                        setSaveState();
                    }
                };

                uploaders.forEach((uploader) => {
                    const input = uploader.querySelector('[data-stream-file-input]');
                    const dropzone = uploader.querySelector('[data-stream-dropzone]');
                    const overlay = uploader.querySelector('[data-stream-drop-overlay]');
                    const cancelReplacement = uploader.querySelector('[data-stream-replacement-cancel]');

                    input?.addEventListener('change', (event) => {
                        uploadFile(uploader, event.target.files?.[0]);
                    });

                    cancelReplacement?.addEventListener('click', () => {
                        resetReplacement(uploader);
                    });

                    dropzone?.addEventListener('dragover', (event) => {
                        event.preventDefault();
                        overlay?.classList.remove('hidden');
                        overlay?.classList.add('flex');
                    });

                    dropzone?.addEventListener('dragleave', (event) => {
                        event.preventDefault();
                        overlay?.classList.add('hidden');
                        overlay?.classList.remove('flex');
                    });

                    dropzone?.addEventListener('drop', (event) => {
                        event.preventDefault();
                        overlay?.classList.add('hidden');
                        overlay?.classList.remove('flex');
                        uploadFile(uploader, event.dataTransfer.files?.[0]);
                    });
                });

                document.addEventListener('edit-stream-replacements:reset', () => {
                    uploaders.forEach(resetReplacement);
                });
            });
        </script>
    @endpush
@endonce
