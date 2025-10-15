@if (count($individualPermissions) > 0)

    @foreach($individualPermissions as $key => $name)
        <div class="flex items-center w-full gap-1 py-0 text-gray-800
            dark:bg-slate-800 dark:text-slate-100 dark:border-slate-700">

            <!-- User name -->
            <div class="flex-1 min-w-[200px] px-3 py-2 border rounded-md bg-white text-sm font-medium
                border-gray-300 shadow-sm dark:bg-slate-700 dark:border-slate-600">
                {{ $name['name'] }} ({{$name['username']}})
            </div>

            <!-- Permission Select -->
            <select
                wire:change="setPermission({{ $key }}, $event.target.value)"
                class="flex-none w-30 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 disabled:opacity-70">
                <option value="read"   {{ $name['permission'] === 'read' ? 'selected' : '' }}>Read</option>
                <option value="edit"   {{ $name['permission'] === 'edit' ? 'selected' : '' }}>Edit</option>
                <option value="delete" {{ $name['permission'] === 'delete' ? 'selected' : '' }}>Delete</option>
            </select>

            <!-- Remove Button -->
            <button
                type="button"
                class="flex-none w-10 h-10 p-2 text-gray-500 hover:text-gray-700 flex items-center justify-center"
                wire:click="remove_user({{ $key }})">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 12h4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </button>
        </div>
    @endforeach

@else
    <div class="mx-1 my-2 text-base">{{ __("No individual permissions added") }}</div>
@endif

