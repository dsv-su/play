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

    <section class="rounded-lg border border-slate-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
        <div class="border-b border-slate-200 px-4 py-4 sm:px-6 dark:border-neutral-700">
            <h2 class="text-base font-semibold text-slate-950 dark:text-white">{{__("Presentation details")}}</h2>
            <p class="mt-1 text-sm text-slate-600 dark:text-neutral-400">{{__("Start with the information users see in search results, course pages, and the player.")}}</p>
        </div>

        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(18rem,24rem)_1fr]">
                <div class="min-w-0">
                    <div class="overflow-hidden rounded-lg border border-slate-200 bg-slate-100 shadow-sm dark:border-neutral-700 dark:bg-neutral-950">
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-200 dark:bg-neutral-800">
                            <img
                                class="absolute inset-0 h-full w-full object-cover @if($visibility == 'private' or $visibility == 'unlisted') opacity-30 @endif"
                                src="{{ $video->thumb . '?' . time() }}"
                                alt="{{ __('Presentation thumbnail') }}">
                        </div>

                        <div class="space-y-4 p-4">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-sm font-medium text-slate-700 dark:text-neutral-300">{{ __('Status') }}</span>
                                <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $visibilityStyle['badge'] }}">
                                    {{ __($visibility) }}
                                </span>
                            </div>

                            <div class="rounded-lg border p-3 text-sm leading-6 {{ $visibilityStyle['panel'] }}">
                                {{ $visibilityStyle['message'] }}
                            </div>

                            <div class="rounded-lg border border-slate-200 bg-white p-3 dark:border-neutral-700 dark:bg-neutral-900">
                                <div class="flex items-start gap-3">
                                    <label for="hs-xs-switch" class="relative mt-0.5 inline-block h-6 w-11 shrink-0 cursor-pointer">
                                        <input type="checkbox"
                                               wire:model.live="render_thumb"
                                               name="render_thumb"
                                               id="hs-xs-switch"
                                               class="peer sr-only">
                                        <span class="absolute inset-0 rounded-full bg-slate-200 transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500"></span>
                                        <span class="absolute start-0.5 top-1/2 size-5 -translate-y-1/2 rounded-full bg-white shadow-sm transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-300 dark:peer-checked:bg-white"></span>
                                    </label>

                                    <div class="min-w-0">
                                        <label for="hs-xs-switch" class="text-sm font-medium text-slate-900 dark:text-white">
                                            @if($render_thumb)
                                                {{__("Regenerate thumbnail")}}
                                            @else
                                                {{__("Keep original thumbnail")}}
                                            @endif
                                        </label>
                                        <p class="mt-1 text-sm text-slate-500 dark:text-neutral-400">
                                            {{ __("Choose whether the thumbnail should be recreated when saving.") }}
                                            <button id="render-thumb-button" data-modal-toggle="render-thumb-modal" type="button"
                                                    class="inline-flex size-5 items-center justify-center align-middle text-slate-500 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-neutral-400 dark:hover:text-white"
                                                    aria-label="{{ __('More info about thumbnail regeneration') }}">
                                                <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="min-w-0">
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div class="min-w-0">
                            <label for="title_sv" class="mb-2 block text-sm font-medium text-slate-900 dark:text-white">
                                {{ __('Title in Swedish') }}<span class="text-red-600"> *</span>
                                <button id="title-sv-button" data-modal-toggle="title-modal" type="button"
                                        class="inline-flex size-5 items-center justify-center align-middle text-slate-500 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-neutral-400 dark:hover:text-white"
                                        aria-label="{{ __('More info about titles') }}">
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            </label>

                            <input id="title_sv"
                                   type="text"
                                   name="title"
                                   wire:model.live="title"
                                   class="block w-full rounded-lg border-slate-300 bg-white p-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-white dark:placeholder:text-neutral-500"
                                   value="{{ old('title') ? old('title') : $video->title ?? '' }}"
                                   placeholder="{{ __('Title in Swedish') }}"
                                   @if($type == 'edit') required @else readonly @endif>
                            @error('title')
                            <p class="mt-2 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">
                                {{ __('This is a required input') }}
                            </p>
                            @enderror
                        </div>

                        <div class="min-w-0">
                            <label for="title_en" class="mb-2 block text-sm font-medium text-slate-900 dark:text-white">
                                {{ __('Title in English') }}<span class="text-red-600"> *</span>
                                <button id="title-en-button" data-modal-toggle="title-modal" type="button"
                                        class="inline-flex size-5 items-center justify-center align-middle text-slate-500 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-neutral-400 dark:hover:text-white"
                                        aria-label="{{ __('More info about titles') }}">
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            </label>

                            <input id="title_en"
                                   type="text"
                                   name="title_en"
                                   wire:model.live="title_en"
                                   class="block w-full rounded-lg border-slate-300 bg-white p-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-white dark:placeholder:text-neutral-500"
                                   value="{{ old('title_en') ? old('title_en') : $video->title_en ?? '' }}"
                                   placeholder="{{ __('Title in English') }}"
                                   @if($type == 'edit') required @else readonly @endif>
                            @error('title_en')
                            <p class="mt-2 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">
                                {{ __('This is a required input') }}
                            </p>
                            @enderror
                        </div>

                        <div class="min-w-0 sm:col-span-2">
                            <label for="description" class="mb-2 block text-sm font-medium text-slate-900 dark:text-white">
                                {{ __('Description') }}
                                <button id="description-button" data-modal-toggle="description-modal" type="button"
                                        class="inline-flex size-5 items-center justify-center align-middle text-slate-500 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-neutral-400 dark:hover:text-white"
                                        aria-label="{{ __('More info about descriptions') }}">
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                              d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            </label>

                            <textarea id="description"
                                      name="description"
                                      wire:model.live="description"
                                      class="block h-32 w-full rounded-lg border-slate-300 bg-white p-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-white dark:placeholder:text-neutral-500"
                                      placeholder="{{ __('Description') }}">{{ old('description') ? old('description') : ($video->description ?? '') }}</textarea>
                        </div>

                        @include('livewire.edit.partials.form.recording-date')
                        @include('livewire.edit.partials.form.download-switch')
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('manage.partials.visibility-section')
</div>
