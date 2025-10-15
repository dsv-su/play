<div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
        <div class="flex flex-col gap-y-1">
            <label for="course" class="font-sans block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                {{__("Presenters:")}}
            </label>

            <div>
                @include('livewire.edit.partials.form.presenter-add')
            </div>
        </div>

        <!-- Column right -->
        <div class="flex flex-col gap-y-2">
            <div class="flex flex-wrap gap-x-2 gap-y-1">
                @foreach($presenters as $key => $presenter)

                    <span class="inline-flex items-center gap-x-1.5 py-1 ps-2 pe-2 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                      {{$presenter['name']}}


                        @if($presenter['role'] === 'DSV')
                        <span class="inline-flex w-auto items-center gap-x-1.5 py-1 px-1.5 rounded text-xs font-medium
                                 bg-suprimary text-white dark:bg-blue-800/30 dark:text-blue-500">
                            {{$presenter['role']}}</span>
                        @elseif($presenter['role'] === 'Student')
                            <span class="inline-flex w-auto items-center gap-x-1.5 py-1 px-1.5 rounded text-xs font-medium
                                 bg-green-600 text-white dark:bg-blue-800/30 dark:text-blue-500">
                                {{$presenter['role']}} </span>
                        @else
                            <span class="inline-flex w-auto items-center gap-x-1.5 py-1 px-1.5 rounded text-xs font-medium
                                 bg-gray-200 text-gray-600 dark:bg-blue-800/30 dark:text-blue-500">
                                External</span>
                        @endif
                        <button type="button"
                                wire:click="remove_presenter({{$key}})"
                                class="shrink-0 size-4 inline-flex items-center justify-center rounded-full hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 focus:text-blue-500 dark:hover:bg-blue-900">
                        <span class="sr-only">Remove</span>
                        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                        </span>

                    </span>
                @endforeach
            </div>
        </div>

    </div>

</div>
