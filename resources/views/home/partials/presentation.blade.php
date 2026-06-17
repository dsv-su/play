<div class="relative flex flex-col bg-gray-50 border border-gray-200 w-full min-w-0
            max-h-[18rem] overflow-hidden overflow-x-clip
            shadow-2xs rounded-sm hover:shadow-sm transition
            dark:bg-gray-800 {{--}}dark:border-neutral-700{{--}}dark:border-white dark:shadow-neutral-700/70">

    <!-- Image wrapper with relative positioning -->
    <div class="relative">

        <a target="_blank" rel="noopener noreferrer" href="{{ route('player.show', ['video' => $video]) }}"
           class="absolute inset-0 z-10 hs-carousel-dragging:pointer-events-none"
           aria-label="{{ __('Open :title in a new tab', ['title' => $video->LangTitle]) }}"></a>
        @include('home.partials.img')
        @include('home.partials.duration')
        @include('home.partials.topbadge')
        @include('home.partials.icons')
    </div>

    <!-- Card Body -->
    <div class="p-2 md:p-3 relative min-w-0 overflow-x-clip pointer-events-none">
        <div class="flex items-center flex-wrap gap-1 min-w-0">
            @include('home.partials.title')
            @include('home.partials.presenters')
            {{--}}<div class="ml-auto">{{--}}
            <div class="absolute top-2 right-2 pointer-events-auto">
                <!-- Share modal -->
                @include('livewire.search.partials.share-modal')
            </div>
        </div>
        @include('home.partials.studyadmin')
        @include('home.partials.courses')
        @include('home.partials.description')
    </div>
    @include('home.partials.stats')
    @include('home.partials.edit')
    @include('partials.download-poller-script')
</div>
