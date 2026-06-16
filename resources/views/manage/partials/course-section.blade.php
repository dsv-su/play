<section class="rounded-lg border border-slate-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
    <div class="border-b border-slate-200 px-4 py-4 sm:px-6 dark:border-neutral-700">
        <h2 class="text-base font-semibold text-slate-950 dark:text-white">{{__("Course association")}}</h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-neutral-400">{{__("Connect this presentation to the courses where it should appear and confirm the responsible course managers.")}}</p>
    </div>
    <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
            <div class="min-w-0 rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-neutral-700 dark:bg-neutral-950">
                <label for="course" class="block text-sm font-medium text-slate-900 dark:text-white">
                    {{__("Associated course(s)")}}
                </label>
                <p class="mt-1 mb-3 text-sm text-slate-500 dark:text-neutral-400">{{__("Add or remove the course used for search.")}}</p>

                @include('manage.partials.edit-course')
            </div>

            <div class="min-w-0 rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-neutral-700 dark:bg-neutral-950">
                <label for="course" class="block text-sm font-medium text-slate-900 dark:text-white">
                    {{__("Course manager(s)")}}
                </label>
                <p class="mt-1 mb-3 text-sm text-slate-500 dark:text-neutral-400">{{__("Review who is responsible for the selected course.")}}</p>

                <livewire:edit.course-responsible />
            </div>
        </div>
    </div>
</section>
