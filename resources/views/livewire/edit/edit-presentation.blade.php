<div>
    <fieldset class="w-full mb-2 bg-white border border-susecondary rounded-lg shadow-sm
          dark:bg-gray-800 dark:border-gray-700">
        <legend class="mx-auto px-2 text-xs uppercase text-blue-500 dark:text-blue-400 bg-white dark:bg-gray-800">
            {{__("Presentation")}}
        </legend>

        <div class="p-4 sm:p-6 md:p-8">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-[35%_65%] sm:gap-2 sm:mb-5">

                <!-- LEFT COLUMN: Image + Status -->
                <div class="flex flex-col items-stretch gap-0 w-full min-w-0">
                    <div class="relative aspect-video w-full overflow-hidden rounded-md">
                        <img
                            class="absolute inset-0 h-full w-full object-cover
                            @if($visibility == 'private' or $visibility == 'unlisted') opacity-20 @endif"
                            src="{{ $video->thumb . '?' . time() }}"
                            alt="Presentation Thumb">
                    </div>

                    <!-- Status row -->
                    <div class="flex flex-wrap items-center gap-2 mt-3 mb-3 text-sm">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('Status:') }}</span>
                        <span
                            class="border
                            @if($visibility == 'visible') border-blue-400 bg-blue-100 text-blue-800
                            @elseif($visibility == 'private') border-red-400 bg-red-100 text-red-800
                            @elseif($visibility == 'unlisted') border-yellow-400 bg-yellow-100 text-yellow-800
                            @endif
                                text-xs font-medium px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-blue-400">
                            {{ __($visibility) }}
                        </span>
                        <div class="flex items-center gap-x-3">
                            <label for="hs-xs-switch" class="relative inline-block w-9 h-5 cursor-pointer">
                                <input type="checkbox"
                                       wire:model.live="render_thumb"
                                       name="render_thumb"
                                       id="hs-xs-switch"
                                       class="peer sr-only">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-4 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                            </label>
                            <label for="hs-xs-switch" class="text-sm text-gray-500 dark:text-neutral-400">
                                @if($render_thumb)
                                    {{__("Regenerate thumbnail")}}
                                @else
                                    {{__("Keep original thumbnail")}}
                                @endif
                                    <button id="render-thumb-button" data-modal-toggle="render-thumb-modal" type="button"
                                            class="inline-flex items-center justify-center align-middle ml-1 size-5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus-visible:ring focus-visible:ring-primary-500">
                                        <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                            </label>
                        </div>

                    </div>

                    <!-- Img status message -->
                    <div class="w-full
                        @if($visibility == 'visible')
                            bg-blue-50 border border-blue-500 text-sm text-gray-600
                        @elseif($visibility == 'private')
                            bg-red-50 border border-red-500 text-sm text-red-600
                        @elseif($visibility == 'unlisted')
                            bg-yellow-50 border border-yellow-500 text-sm text-yellow-600
                        @endif
                        rounded-lg p-4 sm:p-5 dark:bg-blue-600/[.15]">

                        <div class="flex">
                            <div class="ms-0">
                                <h3 class="text-gray-700 font-semibold dark:font-medium dark:text-white leading-snug">
                                    @if($visibility == 'visible')
                                        {{ __('The presentation is visible, searchable and playable.') }}
                                    @elseif($visibility == 'private')
                                        {{ __('The presentation is hidden, not searchable or playable.') }}
                                    @elseif($visibility == 'unlisted')
                                        {{ __('The presentation is hidden, not searchable but playable with a direct link.') }}
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!-- End img message -->
                </div>

                <!-- RIGHT COLUMN: Grid List -->
                <div class="min-w-0">
                    <!-- Grid List -->
                    <div class="mt-4 sm:mt-5 grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-2">

                        <!-- Item -->
                        <div class="flex flex-col gap-y-1 min-w-0">
                            <label for="title_sv" class="font-sans mb-1.5 sm:mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('Title in Swedish') }}<span class="text-red-600"> *</span>
                                <button id="title-sv-button" data-modal-toggle="title-modal" type="button"
                                        class="inline-flex items-center justify-center align-middle ml-1 size-5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus-visible:ring focus-visible:ring-primary-500">
                                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            </label>

                            <div class="flex items-center gap-x-1.5">
                                <input id="title_sv"
                                       type="text"
                                       name="title"
                                       wire:model.live="title"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                              block w-full p-3 @if($type == 'complete') dark:bg-blue-900 @else dark:bg-gray-700 @endif
                                                dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                       value="{{ old('title') ? old('title') : $video->title ?? '' }}"
                                       placeholder="Title in swedish"
                                       @if($type == 'edit') required @else readonly @endif>
                                @error('name')
                                <p class="mt-2 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">
                                    {{ __('This is a required input') }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <!-- End Item -->

                        <!-- Item -->
                        <div class="flex flex-col gap-y-1 min-w-0">
                            <label for="title_en" class="font-sans mb-1.5 sm:mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('Title in English') }}<span class="text-red-600"> *</span>
                                <button id="title-en-button" data-modal-toggle="title-modal" type="button"
                                        class="inline-flex items-center justify-center align-middle ml-1 size-5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus-visible:ring focus-visible:ring-primary-500">
                                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            </label>

                            <div class="flex items-center gap-x-1.5">
                                <input id="title_en"
                                       type="text"
                                       name="title_en"
                                       wire:model.live="title_en"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                              block w-full p-3 @if($type == 'complete') dark:bg-blue-900 @else dark:bg-gray-700 @endif
                                           dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                       value="{{ old('title_en') ? old('title_en') : $video->title_en ?? '' }}"
                                       placeholder="Title in english"
                                       @if($type == 'edit') required @else readonly @endif>
                                @error('name')
                                <p class="mt-2 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">
                                    {{ __('This is a required input') }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <!-- End Item -->

                        <!-- Description -->
                        <div class="flex flex-col gap-y-1 col-span-1 sm:col-span-2 min-w-0">
                            <label for="description" class="font-sans mb-1.5 sm:mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('Description') }}
                                <button id="description-button" data-modal-toggle="description-modal" type="button"
                                        class="inline-flex items-center justify-center align-middle ml-1 size-5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus-visible:ring focus-visible:ring-primary-500">
                                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                              d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            </label>

                            <div class="flex">
                                <textarea id="description"
                                          name="description"
                                          wire:model.live="description"
                                        class="h-32 sm:h-24 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                               block w-full p-3 @if($type == 'complete') dark:bg-blue-900 @else dark:bg-gray-700 @endif
                                                dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Description">{{ old('description') ? old('description') : ($video->description ?? '') }}</textarea>
                            </div>
                        </div>

                        <!-- Partials -->
                        @include('livewire.edit.partials.form.recording-date')
                        @include('livewire.edit.partials.form.download-switch')
                    </div>
                </div><!-- end right column -->
            </div><!-- End Grid List -->
        </div>

    </fieldset>
    @include('manage.partials.visibility-section')
</div>
