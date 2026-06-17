<div>
    @php
        $visibilityStyles = [
            'visible' => [
                'badge' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-900/70 dark:bg-emerald-950 dark:text-emerald-300',
                'panel' => 'border-emerald-200 bg-emerald-50 text-emerald-900 dark:border-emerald-900/70 dark:bg-emerald-950/50 dark:text-emerald-100',
                'message' => __('The presentation is visible, searchable and playable.'),
            ],
            'private' => [
                'badge' => 'border-red-200 bg-red-50 text-red-700 dark:border-red-900/70 dark:bg-red-950 dark:text-red-300',
                'panel' => 'border-red-200 bg-red-50 text-red-900 dark:border-red-900/70 dark:bg-red-950/50 dark:text-red-100',
                'message' => __('The presentation is hidden, not searchable or playable.'),
            ],
            'unlisted' => [
                'badge' => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-900/70 dark:bg-amber-950 dark:text-amber-300',
                'panel' => 'border-amber-200 bg-amber-50 text-amber-900 dark:border-amber-900/70 dark:bg-amber-950/50 dark:text-amber-100',
                'message' => __('The presentation is hidden, not searchable but playable with a direct link.'),
            ],
        ];

        $visibilityStyle = $visibilityStyles[$visibility] ?? $visibilityStyles['private'];
    @endphp

    <section class="overflow-hidden rounded-lg border border-susecondary bg-white shadow-sm dark:border-susecondary dark:bg-neutral-900">
        <div class="border-b border-slate-200 bg-slate-50 px-4 py-4 sm:px-6 dark:border-neutral-700 dark:bg-neutral-950/60">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="min-w-0">
                    <h2 class="text-base font-semibold text-slate-950 dark:text-white">{{ __("Presentation details") }}</h2>
                    <p class="mt-1 text-sm text-slate-600 dark:text-neutral-400">{{ __("Start with the information users see in search results, course pages, and the player.") }}</p>
                </div>

                <span class="inline-flex w-fit items-center rounded-md border px-3 py-1 text-xs font-semibold {{ $visibilityStyle['badge'] }}"
                      role="status"
                      aria-live="polite">
                    {{ __($visibility) }}
                </span>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(19rem,25rem)_1fr]">
                <div class="min-w-0">
                    <div class="overflow-hidden rounded-lg border border-susecondary bg-white shadow-sm dark:border-susecondary dark:bg-neutral-950">
                        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900">
                            <h3 class="text-sm font-semibold text-slate-950 dark:text-white">{{ __('Thumbnail') }}</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-neutral-400">{{ __('Upload a custom thumbnail or let one be generated.') }}</p>
                        </div>

                        <div class="flex flex-col gap-4 p-4">
                            @include('livewire.upload.upload-thumb')

                            <div class="rounded-lg border p-3 {{ $visibilityStyle['panel'] }}">
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 inline-flex size-5 shrink-0 items-center justify-center rounded-full bg-white/70 dark:bg-neutral-950/40">
                                        <svg class="size-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold">{{ __('Visibility status') }}</p>
                                        <p class="mt-1 text-sm leading-6" role="status" aria-live="polite">{{ $visibilityStyle['message'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="min-w-0">
                    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-neutral-950 sm:p-5">
                        <div class="mb-5 border-b border-slate-200 pb-4 dark:border-neutral-800">
                            <h3 class="text-sm font-semibold text-slate-950 dark:text-white">{{ __('Presentation information') }}</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-neutral-400">{{ __('Keep titles concise and add the metadata needed for search and playback.') }}</p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div class="min-w-0">
                                <div class="mb-2 flex items-center gap-1">
                                    <label for="title_sv" class="block text-sm font-medium text-slate-900 dark:text-white">
                                        {{ __('Title in Swedish') }}<span class="text-red-600"> *</span>
                                    </label>
                                    <button id="title-sv-button" data-modal-toggle="title-modal" type="button"
                                            class="inline-flex size-5 items-center justify-center align-middle text-slate-500 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-neutral-400 dark:hover:text-white"
                                            aria-label="{{ __('More info about titles') }}">
                                        <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                                </div>

                                <input id="title_sv"
                                       type="text"
                                       name="title"
                                       class="block w-full rounded-lg border-slate-300 bg-white p-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-white dark:placeholder:text-neutral-500"
                                       value="{{ old('title') ? old('title') : $presentation->title ?? '' }}"
                                       placeholder="{{ __('Title in Swedish') }}"
                                       aria-invalid="@error('title') true @else false @enderror"
                                       @error('title') aria-describedby="title-sv-error" @enderror
                                       required>
                                @error('title')
                                <p id="title-sv-error" class="mt-2 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">
                                    {{ __('This is a required input') }}
                                </p>
                                @enderror
                            </div>

                            <div class="min-w-0">
                                <div class="mb-2 flex items-center gap-1">
                                    <label for="title_en" class="block text-sm font-medium text-slate-900 dark:text-white">
                                        {{ __('Title in English') }}<span class="text-red-600"> *</span>
                                    </label>
                                    <button id="title-en-button" data-modal-toggle="title-modal" type="button"
                                            class="inline-flex size-5 items-center justify-center align-middle text-slate-500 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-neutral-400 dark:hover:text-white"
                                            aria-label="{{ __('More info about titles') }}">
                                        <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                                </div>

                                <input id="title_en"
                                       type="text"
                                       name="title_en"
                                       class="block w-full rounded-lg border-slate-300 bg-white p-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-white dark:placeholder:text-neutral-500"
                                       value="{{ old('title_en') ? old('title_en') : $presentation->title_en ?? '' }}"
                                       placeholder="{{ __('Title in English') }}"
                                       aria-invalid="@error('title_en') true @else false @enderror"
                                       @error('title_en') aria-describedby="title-en-error" @enderror
                                       required>
                                @error('title_en')
                                <p id="title-en-error" class="mt-2 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">
                                    {{ __('This is a required input') }}
                                </p>
                                @enderror
                            </div>

                            <div class="min-w-0 sm:col-span-2"
                                 x-data="{
                                     descriptionLength: 0,
                                     maxDescriptionLength: 100,
                                     countCharacters(value) {
                                         if (!value) return 0;

                                         if (window.Intl && Intl.Segmenter) {
                                             return Array.from(new Intl.Segmenter(undefined, { granularity: 'grapheme' }).segment(value)).length;
                                         }

                                         return Array.from(value).length;
                                     },
                                     updateDescriptionLength() {
                                         this.descriptionLength = this.countCharacters(this.$refs.description.value);
                                     }
                                 }"
                                 x-init="updateDescriptionLength()">
                                <div class="mb-2 flex items-center gap-1">
                                    <label for="description" class="block text-sm font-medium text-slate-900 dark:text-white">
                                        {{ __('Description') }}
                                    </label>
                                    <button id="description-button" data-modal-toggle="description-modal" type="button"
                                            class="inline-flex size-5 items-center justify-center align-middle text-slate-500 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-neutral-400 dark:hover:text-white"
                                            aria-label="{{ __('More info about descriptions') }}">
                                        <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                                  d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                                </div>

                                <textarea id="description"
                                          name="description"
                                          x-ref="description"
                                          x-on:input="updateDescriptionLength()"
                                          class="block h-32 w-full rounded-lg border-slate-300 bg-white p-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-white dark:placeholder:text-neutral-500"
                                          aria-describedby="description-count"
                                          placeholder="{{ __('Description') }}">{{ old('description') ? old('description') : ($presentation->description ?? '') }}</textarea>
                                <p id="description-count" class="mt-1 text-xs" role="status" aria-live="polite">
                                    <span x-text="descriptionLength"
                                          x-bind:class="descriptionLength > maxDescriptionLength
                                              ? 'text-red-600 dark:text-red-400'
                                              : 'text-gray-500 dark:text-gray-300'"></span>/100
                                </p>
                            </div>

                            @include('livewire.edit.partials.form.recording-date')
                            @include('livewire.edit.partials.form.download-switch')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('manage.partials.visibility-section')
</div>
