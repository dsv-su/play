<div x-data="{
        activeAccordion: 'accordion-1',
        setActiveAccordion(id) {
            this.activeAccordion = (this.activeAccordion == id) ? '' : id
        }
    }">
    <div x-data="{ id: $id('accordion') }" :class="{ 'text-neutral-900': activeAccordion==id, 'text-neutral-600 hover:text-neutral-900': activeAccordion!=id }" class="cursor-pointer group">
        <button @click="setActiveAccordion(id)" class="flex items-center justify-between w-full text-left select-none">
            <svg class="w-5 h-5 duration-300 ease-out" :class="{ '-rotate-[45deg]': activeAccordion==id }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" /></svg>
        </button>
        <div x-show="activeAccordion==id" x-collapse x-cloak>
            <div class="p-2 opacity-70">
                <!-- Stats -->
                <div class="max-w-[85rem] mx-auto">
                    <!-- Grid -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        <!-- Total Presentations -->
                        <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
                            <div class="p-2 md:p-3 flex gap-x-2">
                                <div class="grow">
                                    <div class="flex items-center gap-x-2">
                                        <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                                            {{__("Presentations")}}
                                        </p>
                                        <div data-tooltip-target="totalPresentations-tooltip">
                                            <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500"
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"/>
                                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                                <path d="M12 17h.01"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="mt-1 flex items-center gap-x-2">
                                        <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                            {{count($videos)}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End total presentations -->

                        <!-- Total courses -->
                        <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
                            <div class="p-2 md:p-3 flex gap-x-2">
                                <div class="grow">
                                    <div class="flex items-center gap-x-2">
                                        <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                                            {{__("Courses")}}
                                        </p>
                                        <div data-tooltip-target="totalCourses-tooltip">
                                            <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500"
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"/>
                                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                                <path d="M12 17h.01"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="mt-1 flex items-center gap-x-2">
                                        <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                            {{count($courses)}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End total courses -->

                        <!-- Total Presenters -->
                        <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
                            <div class="p-2 md:p-3 flex gap-x-2">
                                <div class="grow">
                                    <div class="flex items-center gap-x-2">
                                        <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                                            {{__("Presenters")}}
                                        </p>
                                        <div data-tooltip-target="totalPresenters-tooltip">
                                            <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500"
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"/>
                                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                                <path d="M12 17h.01"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="mt-1 flex items-center gap-x-2">
                                        <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                            {{count($presenters)}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End total presenters -->

                        <!-- Total Semesters -->
                        <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
                            <div class="p-2 md:p-3 flex gap-x-2">
                                <div class="grow">
                                    <div class="flex items-center gap-x-2">
                                        <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                                            {{__("Semesters")}}
                                        </p>
                                        <div data-tooltip-target="totalSemesters-tooltip">
                                            <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500"
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"/>
                                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                                <path d="M12 17h.01"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="mt-1 flex items-center gap-x-2">
                                        <h3 class="text-xl font-medium text-gray-800 dark:text-neutral-200">
                                            {{count($terms)}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Card -->
                    </div>
                    <!-- End Grid -->
                </div>

                <!-- end stats -->
            </div>
        </div>
    </div>


</div>


