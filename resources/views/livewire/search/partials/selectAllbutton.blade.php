@if(in_array((string) app()->make('play_role'), ['Administrator', 'Courseadmin', 'Staff']) && $allowBulkEdit)
    <div class="mb-2 flex flex-col items-stretch gap-2 sm:flex-row sm:justify-start">
        <!-- Select / Deselect All -->
        <button
            type="button"
            class="w-full sm:w-40 py-2 px-3 inline-flex items-center justify-center gap-x-1 text-sm rounded-lg border border-blue-700 bg-white text-gray-800
             hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none
             dark:bg-neutral-900 dark:text-white dark:border-neutral-700 dark:hover:bg-neutral-800"
            @click="selectedVideos.length === allIds.length ? selectedVideos = [] : selectedVideos = allIds.slice()"
        >
            {{--}}<span class="whitespace-nowrap" x-text="selectedVideos.length === allIds.length ? 'Deselect All' : 'Select All'"></span>{{--}}
            <span
                class="whitespace-nowrap"
                x-text="selectedVideos.length === allIds.length
                ? @js(__('ui.deselect_all'))
                : @js(__('ui.select_all'))"
            ></span>
        </button>

        <!-- Bulk Edit -->
        <button
            type="submit"
            class="w-full sm:w-40 py-2 px-3 inline-flex items-center justify-center gap-x-1 text-sm rounded-lg border border-blue-700 bg-white text-blue-800
             hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none
             dark:bg-neutral-900 dark:text-white dark:border-neutral-700 dark:hover:bg-neutral-800"
        >
            <svg class="shrink-0 size-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
            </svg>
            {{ __("With selected") }}
        </button>
    </div>
@endif

