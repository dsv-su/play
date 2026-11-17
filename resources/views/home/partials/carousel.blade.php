<section class="presentation-carousel js-carousel"
         data-hs-carousel='{"loadingClasses":"opacity-0","slidesQty":{"xs":1,"sm":2,"md":3,"lg":4},"isDraggable":true}'>
    <div class="presentation-carousel-heading">
        <h2>
            @if($libraryUrl ?? null)
                <a href="{{ $libraryUrl }}"><span class="presentation-carousel-link-label">{{ $heading }}</span><span class="whitespace-nowrap"><span class="presentation-carousel-count">{{ $totalCount }}</span><span class="presentation-carousel-link-icon"><span>{{ __('View all') }}</span><span aria-hidden="true">↗</span></span></span></a>
            @else
                {{ $heading }}
            @endif
        </h2>
        <div class="presentation-carousel-controls">
            <button type="button" class="hs-carousel-prev presentation-carousel-arrow hs-carousel-disabled:opacity-40 hs-carousel-disabled:cursor-default" aria-label="{{ __('Previous') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
            </button>
            <button type="button" class="hs-carousel-next presentation-carousel-arrow hs-carousel-disabled:opacity-40 hs-carousel-disabled:cursor-default" aria-label="{{ __('Next') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
            </button>
        </div>
    </div>
    <div class="hs-carousel presentation-carousel-viewport">
        <div class="hs-carousel-body relative flex flex-nowrap opacity-0 transition-transform duration-700 hs-carousel-dragging:transition-none hs-carousel-dragging:cursor-grabbing" style="touch-action: pan-y;">
            @foreach($videos as $video)
                <div class="hs-carousel-slide presentation-carousel-slide">
                    @include('home.partials.presentation')
                </div>
            @endforeach
        </div>
    </div>
</section>
