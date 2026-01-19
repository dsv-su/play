@if (count($individualPermissions) > 0)
    @foreach($individualPermissions as $key => $name)
        <div class="flex flex-col sm:flex-row w-full gap-2 py-2 text-gray-800
                    dark:bg-slate-800 dark:text-slate-100 dark:border-slate-700">

            <!-- User name -->
            <div class="flex-1 min-w-0 px-3 py-2 border-0 sm:border rounded-md sm:rounded-md bg-transparent sm:bg-white
                        text-sm font-medium shadow-none sm:shadow-sm
                        sm:border-gray-300 dark:bg-slate-700 dark:sm:border-slate-600 text-center sm:text-left">
                {{ $name['name'] }} ({{ $name['username'] }})
            </div>

            <!-- Controls container -->
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <!-- Permission Select -->
                {{--}}<select wire:change="setPermission({{ $key }}, $event.target.value)"
                        class="flex-1 sm:flex-none w-full sm:w-32 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm
                        focus:border-blue-500 focus:ring-1 focus:ring-blue-500 disabled:opacity-70 dark:text-gray-300 dark:bg-slate-700 dark:sm:border-slate-600">

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
                </select>{{--}}
            <!-- Permission Select -->
                <select wire:change="setPermission({{ $key }}, $event.target.value)"
                        class="flex-1 sm:flex-none w-full sm:w-32 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm
                        focus:border-blue-500 focus:ring-1 focus:ring-blue-500 disabled:opacity-70 dark:text-gray-300 dark:bg-slate-700 dark:sm:border-slate-600">

                    <option value="read" {{ $name['permission'] === 'read' ? 'selected' : '' }}>
                        {{ __("Read") }}
                    </option>

                    <option value="edit"
                        {{ $name['permission'] === 'edit' ? 'selected' : '' }}
                        {{ ($user_permission !== 'delete' && in_array($name['permission'], ['read','edit'], true)) ? 'disabled' : '' }}>
                        {{ __("Edit") }}
                    </option>

                    <option value="delete"
                        {{ $name['permission'] === 'delete' ? 'selected' : '' }}
                        {{ ($user_permission !== 'delete' && in_array($name['permission'], ['read','edit','delete'], true)) ? 'disabled' : '' }}>
                        {{ __("Delete") }}
                    </option>
                </select>


                <!-- Remove Button -->
                <button type="button"
                        class="w-10 h-10 flex items-center justify-center rounded-md border border-gray-300 text-gray-500 hover:text-gray-700
                                dark:border-slate-600 dark:text-slate-300 dark:hover:text-white"
                        wire:click="remove_user({{ $key }})">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 12h4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                </button>
            </div>
        </div>
    @endforeach

@else
    <div class="mx-1 my-2 text-base">{{ __("No individual permissions added") }}</div>
@endif

