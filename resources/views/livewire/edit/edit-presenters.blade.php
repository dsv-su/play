<div>
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
        <div class="min-w-0 rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-neutral-700 dark:bg-neutral-950">
            <label for="presenter-input" class="block text-sm font-medium text-slate-900 dark:text-white">
                {{__("Add presenter")}}
            </label>
            <p class="mt-1 mb-3 text-sm text-slate-500 dark:text-neutral-400">{{__("Search by name and select a result to add it to the presentation.")}}</p>

            <div>
                @include('livewire.edit.partials.form.presenter-add')
            </div>
        </div>

        <div class="min-w-0 rounded-lg border border-slate-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-950">
            <h3 class="text-sm font-medium text-slate-900 dark:text-white">{{__("Current presenters")}}</h3>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach($presenters as $key => $presenter)

                    <span class="inline-flex items-center gap-x-2 rounded-full border border-blue-200 bg-blue-50 py-1 ps-3 pe-1 text-xs font-medium text-blue-800 dark:border-blue-900/70 dark:bg-blue-950 dark:text-blue-300">
                      {{$presenter['name']}}


                        @if($presenter['role'] === 'DSV')
                        <span class="inline-flex w-auto items-center rounded-full bg-suprimary px-2 py-0.5 text-[0.7rem] font-medium text-white dark:bg-blue-800 dark:text-blue-100">
                            {{$presenter['role']}}</span>
                        @elseif($presenter['role'] === 'Student')
                            <span class="inline-flex w-auto items-center rounded-full bg-emerald-600 px-2 py-0.5 text-[0.7rem] font-medium text-white dark:bg-emerald-800 dark:text-emerald-100">
                                {{$presenter['role']}} </span>
                        @else
                            <span class="inline-flex w-auto items-center rounded-full bg-slate-200 px-2 py-0.5 text-[0.7rem] font-medium text-slate-700 dark:bg-neutral-800 dark:text-neutral-300">
                                External</span>
                        @endif
                        <button type="button"
                                wire:click="remove_presenter({{$key}})"
                                class="inline-flex size-6 shrink-0 items-center justify-center rounded-full text-blue-700 hover:bg-blue-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-blue-200 dark:hover:bg-blue-900"
                                aria-label="{{ __('Remove presenter') }} {{$presenter['name']}}">
                        <span class="sr-only">{{ __('Remove presenter') }} {{$presenter['name']}}</span>
                        <svg class="shrink-0 size-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                        </span>

                    </span>
                @endforeach
                @if(empty($presenters))
                    <p class="text-sm text-slate-500 dark:text-neutral-400">{{__("No presenters added yet.")}}</p>
                @endif
            </div>
        </div>

    </div>

</div>
