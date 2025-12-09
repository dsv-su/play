@if ($video->delete && $video->state)
    <form
        method="POST"
        action="{{ route('presentation.destroy', $video->id) }}"
        onsubmit="return confirm('{{ __('Delete presentation? This cannot be undone.') }}')"
        class="contents">
        @csrf
        @method('DELETE')
        <button
            type="submit"
            data-tooltip-target="delete-tooltip"
            data-tooltip-placement="top"
            class="inline-flex items-center gap-1 px-1 py-1 text-xs font-medium bg-transparent rounded-md text-red-700 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-600"
            title="{{ __('Delete presentation') }}"
            aria-label="{{ __('Delete presentation') }}">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
            </svg>
        </button>
    </form>
@endif
