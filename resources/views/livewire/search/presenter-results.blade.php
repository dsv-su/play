<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
    <!-- Course text -->
    <h3 class="ml-6 pt-2 flex items-center text-normal font-bold text-gray-800 dark:text-white">
        {{__("Presenter: ")}}
        <span class="ml-1 flex py-1.5 px-3 rounded-lg text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
            {{ $this->presenterName }}
        </span>
        @include('livewire.search.partials.grid-switch')
    </h3>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b border-gray-200 rounded-t-xl py-3 px-4 md:px-5 dark:border-neutral-700">
        <!-- Filters -->
        @include('livewire.search.partials.filter')
    </div>
    <br>
    @include('livewire.search.partials.totalCountCourses')
    <div class="p-2 md:p-3">
        <!-- Accordian -->
        <div
            x-data="accordionGroup()"
            x-init="init()"
            class="mt-4 relative w-full mx-auto overflow-hidden
                 text-base sm:text-lg md:text-xl font-normal bg-white
                 border border-gray-200 divide-y divide-gray-200 rounded-md
                 dark:text-white dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">

            @foreach ($videos as $courseId => $group)
                <div x-data="{ id: 'course-{{ $courseId }}' }" class="group">
                    <!-- Accordion Button -->
                    <button
                        @click="setActiveAccordion(id)"
                        @keydown.enter.prevent="setActiveAccordion(id)"
                        @keydown.space.prevent="setActiveAccordion(id)"
                        :aria-expanded="(activeAccordion === id).toString()"
                        :aria-controls="'panel-${id}'"
                        class="w-full p-3 sm:p-4 text-left select-none
                           flex items-center justify-between gap-3 sm:gap-4
                           hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600
                           dark:focus-visible:ring-blue-500">
                        <!-- Left: arrow + title (wrapping) -->
                        <span class="flex items-start sm:items-center gap-2 sm:gap-3 min-w-0 flex-1 flex-wrap">
                          <!-- Arrow -->
                          <svg class="w-4 h-4 sm:w-5 sm:h-5 duration-200 ease-out transform -rotate-90 mt-1 sm:mt-0"
                               :class="{ 'rotate-0': activeAccordion==id }"
                               viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                               fill="none" stroke="currentColor" stroke-width="2"
                               stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="6 9 12 15 18 9"></polyline>
                          </svg>
                          <span class="leading-snug break-words hyphens-auto min-w-0">
                            {{ $this->courseTitles[$courseId] ?? __('Presentations') }}
                          </span>

                          <a @click.stop href="#"
                             data-tooltip-target="playAll-tooltip"
                             class="shrink-0 inline-flex items-center gap-1
                                   ml-0 sm:ml-2 mt-2 sm:mt-0
                                   bg-blue-800 hover:bg-blue-900 text-white
                                   text-sm sm:text-base font-semibold
                                   px-2 sm:px-2.5 py-0.5 rounded border border-blue-900
                                   dark:bg-blue-950 dark:text-white dark:border-blue-800">
                                {{ count($group) }}
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                  <path fill-rule="evenodd" d="M8.6 5.2A1 1 0 0 0 7 6v12a1 1 0 0 0 1.6.8l8-6a1 1 0 0 0 0-1.6l-8-6Z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </span>
                    </button>
                    <!-- Accordion lazy Content -->
                    <template x-if="activeAccordion === id">
                        <div
                            :id="'panel-${id}'"
                            tabindex="-1"
                            class="px-3 sm:px-4 pb-3 sm:pb-4">
                            <div x-data="{ switchOn: @entangle('switchOn') }">
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
        <!-- end accordian -->

    </div>

    <!-- Tooltips -->
    @include('home.partials.tooltips')
    @include('livewire.search.partials.tooltips')
</div>
@push('scripts')
    @include('partials.livewire-search-script')
@endpush
