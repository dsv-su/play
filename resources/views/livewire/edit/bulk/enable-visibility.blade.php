<div class="relative -mt-4 mb-4 w-1/2 ml-auto">
    <!-- Top-right row -->
    <div class="absolute top-2 right-2 flex items-center gap-2">
        <!-- Right-side label (now first, on the left) -->
        @if($bulkvisibility)
            <span class="px-1.5 py-0 text-xs font-medium text-white bg-suprimary border border-suprimary rounded shadow-md">
                {{ __("Overwrite") }}
            </span>
        @else
            <span class="px-1.5 py-0 text-xs font-medium text-white bg-gray-400 border border-gray-400 rounded shadow-md">
                {{ __("Keep existing settings") }}
            </span>
    @endif

    <!-- Switch (now second, on the right) -->
        <label for="hs-xs-switch-bulkvisibility"
               class="relative inline-flex items-center cursor-pointer">
            <input
                type="checkbox"
                id="hs-xs-switch-bulkvisibility"
                class="peer sr-only"
                name="bulkvisibility"
                wire:model.live="bulkvisibility"
            >

            <!-- Track -->
            <span class="w-8 h-4 bg-gray-200 rounded-full transition-colors
                   peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500"></span>

            <!-- Thumb -->
            <span class="absolute left-0.5 top-1/2 -translate-y-1/2
                   w-3 h-3 bg-white rounded-full shadow transition-transform
                   peer-checked:translate-x-4 dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
        </label>
    </div>

    <input type="hidden" name="bulkvisibility" value="{{ $bulkvisibility }}">
</div>

