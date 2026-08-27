<div>
    @if($channelVideos->isNotEmpty())
        <div data-hs-carousel='{"loadingClasses":"opacity-0","slidesQty":{"xs":1,"sm":2,"md":3,"lg":4},"isDraggable":true}' class="relative js-carousel">
            <div class="px-4 py-2"><a href="{{ route('channels.show', $channel) }}" class="group inline-flex items-center text-xl font-light uppercase tracking-wide text-blue-700 dark:text-white"><svg class="mr-2 size-6 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8.5 7.5a6 6 0 0 0 0 9"/><path d="M5.5 4.5a10 10 0 0 0 0 15"/><path d="M15.5 7.5a6 6 0 0 1 0 9"/><path d="M18.5 4.5a10 10 0 0 1 0 15"/><circle cx="12" cy="12" r="2" fill="currentColor" stroke="none"/></svg><span>{{ $channel->name }} ({{ $totalCount }})</span><span aria-hidden="true" class="ml-2 transition-transform group-hover:translate-x-1">→</span></a></div>
            <div class="hs-carousel w-full overflow-hidden rounded-lg bg-transparent"><div class="relative min-h-72"><div class="hs-carousel-body absolute inset-y-0 start-0 flex flex-nowrap opacity-0 transition-transform duration-700 hs-carousel-dragging:transition-none">
                @foreach($channelVideos as $video)<div class="hs-carousel-slide px-0.5"><div class="flex h-full justify-center">@include('home.partials.presentation')</div></div>@endforeach
            </div></div></div>
            <button type="button" class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:cursor-default absolute top-1/2 start-2 inline-flex justify-center items-center size-10 bg-white border border-gray-100 text-gray-800 rounded-full shadow-2xs hover:bg-gray-100 -translate-y-1/2 focus:outline-hidden">
                <span class="text-2xl" aria-hidden="true">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"></path></svg>
                </span>
                <span class="sr-only">{{ __('Previous') }}</span>
            </button>
            <button type="button" class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:cursor-default absolute top-1/2 end-2 inline-flex justify-center items-center size-10 bg-white border border-gray-100 text-gray-800 rounded-full shadow-2xs hover:bg-gray-100 -translate-y-1/2 focus:outline-hidden">
                <span class="sr-only">{{ __('Next') }}</span>
                <span class="text-2xl" aria-hidden="true">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"></path></svg>
                </span>
            </button>
        </div>
    @endif
</div>
