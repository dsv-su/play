@php
    $presentationTitle = isset($video) && $video->title ? $video->title : __("Presentation");
@endphp

<div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
    <div class="min-w-0 flex-1">
        <div class="mb-2 flex flex-wrap items-center gap-2">
            <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase text-emerald-700 dark:border-emerald-900/70 dark:bg-emerald-950 dark:text-emerald-300">
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
        <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600 dark:text-neutral-300">
            {{ __("Work from top to bottom: update the title and description, connect courses and people, decide who can watch it, then review media and subtitle files.") }}
        </p>
    </div>

    @if(in_array($type, ['edit']))
        <div class="grid w-full gap-3 sm:grid-cols-2 lg:w-auto lg:min-w-80">
            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase text-slate-500 dark:text-neutral-400">{{ __("Duration") }}</p>
                <p class="mt-1 text-lg font-semibold text-slate-950 dark:text-white">{{$video->duration}}</p>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <p class="flex items-center gap-1 text-xs font-medium uppercase text-slate-500 dark:text-neutral-400">
                    {{ __("Origin") }}
                    <button id="origin-button" data-modal-toggle="origin-modal" type="button" class="inline-flex size-5 items-center justify-center rounded-full text-slate-500 hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white" aria-label="{{ __('More info about origin') }}">
                        <svg class="size-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </button>
                </p>
                <p class="mt-1 text-lg font-semibold text-slate-950 dark:text-white">
                    @switch($video->origin)
                        @case('mediasite') {{ __("Mediasite") }} @break
                        @case('cattura') {{ __("DSV") }} @break
                        @case('manual') {{ __("Uploaded") }} @break
                        @default {{ __("Unknown") }}
                    @endswitch
                </p>
            </div>
        </div>
    @endif
</div>
