<div class="min-w-0">
    <label for="recording-date" class="mb-2 block text-sm font-medium text-slate-900 dark:text-white">
        {{__("Recording date")}}
        <button id="recording-date-button" data-modal-toggle="date-modal" class="inline-flex size-5 items-center justify-center align-middle text-slate-500 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-neutral-400 dark:hover:text-white" type="button" aria-label="{{ __('More info about recording date') }}">
            <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </button>
    </label>

    <div class="relative w-full">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="size-4 text-blue-700 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
            </svg>
        </div>
        <input id="recording-date" datepicker datepicker-autohide datepicker-format="yyyy-mm-dd"
               name="recording_date"
               value="{{ $date ?? ''}}"
               type="text"
               class="block w-full rounded-lg border-slate-300 bg-white p-3 pl-10 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-white dark:placeholder:text-neutral-500"
               placeholder="{{__("Select date")}}" required>
    </div>
    @error('recording_date')
    <p class="mt-2 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
    @enderror
</div>
