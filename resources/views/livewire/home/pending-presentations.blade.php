<div>
    <div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 md:pt-8 md:pb-8 space-y-8">
        <div class="px-4 py-2">
            <!-- Left-aligned heading -->
            <h2 class="text-blue-700 text-xl font-light tracking-wide uppercase whitespace-nowrap drop-shadow-md dark:text-white">
                {{__("Pending presentations")}}
            </h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
            @foreach($pendingvideos as $video)
                <div class="flex justify-center items-center aspect-video">
                    @include('pending.partials.pending')
                </div>
            @endforeach
        </div>
    </div>
    <!-- Tooltips -->
    @include('home.partials.tooltips')

</div>
