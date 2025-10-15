<fieldset class="w-full mb-2 bg-white border border-susecondary rounded-lg shadow-sm
          dark:bg-gray-800 dark:border-gray-700">
    <legend class="mx-auto px-2 text-xs uppercase text-blue-500 dark:text-blue-400 bg-white dark:bg-gray-800">
        {{__("Permissions")}}
    </legend>

    <div class="p-4 sm:p-6 md:p-8">
        <livewire:edit.edit-permissions :video="$video ?? null" :permissions="$permissions" :user_permission="$user_permission" />
    </div>
</fieldset>
