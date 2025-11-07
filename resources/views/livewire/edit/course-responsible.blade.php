<div
    x-data
    x-on:courses-selected.window="$wire.set('selectedCourses', $event.detail.ids)">
    <div class="flex flex-wrap items-start gap-1">
        @foreach($courseResponsible as $group)
            @foreach($group as $person)
                <span class="inline-flex w-auto items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium
                         bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                {{ $person['firstName'] }} {{ $person['lastName'] }}
            </span>
            @endforeach
        @endforeach
    </div>
</div>

