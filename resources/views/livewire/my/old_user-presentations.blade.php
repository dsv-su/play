<div class="mx-auto max-w-screen-2xl px-4 py-6 sm:px-6 lg:px-8 md:py-8 space-y-6">
    @include('home.partials.flashmessage-section')

    <livewire:search.index />

    <section class="overflow-visible rounded-2xl border border-gray-200 bg-white shadow-sm ring-1 ring-black/[0.02] dark:border-neutral-800 dark:bg-neutral-950 dark:ring-white/[0.04]">
        <div class="border-b border-gray-200 bg-gray-50/70 px-4 py-4 dark:border-neutral-800 dark:bg-neutral-900/60 md:px-5">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    @include('livewire.search.partials.totalCountCourses')
                    @include('livewire.search.partials.grid-switch')
                </div>

                <div class="min-w-0 border-t border-gray-200 pt-4 dark:border-neutral-800">
                    @include('livewire.search.partials.filter')
                </div>
            </div>
        </div>

        <div class="p-3 sm:p-4 md:p-5">
            @if($videos->isEmpty())
                <div class="flex min-h-64 flex-col items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center dark:border-neutral-700 dark:bg-neutral-900/50">
                    <div class="mb-3 inline-flex size-12 items-center justify-center rounded-full bg-white text-gray-500 shadow-sm ring-1 ring-gray-200 dark:bg-neutral-950 dark:text-neutral-400 dark:ring-neutral-800">
                        <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                        </svg>
                    </div>
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('No presentations found') }}</h2>
                    <p class="mt-1 max-w-md text-sm text-gray-500 dark:text-neutral-400">{{ __('Try clearing one or more filters.') }}</p>
                </div>
            @else
            <div
                x-data="accordionGroup()"
                x-init="init()"
                aria-label="{{ __('Presentations by course') }}"
                class="relative w-full overflow-hidden rounded-xl border border-gray-200 bg-white text-base font-normal shadow-sm dark:border-neutral-800 dark:bg-neutral-950 dark:text-white">

                @foreach ($videos as $courseId => $group)
                    <div
                        x-data="{ id: 'course-{{ $courseId }}' }"
                        wire:key="presentation-course-{{ $courseId }}"
                        class="group border-b border-gray-200 last:border-b-0 dark:border-neutral-800">
                        <button
                            type="button"
                            :id="'trigger-${id}'"
                            @click="setActiveAccordion(id)"
                            :aria-expanded="(activeAccordion === id).toString()"
                            :aria-controls="'panel-${id}'"
                            class="flex w-full items-center justify-between gap-3 px-4 py-4 text-left transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-inset dark:hover:bg-neutral-900 dark:focus-visible:ring-blue-500 sm:px-5">

                            <span class="flex min-w-0 flex-1 items-start gap-3 sm:items-center">
                                <span class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500 transition group-hover:bg-white group-hover:text-blue-700 dark:bg-neutral-900 dark:text-neutral-400 dark:group-hover:bg-neutral-800 dark:group-hover:text-blue-400 sm:mt-0">
                                    <svg class="size-4 duration-200 ease-out -rotate-90"
                                         :class="{ 'rotate-0': activeAccordion === id }"
                                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </span>

                                <span class="min-w-0">
                                    <span class="block break-words text-sm font-semibold leading-6 text-gray-950 dark:text-white sm:text-base">
                                        {!!  $this->courseTitles[$courseId] ?? '<span class="text-blue-800 dark:text-blue-300">'. __('Presentations') .'</span>' !!}
                                    </span>
                                    <span class="mt-0.5 block text-xs text-gray-500 dark:text-neutral-400">
                                        {{ trans_choice(':count presentation|:count presentations', count($group), ['count' => count($group)]) }}
                                    </span>
                                </span>
                            </span>

                            <span class="inline-flex shrink-0 items-center gap-1 rounded-full border border-blue-200 bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-800 dark:border-blue-900/80 dark:bg-blue-950 dark:text-blue-200">
                                {{ count($group) }}
                                <svg class="size-3.5" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.6 5.2A1 1 0 0 0 7 6v12a1 1 0 0 0 1.6.8l8-6a1 1 0 0 0 0-1.6l-8-6Z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </button>

                        <template x-if="activeAccordion === id">
                            <div
                                :id="'panel-${id}'"
                                :aria-labelledby="'trigger-${id}'"
                                tabindex="-1"
                                class="border-t border-gray-100 bg-gray-50/60 px-2 py-3 focus:outline-none dark:border-neutral-800 dark:bg-neutral-900/40 sm:px-3">
                                <div x-data="{ switchOn: @entangle('switchOn').live }">
                                    <template x-if="!switchOn">
                                        @include('livewire.search.partials.table')
                                    </template>
                                    <template x-if="switchOn">
                                        @include('livewire.search.partials.grid')
                                    </template>
                                </div>
                            </div>
                        </template>

                    </div>
                @endforeach
            </div>
            @endif

        </div>

        @include('home.partials.tooltips')
        @include('livewire.search.partials.tooltips')
    </section>
</div>
@push('scripts')
    @include('partials.livewire-search-script')
@endpush
