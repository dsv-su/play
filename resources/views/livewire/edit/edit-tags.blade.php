<div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
        <div class="flex flex-col gap-y-1">
            <label for="course" class="font-sans block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                {{__("Tags")}}
            </label>

            <div>
                @include('livewire.edit.partials.form.tag-add')
            </div>
        </div>

        <!-- Column right -->
        <div class="flex flex-col gap-y-2">
            <label for="course" class="font-sans block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                {{__("Tags")}}
            </label>

            <div class="flex flex-wrap gap-x-2 gap-y-1">
                @if(!empty($videoTags))
                    @foreach($videoTags as $key => $tag)
                        <span class="inline-flex items-center gap-x-1.5 py-1 ps-2 pe-2 span bg-green-100 text-green-800 text-xs font-medium rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                          {{$tag['name']}}

                            <button type="button"
                                    wire:click="remove_tag({{$key}})"
                                    class="shrink-0 size-4 inline-flex items-center justify-center rounded-full hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 focus:text-blue-500 dark:hover:bg-blue-900">
                                <span class="sr-only">Remove</span>
                                <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 6 6 18"></path>
                                    <path d="m6 6 12 12"></path>
                                </svg>
                            </button>
                        </span>
                    @endforeach
                @else
                    <span class="font-1rem">{{__('No tags added')}}</span>
                @endif
            </div>
        </div>

    </div>

</div>

