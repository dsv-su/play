<section class="rounded-lg border border-susecondary bg-white shadow-sm dark:border-susecondary dark:bg-neutral-900">
    <div class="border-b border-slate-200 px-4 py-4 sm:px-6 dark:border-neutral-700">
        <h2 class="text-base font-semibold text-slate-950 dark:text-white">{{__("Streams")}}</h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-neutral-400">{{__("Review the video streams that belong to this presentation.")}}</p>
    </div>

    <div class="p-4 sm:p-6">
        <livewire:edit.edit-streams :video="$video" :edit-presentation-id="$editPresentation->id" />
    </div>
</section>
