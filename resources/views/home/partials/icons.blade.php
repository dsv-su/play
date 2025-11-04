<div class="relative">

    <!-- Fade overlay for unlisted-->
    @if($video->hidden && $video->unlisted)
        <div class="absolute inset-0 bg-black bg-opacity-50 z-30"></div>

        <!-- Centered Unlisted Alert -->
        <div class="absolute inset-0 flex items-center justify-center z-30 -translate-y-16">
            <div class="bg-gray-50 border border-gray-200 text-sm text-gray-600 rounded py-2 px-8 dark:bg-white/10 dark:border-white/10 dark:text-white">
                <span class="font-medium">{{ __("Unlisted") }}</span>
            </div>
        </div>
    @endif
    <!-- Fade overlay for Private-->
    @if($video->hidden && !$video->unlisted)
        <div class="absolute inset-0 bg-black bg-opacity-50 z-30"></div>
        <!-- Centered Private Alert -->
        <div class="absolute inset-0 flex items-center justify-center z-30 -translate-y-16">
            <div class="bg-gray-50 border border-gray-200 text-sm text-gray-900 rounded py-2 px-8 dark:bg-white/20 dark:border-white/20 dark:text-white">
                <span class="font-medium">{{ __("Private") }}</span>
            </div>
        </div>
    @endif

    <!-- Fade overlay for Pending-->
    @if(!$video->state)
        <div class="absolute inset-0 bg-black/60 dark:bg-black/70 backdrop-blur-sm z-30"></div>

        <!-- Centered Pending Alert -->
        <div class="absolute inset-0 flex items-center justify-center z-30 -translate-y-16">
            <div class="rounded px-8 py-2 text-sm font-medium border
                   bg-white/80 text-gray-900 border-gray-200
                   dark:bg-white/50 dark:text-gray-100 dark:border-white/20
                   backdrop-blur-md shadow-sm">
                {{ __("Processing") }}
            </div>
        </div>
    @endif

    <div class="absolute bottom-0 left-0 z-20 flex items-center bg-gray-800 border border-gray-800 rounded gap-0.5">
        @include('home.partials.permission-buttons')
    </div>
</div>


