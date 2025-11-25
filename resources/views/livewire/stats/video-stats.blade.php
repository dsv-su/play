<div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false" x-id="['metrics-tooltip']">
    <!-- Modal button -->
    <button type="button"
            @click="modalOpen = true"
            :data-tooltip-target="$id('metrics-tooltip')"
            aria-label="Metrics"
            class="flex items-center justify-center w-4 h-4 hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
        </svg>

    </button>

    <!-- Tooltip (unique per card) -->
    <div
        :id="$id('metrics-tooltip')"
        role="tooltip"
        class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
        {{ __("Presentation metrics") }}
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
                    <h3 class="text-lg font-semibold">{{ __("Presentation metrics") }}</h3>
                    <button @click="modalOpen=false" aria-label="Share modal" class="flex absolute top-0 right-0 justify-center items-center mt-5 mr-5 w-8 h-8 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>



            </div>
        </div>
    </template>
    <div id="metrics-tooltip" role="tooltip"
         class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
         style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);"
         data-popper-placement="top">{{__("Presentation metrics")}}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</div>

