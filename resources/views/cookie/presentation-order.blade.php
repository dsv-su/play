@php
    // Read cookie
    $raw = request()->cookie('presentation_order', '[]');
    $orderFromCookie = json_decode($raw, true);
    $order = \App\Support\HomePresentationOrder::sanitize($orderFromCookie);
@endphp

<div id="presentation-order" class="mt-5"
     data-store-url="{{ route('presentation-order.store') }}"
     data-saving-label="{{ __('Saving…') }}"
     data-save-label="{{ __('Save order') }}"
     data-success-message="{{ __('Order saved.') }}"
     data-error-message="{{ __('The order could not be saved. Please try again.') }}">
    <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-3 dark:border-neutral-800 dark:bg-neutral-900/60 sm:p-4">
        <ul id="component-list" class="space-y-2" aria-label="{{ __('Home page sections in display order') }}">
        @foreach ($order as $component)
            <li class="group flex items-center gap-3 rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm font-medium text-gray-800 shadow-sm transition dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-200"
                data-component="{{ $component }}">
                <button type="button" class="drag-handle cursor-grab touch-none rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 active:cursor-grabbing dark:hover:bg-neutral-800 dark:hover:text-neutral-200"
                        aria-label="{{ __('Drag to reorder :section', ['section' => $componentLabels[$component] ?? $component]) }}">
                    <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <circle cx="9" cy="6" r="1" fill="currentColor"/><circle cx="15" cy="6" r="1" fill="currentColor"/>
                        <circle cx="9" cy="12" r="1" fill="currentColor"/><circle cx="15" cy="12" r="1" fill="currentColor"/>
                        <circle cx="9" cy="18" r="1" fill="currentColor"/><circle cx="15" cy="18" r="1" fill="currentColor"/>
                    </svg>
                </button>
                <span class="min-w-0 flex-1">{{ $componentLabels[$component] ?? $component }}</span>
                <span class="order-number flex size-7 shrink-0 items-center justify-center rounded-full bg-gray-100 text-xs font-semibold text-gray-500 dark:bg-neutral-800 dark:text-neutral-400">{{ $loop->iteration }}</span>
            </li>
        @endforeach
        </ul>
    </div>

    <div class="mt-4 flex flex-wrap items-center gap-3">
        <button id="save-order" type="button" disabled
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 dark:focus:ring-offset-neutral-950">
            <svg id="save-spinner" class="hidden size-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"/></svg>
            <span id="save-label">{{ __('Save order') }}</span>
        </button>
        <p id="order-message" class="hidden text-sm font-medium" role="status" aria-live="polite"></p>
    </div>
</div>

@vite('resources/js/presentation-order.js')
