@if (count($individualPermissions) > 0)
    <div class="mt-3 space-y-2">
        @foreach($individualPermissions as $key => $name)
            <div class="flex w-full flex-col gap-2 rounded-lg border border-slate-200 bg-white p-2 text-slate-800 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 sm:flex-row sm:items-center">

                <div class="min-w-0 flex-1 px-2 py-1 text-sm font-medium">
                    <span class="block truncate">{{ $name['name'] }}</span>
                    <span class="block text-xs text-slate-500 dark:text-neutral-400">{{ $name['username'] }}</span>
                </div>

                <div class="flex w-full items-center gap-2 sm:w-auto">
                    <select wire:change="setPermission({{ $key }}, $event.target.value)"
                            aria-label="{{ __('Permission level for') }} {{ $name['name'] }}"
                            class="w-full rounded-lg border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-70 dark:border-neutral-700 dark:bg-neutral-950 dark:text-white sm:w-32">

                        <option value="read" {{ $name['permission'] === 'read' ? 'selected' : '' }}>
                            {{ __("Read") }}
                        </option>

                        <option value="edit"
                            {{ $name['permission'] === 'edit' ? 'selected' : '' }}
                            {{ ($user_permission !== 'delete' && $name['permission'] === 'read') ? 'disabled' : '' }}>
                            {{ __("Edit") }}
                        </option>

                        <option value="delete"
                            {{ $name['permission'] === 'delete' ? 'selected' : '' }}
                            {{ ($user_permission !== 'delete' && in_array($name['permission'], ['read','edit'], true)) ? 'disabled' : '' }}>
                            {{ __("Delete") }}
                        </option>
                    </select>

                    <button type="button"
                            class="flex size-10 shrink-0 items-center justify-center rounded-lg border border-slate-300 text-slate-500 hover:bg-red-50 hover:text-red-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-red-950 dark:hover:text-red-300"
                            wire:click="remove_user({{ $key }})"
                            aria-label="{{ __('Remove individual permission for') }} {{ $name['name'] }}">
                        <svg class="size-5" aria-hidden="true" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 12h4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

@else
    <div class="mt-3 rounded-lg border border-dashed border-slate-300 bg-white px-4 py-3 text-sm text-slate-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400">{{ __("No individual permissions added") }}</div>
@endif
