@php
    $presentationTitle = isset($video) && $video->title ? $video->title : __("Presentation");
@endphp

<div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
    <div class="min-w-0 flex-1">
        <div class="mb-2 flex flex-wrap items-center gap-2">
            <span class="rounded-md border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold uppercase text-emerald-700 dark:border-emerald-900/70 dark:bg-emerald-950 dark:text-emerald-300">
                @if($type === 'edit')
                    {{ __("Editing") }}
                @else
                    {{ __("New presentation") }}
                @endif
            </span>
        </div>
        <h1 class="break-words text-2xl font-semibold text-slate-950 sm:text-3xl dark:text-white">
            {{ $presentationTitle }}
        </h1>
    </div>
</div>
