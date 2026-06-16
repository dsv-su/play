<div class="min-w-0 rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-neutral-700 dark:bg-neutral-950">
    <label for="visibility" class="block text-sm font-medium text-slate-900 dark:text-white">
        {{__("Visibility")}}
    </label>
    <p class="mt-1 mb-3 text-sm text-slate-500 dark:text-neutral-400">{{__("This controls whether users can search for and play the presentation.")}}</p>

    <select
        id="visibility"
        wire:model.live="visibility"
        name="visibility"
        class="block w-full rounded-lg border-slate-300 bg-white px-4 py-3 pe-9 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white dark:placeholder:text-neutral-500">
        <option value="" selected disabled>{{__("Choose visibility")}}</option>
        <option value="visible">{{__("Visible: Searchable and playable")}}</option>
        <option value="private">{{__("Private: Hidden, not searchable or playable")}}</option>
        <option value="unlisted">{{__("Unlisted: Hidden, not searchable, playable with a direct link")}}</option>
    </select>
</div>
