@php
    $tooltipPrefix = 'search-'.$this->getId().'-'.$video->id;
@endphp
<div class="inline-flex rounded-md shadow-sm space-x-0.5" role="group" data-search-result-actions>
    <a
        href="{{ route('presentation.edit', $video->id) }}"
        data-tooltip-target="{{ $tooltipPrefix }}-edit-tooltip"
        class="inline-flex min-h-6 min-w-6 items-center justify-center gap-1 px-1 py-1 text-xs font-medium border border-green-800 text-green-800 bg-transparent rounded-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 dark:focus-visible:outline-blue-400 hover:bg-green-100 dark:border-green-300 dark:text-green-300 dark:hover:bg-green-950"
        aria-label="{{ __('Edit') }}">
        <svg aria-hidden="true" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
        </svg>
        {{ __('Edit') }}
    </a>
    <span id="{{ $tooltipPrefix }}-edit-tooltip" hidden>{{ __('Edit presentation') }}</span>
    @can('admin-content')
        <form
            method="POST"
            action="{{ route('presentation.destroy', $video->id) }}"
            onsubmit="return confirm(@js(__('Delete presentation? This cannot be undone.')))"
            class="contents">
            @csrf
            @method('DELETE')
            <button
                type="submit"
                data-tooltip-target="{{ $tooltipPrefix }}-delete-tooltip"
                class="inline-flex min-h-6 min-w-6 items-center justify-center gap-1 px-1 py-1 text-xs font-medium bg-transparent rounded-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 dark:focus-visible:outline-blue-400 text-red-700 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-600"
                aria-label="{{ __('Delete presentation') }}">
                <svg aria-hidden="true" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                </svg>
            </button>
        </form>
        <span id="{{ $tooltipPrefix }}-delete-tooltip" hidden>{{ __('Delete presentation') }}</span>
    @endcan
</div>


