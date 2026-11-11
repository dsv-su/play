<div x-data @keydown.escape.window="$wire.closeModal()">
    @php
        $modalId = 'chart-modal-'.$this->getId();
    @endphp

    <!-- Chart -->
    @if($showModal)
        @teleport('body')
        <div id="{{ $modalId }}"
             x-data x-trap.inert.noscroll="true"
             role="dialog" aria-modal="true" aria-labelledby="{{ $modalId }}-title"
             class="fixed inset-0 z-[99] flex items-center justify-center p-4" wire:click.self="closeModal">

            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/40" aria-hidden="true" wire:click="closeModal"></div>

            <!-- Modal content -->
            <div class="relative w-full max-h-[calc(100dvh-2rem)] overflow-y-auto rounded-lg px-5 py-6
                        bg-white text-gray-900 border border-gray-200 shadow-lg
                        sm:max-w-2xl sm:rounded-lg
                        dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700"
                 x-on:click.stop
            >
                <div class="flex justify-between items-center pb-2 mb-2">
                    <h3 id="{{ $modalId }}-title" class="text-lg font-semibold pr-8">{{ __("Presentation metrics") }}: <span class="line-clamp-2">{{$video->LangTitle}}</span></h3>
                    <button type="button" wire:click="closeModal"
                            aria-label="{{ __('Close metrics dialog') }}"
                            class="flex absolute top-0 right-0 justify-center items-center mt-5 mr-5 w-8 h-8 text-gray-600
                            rounded-full hover:text-gray-800 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex gap-2 mb-4">
                    <button
                        type="button"
                        wire:click="setPeriod('week')"
                        aria-pressed="{{ $period === 'week' ? 'true' : 'false' }}"
                        class="rounded-md border px-3 py-2 text-xs font-medium focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 {{ $period === 'week' ? 'bg-blue-700 text-white border-blue-700' : 'border-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        {{ __('Week') }}
                    </button>

                    <button
                        type="button"
                        wire:click="setPeriod('month')"
                        aria-pressed="{{ $period === 'month' ? 'true' : 'false' }}"
                        class="rounded-md border px-3 py-2 text-xs font-medium focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600 {{ $period === 'month' ? 'bg-blue-700 text-white border-blue-700' : 'border-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        {{ __('Month') }}
                    </button>

                </div>
                <h1 class="sr-only">{{__("Video statistics")}}</h1>
                <div class="flex flex-wrap gap-2 mb-4 items-center justify-center text-sm">
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
                    {{__("Total")}}:
                    <span class="px-1.5 py-0 text-[10px] font-medium text-blue-700 bg-gray-100 border-none rounded-sm shadow-sm dark:bg-neutral-300">
                         {{$video->videoStats->playback ?? 0}}
                    </span>
                </div>
                <!-- Chart -->
                <figure aria-labelledby="{{ $modalId }}-chart-title" class="rounded-lg border border-gray-200 p-3 dark:border-gray-700">
                    <figcaption id="{{ $modalId }}-chart-title" class="mb-2 text-xs font-medium text-gray-600 dark:text-gray-300">{{ __('Daily views') }}</figcaption>
                    @if(count($data) === 0)
                        <p class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('No views recorded for this period.') }}</p>
                    @else
                        <div class="relative h-44 w-full" x-data="presentationStatsChart(@js($datasets))" wire:key="metrics-chart-{{ $this->getId() }}-{{ $period }}">
                            <canvas x-ref="canvas" role="img" aria-label="{{ __('Daily views') }}" wire:ignore></canvas>
                        </div>
                        <table class="sr-only">
                            <caption>{{ __('Daily views') }}</caption>
                            <tbody>
                                @foreach($labels as $index => $label)
                                    <tr><th scope="row">{{ $label }}</th><td>{{ $data[$index] ?? 0 }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </figure>
            </div>

        </div>
        @endteleport
    @endif
</div>
