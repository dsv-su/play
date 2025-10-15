<fieldset class="w-full mb-2 bg-white border border-susecondary rounded-lg shadow-sm
          dark:bg-gray-800 dark:border-gray-700">
    <legend class="mx-auto px-2 text-xs uppercase text-blue-500 dark:text-blue-400 bg-white dark:bg-gray-800">
        {{__("Visibility")}}
    </legend>

    <div class="p-4 sm:p-6 md:p-8">
        <div class="flex flex-row gap-x-4"> <!-- Parent container for 2 columns -->
            <!-- Left Column -->
            @include('livewire.edit.partials.form.visibility')
            <!-- Right Column -->
            @include('livewire.edit.partials.form.category')
        </div>
    </div>
</fieldset>
