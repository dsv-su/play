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
            <div class="relative w-1/2 rounded-lg border border-transparent bg-blue-50 p-4 [&>svg]:absolute [&>svg]:text-foreground [&>svg]:left-4 [&>svg]:top-4 [&>svg+div]:translate-y-[-3px] [&:has(svg)]:pl-11 text-blue-600">
                <svg class="w-5 h-5 -translate-y-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                <h5 class="mb-1 font-medium leading-none tracking-tight">{{__("The processing queue is currently empty.")}}</h5>
                <div class="text-sm opacity-80">{{__("There are no presentations being processed.")}}</div>
            </div>
        @endif
    </div>
    <!-- Tooltips -->
    @include('home.partials.tooltips')

</div>
