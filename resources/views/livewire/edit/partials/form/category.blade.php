<div class="min-w-0 rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-neutral-700 dark:bg-neutral-950">
    <label for="category" class="block text-sm font-medium text-slate-900 dark:text-white">
        {{__("Category")}}
    </label>
    <p class="mt-1 mb-3 text-sm text-slate-500 dark:text-neutral-400">{{__("Use the category to place the presentation in the correct DSVPlay context.")}}</p>

    @php
        $categories = [
            1 => 'DSV presentation (default)',
            2 => 'Studieadmin information presentation',
            8 => 'NextiLearn tutorial presentation',
        ];
    @endphp

    <select
        id="category"
        wire:model.live="category"
        name="category"
        aria-label="{{ __('Select a video category') }}"
        class="block w-full rounded-lg border-slate-300 bg-white px-4 py-3 pe-9 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white dark:placeholder:text-neutral-500">
        <option value="" disabled selected>{{__("Choose a category")}}</option>
        @foreach($categories as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>
</div>
