<div class="hs-tooltip block w-full min-w-0">
    @php($coursesHash = md5(json_encode($courses)))
    <div class="relative mb-0 w-full sm:w-72 md:w-80 lg:w-96 max-w-full flex items-center border border-susecondary rounded-lg bg-white dark:bg-neutral-900 dark:border-neutral-700"
         wire:key="courses-block-{{ $coursesHash }}">
        <!-- Count Courses -->
        <div class="px-3 py-2 text-semibold text-blue-600 dark:text-neutral-300 border-r border-susecondary dark:border-neutral-700">
            {{ count($courses) }}
        </div>
        <!-- Select Courses-->
        <select id="courses-select"
                data-url-param="course"
                x-ref="sel"
                wire:model.live="selectedCourses"
                multiple
                class="hidden"
                data-hs-select='{
                                "hasSearch": true,
                                "searchPlaceholder": "Search courses",
                                "searchClasses": "block w-full sm:text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-1 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:placeholder-neutral-500 py-1.5 sm:py-2 px-3",
                                "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900 dark:text-white",
                                "placeholder": "{{__('Filter by Courses')}}",
                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                                "toggleSeparators": {
                                  "betweenItemsAndCounter": "&"
                                },
                                "toggleCountText": "+",
                                "toggleCountTextPlacement": "prefix-no-space",
                                "toggleCountTextMinItems": 3,
                                "toggleCountTextMode": "nItemsAndCount",
                                "dropdownClasses": "mt-2 z-50 w-auto min-w-[16rem] -ml-10 sm:min-w-[20rem] md:min-w-[28rem] lg:min-w-[36rem] max-h-72 p-1 space-y-0.5 bg-white border border-susecondary rounded-lg overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                              }'>
            @foreach($courses as $designation => $name)
                <option
                    value="{{ $designation }}"
                    data-title="{{ $designation }}"
                    @if(isset($selectedCourses) && in_array($designation, $selectedCourses, true)) selected @endif>
                    {{ $designation }} | {{$name}}
                </option>
            @endforeach
        </select>
        <!-- End Select -->
    </div>

    <div class="mt-1 flex flex-wrap gap-2">
        <button type="button"
                data-target="#courses-select"
                x-data
                data-recompute="course"
                @click="$dispatch('recompute', { prop: $el.dataset.recompute })"
                class="js-clear py-1 px-2 inline-flex items-center gap-x-1 text-sm rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:text-white dark:border-neutral-700 dark:hover:bg-neutral-800">
            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
            {{__('Clear')}}
        </button>
    </div>
</div>
