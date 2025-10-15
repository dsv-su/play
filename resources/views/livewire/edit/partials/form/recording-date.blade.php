<div class="flex flex-col gap-y-1">
    <label for="recording-date" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        {{__("Recording date")}}
        <button id="recording-date-button" data-modal-toggle="date-modal" class="inline" type="button">
            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </button>
    </label>

    <div class="flex items-center gap-x-1.5">
        <div class="flex flex-col sm:flex-row items-center w-full">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-blue-700 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                    </svg>
                </div>
                @error('recording_date')
                <p class="mt-3 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
                @enderror
                <input id="datepicker-autohide" datepicker datepicker-autohide datepicker-format="yyyy-mm-dd"
                       name="recording_date"
                       value="{{ $date ?? ''}}"
                       id="startInput" type="text"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5
                                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500
                                        dark:focus:border-blue-500" placeholder="{{__("Select date")}}" required>
            </div>
        </div>
    </div>
</div>
