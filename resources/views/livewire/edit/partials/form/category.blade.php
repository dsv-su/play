<div class="flex flex-col gap-y-1 w-full md:w-1/2">
    <label for="duration" class="font-sans block mb-1 text-sm font-medium text-gray-900 dark:text-white">
        {{__("Category")}}
    </label>

    @php
        $categories = [
            1 => 'DSV presentation (default)',
            2 => 'Studieadmin information video',
            8 => 'NextiLearn tutorial video',
        ];
    @endphp

    <select
        wire:model.live="category"
        name="category"
        aria-label="Select a video category"
        class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm bg-gray-50
                       focus:border-blue-500 focus:ring-blue-500
                       disabled:opacity-50 disabled:pointer-events-none
                       dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
        <option value="" disabled selected>Choose a category</option>
        @foreach($categories as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>
</div>
