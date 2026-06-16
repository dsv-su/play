<section class="mt-5 rounded-lg border border-slate-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
    <div class="border-b border-slate-200 px-4 py-4 sm:px-6 dark:border-neutral-700">
        <h2 class="text-base font-semibold text-slate-950 dark:text-white">{{__("Visibility and category")}}</h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-neutral-400">{{__("Choose who can find or play the presentation and where it belongs in DSVPlay.")}}</p>
    </div>

    <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            @include('livewire.edit.partials.form.visibility')
            @include('livewire.edit.partials.form.category')
        </div>
    </div>
</section>
