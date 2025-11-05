<div class="flex flex-col gap-y-1 w-full md:w-1/2">
    <label for="duration" class="font-sans block mb-1 text-sm font-medium text-gray-900 dark:text-white">
        {{__("Visibility")}}
    </label>

    <select
        wire:model.live="visibility"
        name="visibility"
        class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm bg-gray-50
                       focus:border-blue-500 focus:ring-blue-500
                       disabled:opacity-50 disabled:pointer-events-none
                       dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
        <option value="" selected disabled>Choose visibility</option>
        <option value="visible">{{__("Visible: Searchable and playable")}}</option>
        <option value="private">{{__("Private: Hidden, not searchable or playable")}}</option>
        <option value="unlisted">{{__("Unlisted: Hidden, not searchable, playable with a direct link")}}</option>
    </select>

</div>
