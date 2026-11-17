<article data-presentation-card class="presentation-card">
    <div class="presentation-card-media">
        <a target="_blank" rel="noopener noreferrer" href="{{ route('player.show', ['video' => $video]) }}"
           class="presentation-card-play hs-carousel-dragging:pointer-events-none"
           aria-label="{{ __('Open :title in a new tab', ['title' => $video->LangTitle]) }}"></a>
        @include('home.partials.img')
        @include('home.partials.duration')
        @include('home.partials.topbadge')
        @include('home.partials.icons')
    </div>

    <div class="presentation-card-body">
        <div class="presentation-card-heading">
            @include('home.partials.title')
            <div class="presentation-card-share">
                @include('livewire.search.partials.share-modal')
            </div>
        </div>
        <div class="presentation-card-metadata">
            @include('home.partials.presenters')
            @include('home.partials.studyadmin')
            @include('home.partials.courses')
        </div>
        @include('home.partials.description')
    </div>
    <div class="presentation-card-footer">
        @include('home.partials.stats')
        @include('home.partials.edit')
    </div>
    @include('partials.download-poller-script')
</article>
