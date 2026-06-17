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
            class="block w-full rounded-lg border-slate-300 bg-white p-3 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white dark:placeholder:text-neutral-500"
            wire:model.live.debounce.300ms="searchTag"
            placeholder="{{__('Start typing to add a tag')}}"
            autocomplete="off"
            role="combobox"
            aria-autocomplete="list"
            aria-expanded="{{ filled($searchTag) ? 'true' : 'false' }}"
            aria-controls="tag-search-results"
        />

        @if(filled($searchTag))
            <div id="tag-search-results" role="listbox"
                 class="absolute left-0 right-0 top-full z-50 mt-2 rounded-lg border border-slate-200 bg-white p-2 shadow-lg
                  max-h-[calc(100vh-8rem)] overflow-y-auto
                  dark:border-neutral-700 dark:bg-neutral-900">
                <ul class="space-y-2">
                    @foreach($tags as $i => $tag)
                        <li wire:key="tag-{{ $tag['id'] ?? $tag['name'] }}">

                            <button
                                type="button"
                                role="option"
                                id="tag-result-{{ $i }}"
                                aria-selected="{{ $highlighted === $i ? 'true' : 'false' }}"
                                class="w-full rounded-lg border border-slate-200 p-3 text-left transition hover:bg-blue-50 active:bg-blue-100 dark:border-neutral-700 dark:hover:bg-neutral-800 dark:active:bg-neutral-700 sm:p-4 {{ $highlighted === $i ? 'bg-blue-100 dark:bg-neutral-800' : '' }}"
                                wire:click="addTag('{{ $tag['id'] ?? null }}', '{{ addslashes($tag['name'] ?? $searchTag) }}')"
                                x-on:click="$wire.set('searchTag','')"
                            >

                                <div class="flex items-start gap-2">
                                    <svg class="size-5 shrink-0 text-emerald-700 dark:text-emerald-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                    </svg>
                                    <div class="min-w-0 text-sm leading-tight text-slate-900 dark:text-slate-100">
                                        <span class="font-medium">
                                            @if(($tag['id'] ?? null) === null)
                                                <span class="inline-flex w-auto items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700 dark:bg-neutral-800 dark:text-neutral-300">
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
