<div class="flex flex-col gap-1">
    <label for="playback" class="text-sm text-gray-600 dark:text-neutral-400">
        {{__("Playback Permission")}}
    </label>

    <select
        wire:model.live="playback"
        name="playback"
        id="playback"
        class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm bg-gray-50
               focus:border-blue-500 focus:ring-blue-500
               disabled:opacity-50 disabled:pointer-events-none
               dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
        @foreach($permissions as $permission)
            <option value="{{ $permission->id }}">
                {{ $permission->scope }}
            </option>
        @endforeach
    </select>
</div>

