<fieldset class="w-full mb-2 bg-white border border-susecondary rounded-lg shadow-sm
          dark:bg-gray-800 dark:border-gray-700">
    <legend class="mx-auto px-2 text-xs uppercase text-blue-500 dark:text-blue-400 bg-white dark:bg-gray-800">
        {{__("Course Association")}}
    </legend>

    <div class="p-4 sm:p-6 md:p-8">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
            <div class="flex flex-col gap-y-1">
                <label for="course" class="font-sans block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                    {{__("Associated Course(s)")}}
                </label>

                <div class="flex items-center gap-x-1.5">
                    @include('manage.partials.edit-course')
                </div>
            </div>

            <!-- Column right -->
            <div class="flex flex-col gap-y-1">
                <label for="course" class="font-sans block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                    {{__("Course manager(s)")}}
                </label>

                <div>
                    <livewire:edit.bulk.enable-course />
                    <livewire:edit.course-responsible />
                </div>
            </div>
        </div>
    </div>
</fieldset>
