<section class="rounded-lg border border-slate-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
    <div class="border-b border-slate-200 px-4 py-4 sm:px-6 dark:border-neutral-700">
        <h2 class="text-base font-semibold text-slate-950 dark:text-white">{{__("Subtitles")}}</h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-neutral-400">{{__("Manage existing subtitle files or upload new WebVTT files.")}}</p>
    </div>

    <div class="p-4 sm:p-6">
        <livewire:edit.edit-subtitles :video="$video ?? null" :presentation="$presentation ?? null" />
    </div>
</section>
