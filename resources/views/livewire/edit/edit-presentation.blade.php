<div>
    <fieldset class="w-full mb-2 bg-white border border-susecondary rounded-lg shadow-sm
          dark:bg-gray-800 dark:border-gray-700">
        <legend class="mx-auto px-2 text-xs uppercase text-blue-500 dark:text-blue-400 bg-white dark:bg-gray-800">
            {{__("Presentation")}}
        </legend>

        <div class="p-4 sm:p-6 md:p-8">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-[35%_65%] sm:gap-2 sm:mb-5">

                <!-- LEFT COLUMN: Image + Status -->
                <div class="flex flex-col items-center gap-0">
                    <img class="p-4 rounded-sm w-full h-auto object-contain
                @if($visibility == 'private' or $visibility == 'unlisted') opacity-20
                @endif"
                         src="{{$video->thumb}}"
                         alt="Presentation Thumb">
                    <div class="flex mb-3">
                        {{__("Status:")}} &nbsp;
                        <span class="border
                    @if($visibility == 'visible') border-blue-400 bg-blue-100 text-blue-800
                    @elseif($visibility == 'private') border-red-400 bg-red-100 text-red-800
                    @elseif($visibility == 'unlisted') border-yellow-400 bg-yellow-100 text-yellow-800
                    @endif
                            text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-blue-400 ">
                        {{__("visible")}}</span>
                    </div>

                    <!-- Img status message -->
                    <div class="w-full max-w-sm mx-auto
                    @if($visibility == 'visible')
                        bg-blue-50 border border-blue-500 text-sm text-gray-500
                    @elseif($visibility == 'private')
                        bg-red-50 border border-red-500 text-sm text-red-500
                    @elseif($visibility == 'unlisted')
                        bg-yellow-50 border border-yellow-500 text-sm text-yellow-500
                    @endif
                        rounded-lg p-5 dark:bg-blue-600/[.15]">

                        <div class="flex">
                            <div class="ms-3">
                                <h3 class="text-gray-600 font-semibold dark:font-medium dark:text-white">
                                    @if($visibility == 'visible')
                                        {{__("The presentation is visible, searchable and playable.")}}
                                    @elseif($visibility == 'private')
                                        {{__("The presentation is hidden, not searchable or playable.")}}
                                    @elseif($visibility == 'unlisted')
                                        {{__("The presentation is hidden, not searchable but playable with a direct link.")}}
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!-- End img message -->
                </div>

                <!-- RIGHT COLUMN: Grid List -->
                <div>
                    <!-- Grid List -->
                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-2">
                        <!-- Item -->
                        <div class="flex flex-col gap-y-1">
                            <label for="title_sv" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ __("Title in Swedish") }}<span class="text-red-600"> *</span>
                                <button id="title-sv-button" data-modal-toggle="title-modal" class="inline" type="button">
                                    <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            </label>
                            <div class="flex items-center gap-x-1.5">

                                <input id="title_sv"
                                       type="text"
                                       name="title"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                            block w-full p-2.5 @if($type == 'complete') dark:bg-blue-900 @else dark:bg-gray-700 @endif
                                           dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                       value="{{ old('title') ? old('title') : $video->title ?? '' }}"
                                       placeholder="Title in swedish"
                                       @if($type == 'edit') required @else readonly @endif>
                                @error('name')
                                <p class="mt-3 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">
                                    {{ __("This is a required input") }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <!-- End Item -->

                        <!-- Item -->
                        <div class="flex flex-col gap-y-1">
                            <label for="title_en" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ __("Title in English") }}<span class="text-red-600"> *</span>
                                <button id="title-en-button" data-modal-toggle="title-modal" class="inline" type="button">
                                    <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            </label>

                            <div class="flex items-center gap-x-1.5">
                                <input id="title_en"
                                       type="text"
                                       name="title_en"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                            block w-full p-2.5 @if($type == 'complete') dark:bg-blue-900 @else dark:bg-gray-700 @endif
                                           dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                       value="{{ old('title_en') ? old('title_en') : $video->title_en ?? '' }}"
                                       placeholder="Title in english"
                                       @if($type == 'edit') required @else readonly @endif>
                                @error('name')
                                <p class="mt-3 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">
                                    {{ __("This is a required input") }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <!-- End Item -->

                        <!-- Description -->
                        <div class="flex flex-col gap-y-1 col-span-2">
                            <label for="description" class="font-sans mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ __("Description") }}
                                <button id="description-button" data-modal-toggle="description-modal" class="inline" type="button">
                                    <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                              d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            </label>

                            <div class="flex">
                            <textarea id="description"
                                      name="description"
                                      class="h-24 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                      block w-full p-2.5 @if($type == 'complete') dark:bg-blue-900 @else dark:bg-gray-700 @endif
                                          dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                      placeholder="Description">{{ old('description') ? old('description') : ($video->description ?? '') }}</textarea>
                            </div>
                        </div>

                        <!-- Item -->
                        @include('livewire.edit.partials.form.recording-date')
                        @include('livewire.edit.partials.form.download-switch')
                    </div>
                </div><!-- end right column -->
            </div><!-- End Grid List -->
        </div>
    </fieldset>
    @include('manage.partials.visibility-section')
</div>
