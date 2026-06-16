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
                    <h2 class="text-base font-semibold text-slate-950 dark:text-white">{{__("Presentation details")}}</h2>
                    <p class="mt-1 text-sm text-slate-600 dark:text-neutral-400">{{__("Start with the information users see in search results, course pages, and the player.")}}</p>
                </div>

                <span class="inline-flex w-fit items-center rounded-md border px-3 py-1 text-xs font-semibold {{ $visibilityStyle['badge'] }}">
                    {{ __($visibility) }}
                </span>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(19rem,25rem)_1fr]">
                <div class="min-w-0">
                    <div class="overflow-hidden rounded-lg border border-susecondary bg-white shadow-sm dark:border-susecondary dark:bg-neutral-950">
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-200 dark:bg-neutral-800">
                            <img
                                class="absolute inset-0 h-full w-full object-cover @if($visibility == 'private' or $visibility == 'unlisted') opacity-30 @endif"
                                src="{{ $video->thumb . '?' . time() }}"
                                alt="{{ __('Presentation thumbnail') }}">

                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/75 to-transparent p-3">
                                <span class="inline-flex items-center rounded-md border border-white/20 bg-white/90 px-2.5 py-1 text-xs font-semibold text-slate-900 shadow-sm dark:bg-neutral-950/90 dark:text-white">
                                    {{ __('Thumbnail') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 p-4"
                             x-data="{
                                 fileName: '',
                                 preview: '',
                                 isDropping: false,
                                 setFile(file) {
                                     if (!file) return;
                                     this.fileName = file.name;
                                     if (this.preview) URL.revokeObjectURL(this.preview);
                                     this.preview = URL.createObjectURL(file);
                                 }
                             }">
                            <div class="rounded-lg border p-3 {{ $visibilityStyle['panel'] }}">
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 inline-flex size-5 shrink-0 items-center justify-center rounded-full bg-white/70 dark:bg-neutral-950/40">
                                        <svg class="size-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold">{{ __('Visibility status') }}</p>
                                        <p class="mt-1 text-sm leading-6">{{ $visibilityStyle['message'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <div x-show="!fileName"
                                 x-cloak
                                 x-transition
                                 class="rounded-lg border border-slate-200 bg-slate-50 p-3 dark:border-neutral-700 dark:bg-neutral-900">
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

                            <div wire:ignore
                                 class="rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-neutral-700 dark:bg-neutral-900">
                                <div class="mb-3 flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <h3 class="text-sm font-semibold text-slate-950 dark:text-white">{{ __('Custom thumbnail') }}</h3>
                                        <p class="mt-1 text-sm text-slate-500 dark:text-neutral-400">{{ __('Upload an image to replace the generated thumbnail for this edit.') }}</p>
                                    </div>
                                </div>

                                <label for="custom-thumb-upload"
                                       class="relative flex min-h-36 cursor-pointer flex-col items-center justify-center overflow-hidden rounded-lg border border-dashed border-slate-300 bg-white p-4 text-center transition hover:border-blue-400 hover:bg-blue-50/60 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20 dark:border-neutral-700 dark:bg-neutral-950 dark:hover:border-blue-500 dark:hover:bg-blue-950/30"
                                       x-on:dragover.prevent="isDropping = true"
                                       x-on:dragleave.prevent="isDropping = false"
                                       x-on:drop.prevent="
                                           isDropping = false;
                                           if ($event.dataTransfer.files.length) {
                                               $refs.customThumb.files = $event.dataTransfer.files;
                                               setFile($event.dataTransfer.files[0]);
                                           }
                                       ">
                                    <span class="absolute inset-0 hidden items-center justify-center bg-blue-600/90 text-sm font-semibold text-white"
                                          x-bind:class="{ 'flex': isDropping, 'hidden': !isDropping }">
                                        {{ __('Drop image to upload') }}
                                    </span>

                                    <template x-if="preview">
                                        <img x-bind:src="preview" alt="" class="absolute inset-0 h-full w-full object-cover">
                                    </template>

                                    <span class="relative z-10 inline-flex size-11 items-center justify-center rounded-full bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2.5M7 10l5-5m0 0 5 5m-5-5v12" />
                                        </svg>
                                    </span>
                                    <span class="relative z-10 mt-3 text-sm font-medium text-slate-800 dark:text-neutral-100" x-text="fileName || @js(__('Drop an image here or browse'))"></span>
                                    <span class="relative z-10 mt-1 text-xs text-slate-500 dark:text-neutral-400">{{ __('JPG, PNG, or WebP. Recommended 16:9.') }}</span>
                                </label>

                                <input id="custom-thumb-upload"
                                       x-ref="customThumb"
                                       type="file"
                                       name="custom_thumb"
                                       accept="image/jpeg,image/png,image/webp"
                                       class="sr-only"
                                       x-on:change="setFile($event.target.files[0])">

                                @error('custom_thumb')
                                <p class="mt-2 text-sm leading-6 text-red-600">{{ $message }}</p>
                                @enderror
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
                                          x-ref="description"
                                          x-on:input="updateDescriptionLength()"
                                          wire:model.live="description"
                                          class="block h-32 w-full rounded-lg border-slate-300 bg-white p-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-white dark:placeholder:text-neutral-500"
                                          placeholder="{{ __('Description') }}">{{ old('description') ? old('description') : ($video->description ?? '') }}</textarea>
                                <p class="mt-1 text-xs">
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
