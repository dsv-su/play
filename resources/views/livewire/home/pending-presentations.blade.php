<div wire:poll.15s.visible>
    <div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 md:pt-8 md:pb-8 space-y-8">
        <div class="px-4 py-2">
            <!-- Left-aligned heading -->
            <h2 class="text-blue-700 text-xl font-light tracking-wide uppercase whitespace-nowrap drop-shadow-md dark:text-white">
                {{__("Pending presentations")}} ({{$count_pending}})
            </h2>
        </div>
        @if($count_pending)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
            @foreach($pendingvideos as $video)
                <div class="flex justify-center items-center aspect-video">
                    @include('pending.partials.pending')
                </div>
            @endforeach
        </div>
        @else
            <div class="max-w-md bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="pending queue">
                <div class="flex p-4">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4 text-blue-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                        </svg>
                    </div>
                    <div class="ms-3 text-blue-600">
                        <h5 class="mb-1 font-medium leading-none tracking-tight">
                            {{ __("The processing queue is currently empty.") }}
                        </h5>
                        <div class="text-sm opacity-80">
                            {{ __("There are no presentations being processed.") }}
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
    <!-- Tooltips -->
    @include('home.partials.tooltips')

</div>
