<div class="relative">

    <!-- Fade overlay for unlisted-->
    @if($video->unlisted)
        <div class="absolute inset-0 bg-black bg-opacity-50 z-20"></div>

        <!-- Centered Unlisted Alert -->
        <div class="absolute inset-0 flex items-center justify-center z-20">
            <div class="bg-gray-50 border border-gray-200 text-sm text-gray-600 rounded py-2 px-8 dark:bg-white/10 dark:border-white/10 dark:text-white">
                <span class="font-normal">{{ __("Unlisted") }}</span>
            </div>
        </div>
    @endif

    <div class="absolute bottom-0 left-0 z-20 flex items-center bg-gray-800 border border-gray-800 rounded gap-0.5">
        @include('home.partials.permission-buttons')
    </div>
</div>


