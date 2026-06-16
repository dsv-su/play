<!-- Save bar -->
<style>
    .save-btn:disabled {
        position: relative;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .save-btn:disabled::after {
        content: "";
        position: absolute;
        left: 10%;
        right: 10%;
        top: 50%;
        height: 2px;
        background-color: white; /* or any color */
    }

</style>
<div class="fixed inset-x-0 bottom-0 z-50 border-t border-slate-200 bg-white/95 px-4 py-3 shadow-lg backdrop-blur dark:border-neutral-700 dark:bg-neutral-950/95">
    <div class="mx-auto flex max-w-screen-2xl flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="min-w-0">
            <p class="text-sm font-semibold text-slate-950 dark:text-white">{{ __("Ready to finish?") }}</p>
            <p class="text-sm text-slate-500 dark:text-neutral-400">{{ __("Save applies all edits on this page. Cancel returns without saving.") }}</p>
        </div>

        <div class="flex w-full flex-col-reverse gap-2 sm:w-auto sm:flex-row sm:items-center">
            <button type="button"
                    data-tooltip-target="edit-cancel-tooltip"
                    onclick="window.history.back()"
                    class="inline-flex min-h-11 items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-200 dark:hover:bg-neutral-800">
                {{ __("Cancel") }}
            </button>
            <button type="submit"
                    data-tooltip-target="edit-save-tooltip"
                    @if($type == 'edit')
                        form="presentation-edit-Form"
                    @else
                        id="submit"
                        form="presentation-upload-Form"
                        disabled
                    @endif
                    class="save-btn inline-flex min-h-11 items-center justify-center rounded-lg border border-suprimary bg-suprimary px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sudepartment focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:opacity-60 dark:border-blue-500 dark:bg-blue-600 dark:hover:bg-blue-500">
                {{ __("Save presentation") }}
            </button>
        </div>
    </div>
</div>
<div id="edit-cancel-tooltip" role="tooltip"
     class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);"
     data-popper-placement="top">{{__("Cancel edit")}}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
<div id="edit-save-tooltip" role="tooltip"
     class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);"
     data-popper-placement="top">{{__("Save presentation")}}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
