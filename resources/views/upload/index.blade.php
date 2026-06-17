@extends('layouts.app')
@section('content')
    @include('dsvheader')
    @include('navbar.navbar')
    <div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 md:pb-8 space-y-4">
        <section class="bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <div class="px-4 py-8 mx-auto overflow-x-hidden">
                @include('livewire.edit.partials.form.edit-banner')
                {{--}}@include('livewire.edit.partials.form.form_title'){{--}}
                <form id="presentation-upload-Form" method="post" action="{{route('presentation.upload_step1', $presentation)}}">
                    @csrf
                    <!-- Section: Meta -->
                    <livewire:upload.upload-meta :presentation="$presentation" />

                    <!--Section: Course -->
                    @include('manage.partials.course-section')

                    <!--Section: Presenters -->
                    @include('manage.partials.presenter-section')

                    <!--Section: Tags -->
                    @include('manage.partials.tag-section')

                    <!--Section: Permissions -->
                    @include('manage.partials.permission-section')

                    <!--Section: Mediafiles -->
                    @include('upload.partials.media-section')

                    <!--Section: Subtitles -->
                    @include('manage.partials.subtitles-section')
                </form>

            </div>
        </section>
    </div>
    @include('manage.partials.savebar')
    @include('livewire.edit.partials.form.modal')
    @include('layouts.darktoggler')
    @push('scripts')
        <script>
            (() => {
                const ready = (callback) => {
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', callback, { once: true });
                    } else {
                        callback();
                    }
                };

                ready(() => {
                    const form = document.getElementById('presentation-upload-Form');
                    const saveButton = document.getElementById('presentation-save-button');
                    const uploader = document.getElementById('hs-file-upload');

                    if (
                        !(form instanceof HTMLFormElement) ||
                        !(saveButton instanceof HTMLButtonElement) ||
                        !(uploader instanceof HTMLElement)
                    ) {
                        return;
                    }

                    let uploadedFiles = Number.parseInt(uploader.dataset.uploadedFiles || '0', 10) || 0;
                    const completedFiles = new WeakSet();
                    const uploadStatus = document.getElementById('media-upload-status');

                    const announceUploadStatus = (message) => {
                        if (uploadStatus) {
                            uploadStatus.textContent = message;
                        }
                    };

                    const hasRequiredValues = () => {
                        const requiredControls = Array.from(form.querySelectorAll('[required]'))
                            .filter((control) => !control.disabled);

                        return requiredControls.every((control) => {
                            if (control.type === 'checkbox' || control.type === 'radio') {
                                return form.querySelector(`[name="${CSS.escape(control.name)}"]:checked`) !== null;
                            }

                            return control.checkValidity();
                        });
                    };

                    const updateSaveState = () => {
                        saveButton.disabled = !(uploadedFiles > 0 && hasRequiredValues());
                    };

                    const normalizeResponse = (response) => {
                        if (typeof response !== 'string') return response || {};

                        try {
                            return JSON.parse(response);
                        } catch {
                            return {};
                        }
                    };

                    const payloadFromFile = (file, response, xhr) => {
                        const candidates = [
                            response,
                            xhr?.responseText,
                            file?.xhr?.responseText,
                            ...(file?.upload?.chunks || []).map((chunk) => chunk?.response),
                        ];

                        for (const candidate of candidates) {
                            const payload = normalizeResponse(candidate);

                            if (Number(payload?.done) >= 100 || payload?.name) {
                                return payload;
                            }
                        }

                        return {};
                    };

                    const markFileComplete = (file, payload = {}) => {
                        if (completedFiles.has(file)) return;

                        if (Number(payload?.done) >= 100 || payload?.name || file.status === 'success') {
                            completedFiles.add(file);
                            uploadedFiles += 1;
                            uploader.dataset.uploadedFiles = String(uploadedFiles);
                            announceUploadStatus(@js(__('Media file upload complete.')));
                            updateSaveState();
                        }
                    };

                    const attachDropzoneListeners = () => {
                        const instance = window.HSFileUpload?.getInstance(uploader, true);
                        const dropzone = instance?.element?.dropzone;

                        if (!dropzone || dropzone.__uploadFormSaveStateBound) {
                            updateSaveState();
                            return Boolean(dropzone);
                        }

                        dropzone.__uploadFormSaveStateBound = true;

                        dropzone.on('success', (file, response, xhr) => {
                            markFileComplete(file, payloadFromFile(file, response, xhr));
                        });

                        dropzone.on('complete', (file) => {
                            if (completedFiles.has(file)) {
                                return;
                            }

                            markFileComplete(file, payloadFromFile(file));
                        });

                        dropzone.on('removedfile', (file) => {
                            if (completedFiles.has(file)) {
                                completedFiles.delete(file);
                                uploadedFiles = Math.max(0, uploadedFiles - 1);
                                uploader.dataset.uploadedFiles = String(uploadedFiles);
                                announceUploadStatus(@js(__('Media file removed.')));
                            }

                            updateSaveState();
                        });

                        dropzone.on('error', () => {
                            announceUploadStatus(@js(__('Media file upload failed.')));
                            updateSaveState();
                        });
                        dropzone.on('canceled', () => {
                            announceUploadStatus(@js(__('Media file upload canceled.')));
                            updateSaveState();
                        });
                        updateSaveState();

                        return true;
                    };

                    form.addEventListener('input', updateSaveState);
                    form.addEventListener('change', updateSaveState);
                    document.addEventListener('livewire:navigated', updateSaveState);

                    form.addEventListener('submit', (event) => {
                        updateSaveState();

                        if (saveButton.disabled) {
                            event.preventDefault();
                            form.reportValidity();
                        }
                    });

                    let attempts = 0;
                    const waitForUploader = () => {
                        attempts += 1;

                        if (attachDropzoneListeners() || attempts >= 40) return;

                        window.setTimeout(waitForUploader, 100);
                    };

                    waitForUploader();
                    updateSaveState();
                });
            })();
        </script>
    @endpush
@endsection
