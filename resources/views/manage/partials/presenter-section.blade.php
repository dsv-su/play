<section class="rounded-lg border border-slate-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
    <div class="border-b border-slate-200 px-4 py-4 sm:px-6 dark:border-neutral-700">
        <h2 class="text-base font-semibold text-slate-950 dark:text-white">{{__("Presenters")}}</h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-neutral-400">{{__("Add everyone who should be shown as a presenter and remove names that no longer apply.")}}</p>
    </div>

    <div class="p-4 sm:p-6">
        <livewire:edit.edit-presenters :video="$video ?? null" />
    </div>
</section>
