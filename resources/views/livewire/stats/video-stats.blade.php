<div>
    @php
        $modalId = 'chart-modal-'.$video->id;
    @endphp

    <!-- Chart -->
    @if($showModal)
        <div id="{{ $modalId }}"
             class="fixed top-0 left-0 z-[99] flex items-center justify-center w-full p-4 overflow-x-hidden
                overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full" wire:click.self="closeModal">

            <!-- Backdrop -->
            <div class="absolute inset-0 w-full h-full bg-black/40"></div>

            <!-- Modal content -->
            <div class="relative w-full px-7 py-6
                        bg-white text-gray-900 border border-gray-200 shadow-lg
                        sm:max-w-2xl sm:rounded-lg
                        dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700"
                 x-on:click.stop
            >
                <div class="flex justify-between items-center pb-2 mb-2">
                    <h3 class="text-lg font-semibold">{{ __("Presentation metrics") }}: <span class="line-clamp-2">{{$video->title}}</span></h3>
                    <button wire:click="closeModal"
                            aria-label="Metrics modal"
                            class="flex absolute top-0 right-0 justify-center items-center mt-5 mr-5 w-8 h-8 text-gray-600
                            rounded-full hover:text-gray-800 hover:bg-gray-50">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex gap-2 mb-4">
                    <button
                        type="button"
                        wire:click="setPeriod('week')"
                        class="{{ $period === 'week'
                                ? 'btn-primary btn-active-week'
                                : 'btn-secondary' }}">
                        Week
                    </button>

                    <button
                        type="button"
                        wire:click="setPeriod('month')"
                        class="{{ $period === 'month'
                                ? 'btn-secondary btn-active-month'
                                : 'btn-primary' }}">
                        Month
                    </button>

                </div>
                <div class="flex gap-2 mb-4 items-center justify-center">
                    {{__("This week")}}:
                    <span class="px-1.5 py-0 text-[10px] font-medium text-blue-700 bg-gray-100 border-none rounded-sm shadow-sm dark:bg-neutral-300">
                         {{$sum_week ?? 0}}
                    </span>
                    {{__("This month")}}:
                    <span class="px-1.5 py-0 text-[10px] font-medium text-blue-700 bg-gray-100 border-none rounded-sm shadow-sm dark:bg-neutral-300">
                         {{$sum_month ?? 0}}
                    </span>
                    {{__("This year")}}:
                    <span class="px-1.5 py-0 text-[10px] font-medium text-blue-700 bg-gray-100 border-none rounded-sm shadow-sm dark:bg-neutral-300">
                         {{$sum_year ?? 0}}
                    </span>
                </div>
                <!-- Chart -->
                <div class="chart-container">
                    <x-chartjs-component :chart="$this->chart" />
                </div>
            </div>

        </div>
    @endif
</div>
