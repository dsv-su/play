<div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false" x-id="['share-tooltip','static-link','embed-link']">
    <!-- Modal button -->
    <button type="button"
        @click="modalOpen = true"
        :data-tooltip-target="$id('share-tooltip')"
        aria-label="Share"
        class="flex items-center justify-center w-6 h-6 hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
        <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778"/>
        </svg>
    </button>

    <!-- Tooltip (unique per card) -->
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
            <div x-show="modalOpen" x-transition.opacity @click="modalOpen=false" class="absolute inset-0 w-full h-full bg-black/40"></div>

            <div
                x-show="modalOpen"
                x-trap.inert.noscroll="modalOpen"
                x-transition
                class="relative px-7 py-6 w-full bg-white sm:max-w-lg sm:rounded-lg">
                <div class="flex justify-between items-center pb-2 mb-2">
                    <h3 class="text-lg font-semibold">{{ __("Share a presentation") }}</h3>
                    <button @click="modalOpen=false" aria-label="Share modal" class="flex absolute top-0 right-0 justify-center items-center mt-5 mr-5 w-8 h-8 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                {{--}}@include('livewire.search.partials.share.select_sub_language'){{--}}

                <!-- Direct link -->
                <h4 class="text-lg font-normal">{{ __("Direct link") }}</h4>
                <small class="opacity-50">{{ __("Click on the icon to copy to clipboard") }}</small>

                <div class="mb-4 bg-gray-100 border border-grey-200 p-2 md:p-3 flex items-center justify-between gap-2">
                    <p x-ref="directLink" :id="$id('static-link')" class="text-sm break-all">
                        {{ url('/multiplayer?p=' . $video->id) }}
                    </p>
                    <button
                        x-data="{ copied: false }"
                        @click="
                          navigator.clipboard.writeText($refs.directLink.textContent.trim());
                          copied = true; setTimeout(() => copied = false, 2000)
                        "
                        class="ml-2 p-2">
                        <svg x-show="!copied" class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z"/>
                        </svg>
                        <span x-show="copied" x-transition class="text-sm">{{ __("Copied!") }}</span>
                    </button>
                </div>

                <!-- Embed -->
                <h4 class="text-lg font-normal">{{ __("Embed ilearn") }}</h4>
                <small class="opacity-50">{{ __("Click on the icon to copy to clipboard") }}</small>

                <div class="bg-gray-100 border border-gray-200 p-2 md:p-3 flex items-center justify-between">
                    <div class="p-1 flex-1">
                        <textarea
                            x-ref="embedLink"
                            :id="$id('embed-link')"
                            class="w-full text-sm outline-none border-none bg-transparent p-0 resize-none"
                            rows="8"
                            aria-label="embed ilearn"
                            readonly><div style="position: relative;"><a target="_blank" href="{{ route('player.show', ['video' => $video]) }}"><div style="position: absolute; top: 130px; left: 255px; display: inline-block;color: white;"><i class="fa fa-play fa-5x" aria-hidden="true"></i></div><img src="{{ asset($video->thumb)}}" width="560" height="315"></a></div>
                        </textarea>
                    </div>
                    <button
                        x-data="{ copied: false }"
                        @click="
                          navigator.clipboard.writeText($refs.embedLink.value.trim());
                          copied = true; setTimeout(() => copied = false, 2000)
                        "
                        class="ml-2 p-2">
                        <svg x-show="!copied" class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z"/>
                        </svg>
                        <span x-show="copied" x-transition class="text-sm">{{ __("Copied!") }}</span>
                    </button>
                </div>

                <div class="relative w-auto">
                    <small class="opacity-50">{{ __("Use this embed code to insert the video in iLearn") }}</small>
                </div>
            </div>
        </div>
    </template>
</div>

<div id="share-tooltip" role="tooltip"
     class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);"
     data-popper-placement="top">{{__("Share presentation")}}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
