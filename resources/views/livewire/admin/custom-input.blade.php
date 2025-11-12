<div>
    {{--}}
    <div class="relative w-full"
         x-data
         x-on:keydown.arrow-down.prevent="$wire.moveHighlight(1)"
         x-on:keydown.arrow-up.prevent="$wire.moveHighlight(-1)"
         x-on:keydown.enter.prevent="$wire.addHighlighted()"
         x-on:click.outside="$wire.set('searchUser','')"
         x-on:keydown.escape.prevent="$wire.set('searchUser','')"
    >
    {{--}}
    <input
        wire:model.live.debounce.300ms="searchUser"
        type="search"
        id="custom-user"
        name="custom"
        autocomplete="off"
        placeholder="{{ __('Custom user') }}"
        aria-label="{{ __('Custom user') }}"
        role="combobox"
        aria-expanded="{{ filled($searchUser) ? 'true' : 'false' }}"
        aria-controls="search-results"
        class="w-full sm:w-64 rounded-md border border-gray-600 bg-gray-800 text-gray-100 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    @if(filled($searchUser))
        <div id="search-results" role="listbox"
             class="absolute left-0 right-0 top-full mt-2 bg-white border border-slate-200 shadow-md rounded-md p-2 z-50
                  max-h-[calc(100vh-8rem)] overflow-y-auto
                  dark:bg-slate-900 dark:border-slate-800">
            <ul class="space-y-2">
                @foreach($sukatUsers as $i => $sukatUser)
                    <li wire:key="presenter-{{ $sukatUser->uid ?? $sukatUser->name }}">
                        <button
                            type="button"
                            role="option"
                            class="w-full text-left border rounded-lg p-3 sm:p-4 transition
                                       border-slate-200 hover:bg-blue-50 active:bg-blue-100
                                       dark:border-slate-800 dark:hover:bg-slate-800 dark:active:bg-slate-700
                                       {{ $highlighted === $i ? 'bg-blue-100 dark:bg-slate-700' : '' }}"
                            wire:click="addUser('{{ $sukatUser->uid }}', '{{ addslashes($sukatUser->name) }}')"
                            x-on:click="$wire.set('searchUser','')"
                        >
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6 text-gray-800 dark:text-white shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                </svg>
                                <div class="text-xs sm:text-base leading-tight min-w-0 text-slate-900 dark:text-slate-100">
                                        <span class="font-medium">
                                            @if($sukatUser->role === 'External')
                                                <span class="inline-flex w-auto items-center gap-x-1.5 py-1 px-1.5 rounded-md text-xs font-medium
                                                        bg-gray-50 text-slate-900 dark:bg-blue-800/30 dark:text-blue-500">
                                                    {{__('New External: ')}}
                                                </span>
                                            @endif
                                            {{ $sukatUser->name }}
                                        </span>
                                    @php $role = $sukatUser->role ?? 'Other'; @endphp
                                    @if($role === 'DSV')
                                        <span class="inline-flex w-auto items-center gap-x-1.5 py-1 px-1.5 rounded-md text-xs font-medium
                                                        bg-suprimary text-white dark:bg-blue-800/30 dark:text-blue-500">
                                                {{ $role }}
                                            </span>
                                    @elseif($role === 'Student')
                                        <span class="inline-flex w-auto items-center gap-x-1.5 py-1 px-1.5 rounded-md text-xs font-medium
                                                           bg-green-500 text-white dark:bg-blue-800/30 dark:text-blue-500">
                                                {{ $role }}
                                            </span>
                                    @else
                                        <span class="inline-flex w-auto items-center gap-x-1.5 py-1 px-1.5 rounded-md text-xs font-medium
                                                           bg-gray-200 text-gray-600 dark:bg-blue-800/30 dark:text-blue-500">
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
