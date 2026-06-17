<div class="flex justify-end">
    <button
        x-data="{ switchOn: @entangle('switchOn').live }"
        type="button"
        role="switch"
        :aria-checked="switchOn.toString()"
        @click="switchOn = !switchOn"
        class="inline-flex min-h-11 items-center gap-3 rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-300 dark:hover:bg-neutral-900 dark:focus-visible:ring-blue-500 dark:focus-visible:ring-offset-neutral-950">
        <span
            aria-hidden="true"
            :class="switchOn ? 'bg-blue-700 dark:bg-blue-600' : 'bg-gray-200 dark:bg-neutral-700'"
            class="relative inline-flex h-6 w-11 shrink-0 rounded-full p-0.5 transition">
            <span
                :class="switchOn ? 'translate-x-5' : 'translate-x-0'"
                class="size-5 rounded-full bg-white shadow-sm duration-200 ease-in-out"
            ></span>
        </span>

        <span class="select-none whitespace-nowrap">
            {{ __("Grid view") }}
        </span>
    </button>
</div>
