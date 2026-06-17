@php
    $presentationCount = $videos instanceof \Illuminate\Support\Collection
        ? $videos->flatten(1)->unique('id')->count()
        : $totalCount;
@endphp

<div class="flex min-h-[3.25rem] items-center gap-2 rounded-xl border border-gray-200 bg-white px-3 py-2 shadow-sm dark:border-neutral-800 dark:bg-neutral-950">
    <div class="inline-flex min-w-9 shrink-0 items-center justify-center rounded-lg bg-blue-700 px-2 py-1 text-sm font-semibold text-white dark:bg-blue-600">
        {{ $presentationCount }}
    </div>
    <div class="text-sm font-medium leading-tight text-gray-700 dark:text-neutral-300">
        @if($presentationCount == 1)
            {{__("Presentation")}}
        @else
            {{ __("Presentations") }}
        @endif
    </div>
</div>
