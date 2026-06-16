<div class="flex flex-col gap-1">
    <label for="playback" class="text-sm font-medium text-slate-900 dark:text-white">
        {{__("Playback Permission")}}
    </label>
    <p class="mb-2 text-sm text-slate-500 dark:text-neutral-400">{{__("Select the general audience allowed to play this presentation.")}}</p>

    <select
        wire:model.live="playback"
        name="playback"
        id="playback"
        class="block w-full rounded-lg border-slate-300 bg-white px-4 py-3 pe-9 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white dark:placeholder:text-neutral-500">
        @foreach($permissions as $permission)
            <option value="{{ $permission->id }}">
                {{ $permission->scope }}
            </option>
        @endforeach
    </select>
</div>
