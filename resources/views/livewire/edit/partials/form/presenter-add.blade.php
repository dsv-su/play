<div class="flex justify-start">
    <div class="relative w-full"
         x-data
         x-on:keydown.arrow-down.prevent="$wire.moveHighlight(1)"
         x-on:keydown.arrow-up.prevent="$wire.moveHighlight(-1)"
         x-on:keydown.enter.prevent="$wire.addHighlighted()"
         x-on:click.outside="$wire.set('searchPresenter','')"
         x-on:keydown.escape.prevent="$wire.set('searchPresenter','')"
    >
        <input
            id="presenter-input"
            type="text"

            class="block w-full rounded-lg border-slate-300 bg-white p-3 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white dark:placeholder:text-neutral-500"
            wire:model.live.debounce.300ms="searchPresenter"
            placeholder="{{__('Start typing to add a presenter')}}"
            autocomplete="off"
            role="combobox"
            aria-expanded="{{ filled($searchPresenter) ? 'true' : 'false' }}"
            aria-controls="search-results"
        />

        @if(filled($searchPresenter))
            <div id="search-results" role="listbox"
                 class="absolute left-0 right-0 top-full z-50 mt-2 rounded-lg border border-slate-200 bg-white p-2 shadow-lg
                  max-h-[calc(100vh-8rem)] overflow-y-auto
                  dark:border-neutral-700 dark:bg-neutral-900">
                <ul class="space-y-2">
                    @foreach($sukatUsers as $i => $sukatUser)
                        <li wire:key="presenter-{{ $sukatUser->uid ?? $sukatUser->name }}">
                            <button
                                type="button"
                                role="option"
                                class="w-full rounded-lg border border-slate-200 p-3 text-left transition hover:bg-blue-50 active:bg-blue-100 dark:border-neutral-700 dark:hover:bg-neutral-800 dark:active:bg-neutral-700 sm:p-4 {{ $highlighted === $i ? 'bg-blue-100 dark:bg-neutral-800' : '' }}"
                                                wire:click="addPresenter('{{ $sukatUser->uid }}', '{{ addslashes($sukatUser->name) }}')"
                                                x-on:click="$wire.set('searchPresenter','')"
                                                >
                                <div class="flex items-start gap-2">
                                    <svg class="size-5 shrink-0 text-blue-700 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                    </svg>
                                    <div class="min-w-0 text-sm leading-tight text-slate-900 dark:text-slate-100">
                                        <span class="font-medium">
                                            @if($sukatUser->role === 'External')
                                                <span class="inline-flex w-auto items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700 dark:bg-neutral-800 dark:text-neutral-300">
                                                    {{__('New External: ')}}
                                                </span>
                                            @endif
                                            {{ $sukatUser->name }}
                                        </span>
                                        @php $role = $sukatUser->role ?? 'Other'; @endphp
                                        @if($role === 'DSV')
                                            <span class="inline-flex w-auto items-center rounded-full bg-suprimary px-2 py-0.5 text-xs font-medium text-white dark:bg-blue-800 dark:text-blue-100">
                                                {{ $role }}
                                            </span>
                                        @elseif($role === 'Student')
                                            <span class="inline-flex w-auto items-center rounded-full bg-emerald-600 px-2 py-0.5 text-xs font-medium text-white dark:bg-emerald-800 dark:text-emerald-100">
                                                {{ $role }}
                                            </span>
                                        @else
                                            <span class="inline-flex w-auto items-center rounded-full bg-slate-200 px-2 py-0.5 text-xs font-medium text-slate-700 dark:bg-neutral-800 dark:text-neutral-300">
                                                External
                                            </span>
                                        @endif
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

@foreach($presenters as $i => $p)
    <input type="hidden" name="presenters[{{ $i }}][uid]"  value="{{ $p['uid'] ?? '' }}" wire:key="pr-uid-{{ $i }}">
    <input type="hidden" name="presenters[{{ $i }}][name]" value="{{ $p['name'] ?? '' }}" wire:key="pr-name-{{ $i }}">
    <input type="hidden" name="presenters[{{ $i }}][type]" value="{{ $p['type'] ?? '' }}" wire:key="pr-type-{{ $i }}">
    <input type="hidden" name="presenters[{{ $i }}][role]" value="{{ $p['role'] ?? '' }}" wire:key="pr-role-{{ $i }}">
@endforeach
