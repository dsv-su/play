@php
    $subtitles = json_decode($video->subtitles ?? '[]', true);
    $defaultSubtitle = !empty($subtitles) ? array_key_first($subtitles) : null;
@endphp

<div
    x-data="shareModal({
        baseUrl: @js(url('/multiplayer')),
        videoId: @js($video->id),
        defaultSubtitle: @js($defaultSubtitle),
        thumbUrl: @js(asset($video->thumb)),
    })"
    x-id="['share-tooltip','share-title','static-link','embed-link']"
    @keydown.escape.window="modalOpen = false"
>
    <!-- Modal button -->
    <button type="button"
            @click="modalOpen = true"
            :data-tooltip-target="$id('share-tooltip')"
            aria-label="{{ __('Share :title', ['title' => $video->LangTitle]) }}"
            class="flex min-h-6 min-w-6 items-center justify-center rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none dark:focus-visible:ring-blue-500 dark:focus-visible:ring-offset-neutral-950">
        <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778"/>
        </svg>
    </button>

    <!-- Tooltip -->
    <div
        :id="$id('share-tooltip')"
        role="tooltip"
        class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
        {{ __("Share presentation") }}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>

    <!-- Modal -->
    <template x-teleport="body">
        <div x-show="modalOpen" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak>
            <div x-show="modalOpen" x-transition.opacity @click="modalOpen=false" class="absolute inset-0 w-full h-full bg-black/40" aria-hidden="true"></div>

            <div
                x-show="modalOpen"
                x-trap.inert.noscroll="modalOpen"
                x-transition
                role="dialog"
                aria-modal="true"
                :aria-labelledby="$id('share-title')"
                class="relative px-7 py-6 w-full bg-white text-gray-900 shadow-xl dark:bg-neutral-950 dark:text-white sm:max-w-lg sm:rounded-lg">
                <div class="flex justify-between items-center pb-2 mb-2">
                    <h3 :id="$id('share-title')" class="text-lg font-semibold">{{ __("Share a presentation") }}</h3>
                    <button type="button" @click="modalOpen=false" aria-label="{{ __('Close share dialog') }}" class="flex absolute top-0 right-0 justify-center items-center mt-5 mr-5 w-8 h-8 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-white dark:focus-visible:ring-blue-500 dark:focus-visible:ring-offset-neutral-950">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Buttons -->
                <div class="space-y-4">
                    <p class="text-sm text-start text-neutral-500">
                        {{ __("Select a default subtitle language for your direct link.") }}
                    </p>

                    @if(!empty($subtitles))
                        <div class="grid gap-2 sm:grid-cols-2">
                            @foreach($subtitles as $key => $subtitle)
                                @php
                                    $id = 'subtitle-'.$video->id.'-'.$loop->index;
                                @endphp

                                <div class="relative">
                                    <input type="radio" id="{{ $id }}" name="subtitle_default_{{ $video->id }}" value="{{ $key }}" class="peer sr-only" x-model="selectedSubtitle">

                                    <label for="{{ $id }}"
                                           class="flex items-center gap-3 w-full rounded-xl border border-neutral-200/80 bg-white px-3 py-2 cursor-pointer
                                                      text-xs sm:text-sm text-neutral-700
                                                      shadow-sm hover:shadow-md hover:border-blue-300
                                                      transition-all duration-150
                                                      peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700
                                                      peer-focus-visible:ring-2 peer-focus-visible:ring-blue-600 peer-focus-visible:ring-offset-2
                                                      [&_.radio-dot]:opacity-0 [&_.radio-dot]:scale-50
                                                      peer-checked:[&_.radio-dot]:opacity-100 peer-checked:[&_.radio-dot]:scale-100">

                                        <span class="flex items-center justify-center h-4 w-4 rounded-full border border-neutral-400
                                                     transition-colors duration-150
                                                     peer-checked:border-blue-600">
                                            <span class="radio-dot h-2 w-2 rounded-full bg-blue-600 transition-all duration-150"></span>
                                        </span>

                                        <span class="truncate">{{ $key }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <!-- end Buttons -->

                <!-- Apply buttons -->
                <div class="flex justify-start gap-2 mt-3">
                    <button type="button" @click="applySubtitle()"
                        class="py-1.5 px-3 inline-flex min-h-8 items-center gap-x-1.5 text-xs font-medium rounded-md
                               border border-blue-600 text-blue-600
                               hover:border-blue-500 hover:text-blue-500
                               focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2
                               disabled:opacity-50 disabled:pointer-events-none">
                        {{ __("Apply subtitle") }}
                    </button>

                    <button type="button" @click="clearSubtitle()"
                        class="py-1.5 px-3 inline-flex min-h-8 items-center gap-x-1.5 text-xs font-medium rounded-md
                               border border-red-500 text-red-500
                               hover:border-red-400 hover:text-red-400
                               focus:outline-none focus-visible:ring-2 focus-visible:ring-red-600 focus-visible:ring-offset-2
                               disabled:opacity-50 disabled:pointer-events-none">
                        {{ __("Remove subtitle") }}
                    </button>
                </div>

                <!-- end apply buttons -->

                <!-- Direct link -->
                <h4 class="text-lg font-normal mt-6">{{ __("Direct link") }}</h4>
                <small class="opacity-50">{{ __("Click on the icon to copy to clipboard") }}</small>

                <div class="mb-4 bg-gray-100 border border-grey-200 p-2 md:p-3 flex items-center justify-between gap-2">
                    <p x-ref="directLink" :id="$id('static-link')" class="text-sm break-all" x-text="shareUrl"></p>

                    <button
                        type="button"
                        x-data="{ copied: false }"
                        :aria-describedby="$id('static-link')"
                        aria-label="{{ __('Copy direct link') }}"
                        @click="navigator.clipboard.writeText($refs.directLink.textContent.trim());
                          copied = true; setTimeout(() => copied = false, 2000)" class="ml-2 inline-flex min-h-10 min-w-10 items-center justify-center rounded-md p-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                        <svg x-show="!copied" class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0 1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z"/>
                        </svg>
                        <span x-show="copied" x-transition aria-live="polite" class="text-sm">{{ __("Copied!") }}</span>
                    </button>
                </div>

                <!-- Embed -->
                <h4 class="text-lg font-normal">{{ __("Embed nextIlearn") }}</h4>
                <small class="opacity-50">{{ __("Click on the icon to copy to clipboard") }}</small>

                <div class="bg-gray-100 border border-gray-200 p-2 md:p-3 flex items-center justify-between">
                    <div class="p-1 flex-1">
                        <textarea
                            x-ref="embedLink"
                            :id="$id('embed-link')"
                            class="w-full text-xs outline-none border-none bg-transparent p-0 resize-none"
                            rows="8"
                            aria-label="{{ __('Embed code') }}"
                            readonly
                            x-text="embedCode">
                        </textarea>
                    </div>
                    <button
                        type="button"
                        x-data="{ copied: false }"
                        :aria-describedby="$id('embed-link')"
                        aria-label="{{ __('Copy embed code') }}"
                        @click="
                          navigator.clipboard.writeText($refs.embedLink.value.trim());
                          copied = true; setTimeout(() => copied = false, 2000)
                        "
                        class="ml-2 inline-flex min-h-10 min-w-10 items-center justify-center rounded-md p-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                        <svg x-show="!copied" class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0 1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z"/>
                        </svg>
                        <span x-show="copied" x-transition aria-live="polite" class="text-sm">{{ __("Copied!") }}</span>
                    </button>
                </div>

                <div class="relative w-auto">
                    <small class="opacity-50">{{ __("Use this embed code to insert the video in nextILearn") }}</small>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    function shareModal({ baseUrl, videoId, defaultSubtitle, thumbUrl }) {
        return {
            modalOpen: false,
            baseUrl,
            videoId,
            thumbUrl,

            // UI selection (changes when radio clicked)
            selectedSubtitle: defaultSubtitle,

            // Actually applied to URL (starts null)
            appliedSubtitle: null,

            applySubtitle() {
                this.appliedSubtitle = this.selectedSubtitle;
            },

            clearSubtitle() {
                this.appliedSubtitle = null;
            },

            get shareUrl() {
                const params = new URLSearchParams();
                params.set('p', this.videoId);

                if (this.appliedSubtitle) {
                    params.set('s', this.appliedSubtitle);
                }

                return `${this.baseUrl}?${params.toString()}`;
            },

            get embedCode() {
                return `<span style="position:relative;display:inline-block;">
  <a target="_blank" href="${this.shareUrl}">
    <span style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:white;">
      <i class="fa fa-play fa-5x" aria-hidden="true"></i>
    </span>
    <img src="${this.thumbUrl}" width="560" height="315" alt="">
  </a>
</span>`;
            },
        };
    }

</script>
