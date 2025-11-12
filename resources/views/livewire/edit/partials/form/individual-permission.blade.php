<div class="flex flex-col gap-1">
    <label for="playback" class="text-sm text-gray-600 dark:text-neutral-400">
        {{__("Individual Permissions")}}
        <span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700">
          {{$iPCount}} {{ __("Set") }}
        </span>
    </label>

    <div class="flex justify-start">
        <div class="relative w-full"
             x-data
             x-on:keydown.arrow-down.prevent="$wire.moveHighlight(1)"
             x-on:keydown.arrow-up.prevent="$wire.moveHighlight(-1)"
             x-on:keydown.enter.prevent="$wire.addHighlighted()"
             x-on:click.outside="$wire.set('searchP','')"
             x-on:keydown.escape.prevent="$wire.set('searchP','')"
        >
            <input
                id="permission-input"
                type="text"
                class="p-3 w-full border rounded-md text-sm
             bg-gray-50 text-gray-800 placeholder:text-gray-500
             border-slate-300
             focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
             dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-400
             dark:border-slate-700 dark:focus:ring-blue-400"
                wire:model.live.debounce.300ms="searchP"
                placeholder="{{__('Start typing name or username')}}"
                autocomplete="off"
                role="combobox"
                aria-expanded="{{ filled($searchP) ? 'true' : 'false' }}"
                aria-controls="search-results"
            />

            @if(filled($searchP))
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
                                    wire:click="addPermission('{{ $sukatUser->uid }}', '{{ addslashes($sukatUser->name) }}')"
                                    x-on:click="$wire.set('searchP','')"
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
                                            {{ $sukatUser->name }} | {{ $sukatUser->uid }}
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
                                                SU
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
    @include('livewire.edit.partials.form.individual-permission-set')

    @foreach($individualPermissions as $i => $t)
        <input type="hidden" name="individualpermission[{{ $i }}][uid]"  value="{{ $t['username'] ?? '' }}" wire:key="pr-id-{{ $i }}">
        <input type="hidden" name="individualpermission[{{ $i }}][name]" value="{{ $t['name'] ?? '' }}" wire:key="pr-name-{{ $i }}">
        <input type="hidden" name="individualpermission[{{ $i }}][permission]" value="{{ $t['permission'] ?? '' }}" wire:key="pr-permission-{{ $i }}">
    @endforeach

</div>
