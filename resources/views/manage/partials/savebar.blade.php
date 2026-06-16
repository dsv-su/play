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

    .savebar {
        padding-bottom: calc(0.5rem + env(safe-area-inset-bottom, 0px));
    }

    @media (min-width: 640px) {
        .savebar {
            padding-bottom: calc(0.75rem + env(safe-area-inset-bottom, 0px));
        }
    }

</style>
<div class="savebar fixed inset-x-0 bottom-0 z-50 border-t border-susecondary bg-white/95 px-3 pt-2 shadow-lg backdrop-blur dark:border-susecondary dark:bg-neutral-950/95 sm:px-4 sm:pt-3" style="position: fixed; right: 0; bottom: 0; left: 0; display: block; z-index: 60;">
    <div class="mx-auto grid max-w-screen-2xl gap-2 sm:flex sm:items-center sm:justify-between sm:gap-3">
        <div class="min-w-0">
            <p class="truncate text-sm font-semibold text-slate-950 dark:text-white">{{ __("Ready to finish?") }}</p>
            <p class="hidden text-sm text-slate-500 dark:text-neutral-400 sm:block">{{ __("Save applies all edits on this page. Cancel returns without saving.") }}</p>
            <p id="edit-stream-upload-status" class="mt-1 hidden text-sm font-medium text-blue-700 dark:text-blue-300">
                {{ __("Uploading replacement stream...") }}
            </p>
        </div>

        <div class="grid w-full grid-cols-2 gap-2 sm:w-auto sm:flex sm:flex-row sm:items-center">
            <button type="button"
                    id="presentation-cancel-button"
                    data-tooltip-target="edit-cancel-tooltip"
                    onclick="document.dispatchEvent(new CustomEvent('edit-stream-replacements:reset')); window.history.back()"
                    class="inline-flex min-h-10 w-full items-center justify-center whitespace-nowrap rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold sm:min-h-11 sm:w-auto sm:px-5 sm:py-2.5 text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-200 dark:hover:bg-neutral-800">
                {{ __("Cancel") }}
            </button>
            <button type="submit"
                    id="presentation-save-button"
                    data-tooltip-target="edit-save-tooltip"
                    form="{{ $type == 'edit' ? 'presentation-edit-Form' : 'presentation-upload-Form' }}"
                    @if($type != 'edit')
                        disabled
                    @endif
                    class="save-btn inline-flex min-h-10 w-full items-center justify-center whitespace-nowrap rounded-lg border border-suprimary bg-suprimary px-4 py-2 text-sm font-semibold sm:min-h-11 sm:w-auto sm:px-6 sm:py-2.5 text-white shadow-sm transition hover:bg-sudepartment focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:opacity-60 dark:border-blue-500 dark:bg-blue-600 dark:hover:bg-blue-500">
                <span class="sm:hidden">{{ __("Save") }}</span>
                <span class="hidden sm:inline">{{ __("Save presentation") }}</span>
            </button>
        </div>
    </div>
</div>
<div id="edit-cancel-tooltip" role="tooltip"
     class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     data-popper-placement="top">{{__("Cancel edit")}}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
<div id="edit-save-tooltip" role="tooltip"
     class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     data-popper-placement="top">{{__("Save presentation")}}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
