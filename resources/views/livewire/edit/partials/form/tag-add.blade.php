<div class="flex justify-start">
    <div class="relative w-full"
         x-data
         x-on:keydown.arrow-down.prevent="$wire.moveHighlight(1)"
         x-on:keydown.arrow-up.prevent="$wire.moveHighlight(-1)"
         x-on:keydown.enter.prevent="$wire.addHighlighted()"
         x-on:click.outside="$wire.set('searchTag','')"
         x-on:keydown.escape.prevent="$wire.set('searchTag','')"
    >
        <input
            id="tag-input"
            type="text"
            class="p-3 w-full border rounded-md text-sm
             bg-gray-50 text-gray-800 placeholder:text-gray-500
             border-slate-300
             focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
             dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-400
             dark:border-slate-700 dark:focus:ring-blue-400"
            wire:model.live.debounce.300ms="searchTag"
            placeholder="{{__('Start typing to add a tag')}}"
            autocomplete="off"
            role="combobox"
            aria-expanded="{{ filled($searchTag) ? 'true' : 'false' }}"
            aria-controls="search-results"
        />

        @if(filled($searchTag))
            <div id="search-results" role="listbox"
                 class="absolute left-0 right-0 top-full mt-2 bg-white border border-slate-200 shadow-md rounded-md p-2 z-50
                  max-h-[calc(100vh-8rem)] overflow-y-auto
                  dark:bg-slate-900 dark:border-slate-800">
                <ul class="space-y-2">
                    @foreach($tags as $i => $tag)
                        <li wire:key="tag-{{ $tag['id'] ?? $tag['name'] }}">

                            <button
                                type="button"
                                role="option"
                                class="w-full text-left border rounded-lg p-3 sm:p-4 transition
                                       border-slate-200 hover:bg-blue-50 active:bg-blue-100
                                       dark:border-slate-800 dark:hover:bg-slate-800 dark:active:bg-slate-700
                                       {{ $highlighted === $i ? 'bg-blue-100 dark:bg-slate-700' : '' }}"
                                wire:click="addTag('{{ $tag['id'] ?? null }}', '{{ addslashes($tag['name'] ?? $searchTag) }}')"
                                x-on:click="$wire.set('searchTag','')"
                            >

                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 sm:w-6 sm:h-6 text-gray-800 dark:text-white shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                    </svg>
                                    <div class="text-xs sm:text-base leading-tight min-w-0 text-slate-900 dark:text-slate-100">
                                        <span class="font-medium">
                                            @if(($tag['id'] ?? null) === null)
                                                <span class="inline-flex w-auto items-center gap-x-1.5 py-1 px-1.5 rounded-md text-xs font-medium
                                                        bg-gray-50 text-slate-900 dark:bg-blue-800/30 dark:text-blue-500">
                                                    {{__('New Tag: ')}}
                                                </span>
                                            @endif
                                            {{ $tag['name'] ?? $searchTag }}

                                        </span>

                                    </div>
                                </div>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

@foreach($videoTags as $i => $t)
    <input type="hidden" name="tags[{{ $i }}][id]"  value="{{ $t['id'] ?? '' }}" wire:key="pr-id-{{ $i }}">
    <input type="hidden" name="tags[{{ $i }}][name]" value="{{ $t['name'] ?? '' }}" wire:key="pr-name-{{ $i }}">
@endforeach

