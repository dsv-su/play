<div wire:poll.15s.visible>
    <section class="pending-library" aria-labelledby="pending-presentations-heading">
        <header class="pending-library-heading">
            <h1 id="pending-presentations-heading">{{ __('Pending presentations') }}</h1>
            <span class="presentation-carousel-count">{{ $count_pending }}</span>
        </header>
        @if($count_pending)
            <div class="pending-library-grid">
                @foreach($pendingvideos as $video)
                    <div class="pending-library-item" wire:key="pending-video-{{ $video->id }}">
                        @include('pending.partials.pending')
                    </div>
                @endforeach
            </div>
        @else
            <div class="presentation-card pending-library-empty" role="status">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/></svg>
                <h2>{{ __('The processing queue is currently empty.') }}</h2>
                <p>{{ __('There are no presentations being processed.') }}</p>
            </div>
        @endif
    </section>
    @include('home.partials.tooltips')
</div>
