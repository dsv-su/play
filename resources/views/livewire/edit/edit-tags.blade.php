<div>
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
        <div class="min-w-0 rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-neutral-700 dark:bg-neutral-950">
            <label for="tag-input" class="block text-sm font-medium text-slate-900 dark:text-white">
                {{__("Add tag")}}
            </label>
            <p class="mt-1 mb-3 text-sm text-slate-500 dark:text-neutral-400">{{__("Search existing tags or create a new one by typing its name.")}}</p>

            <div>
                @include('livewire.edit.partials.form.tag-add')
            </div>
        </div>

        <div class="min-w-0 rounded-lg border border-slate-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-950">
            <h3 class="text-sm font-medium text-slate-900 dark:text-white">{{__("Current tags")}}</h3>

            <div class="mt-3 flex flex-wrap gap-2">
                @if(!empty($videoTags))
                    @foreach($videoTags as $key => $tag)
                        <span class="inline-flex items-center gap-x-2 rounded-full border border-emerald-200 bg-emerald-50 py-1 ps-3 pe-1 text-xs font-medium text-emerald-800 dark:border-emerald-900/70 dark:bg-emerald-950 dark:text-emerald-300">
                          {{$tag['name']}}

                            <button type="button"
                                    wire:click="remove_tag({{$key}})"
                                    class="inline-flex size-5 shrink-0 items-center justify-center rounded-full text-emerald-700 hover:bg-emerald-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 dark:text-emerald-200 dark:hover:bg-emerald-900">
                                <span class="sr-only">{{__("Remove")}}</span>
                                <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 6 6 18"></path>
                                    <path d="m6 6 12 12"></path>
                                </svg>
                            </button>
                        </span>
                    @endforeach
                @else
                    <p class="text-sm text-slate-500 dark:text-neutral-400">{{__('No tags added yet.')}}</p>
                @endif
            </div>
        </div>

    </div>

</div>
