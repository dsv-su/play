<div class="presentation-library" aria-labelledby="library-title">
    @include('home.partials.flashmessage-section')

    <section class="library-search library-glass" aria-label="{{ __('Search') }}">
        <livewire:search.index />
    </section>

    <header class="library-heading">
        <h1 id="library-title">{{ $libraryTitle }}</h1>
        <a class="library-button" href="#library-courses">{{ __('Browse courses') }} <span aria-hidden="true">↓</span></a>
    </header>

    <section class="library-glass library-toolbar" aria-labelledby="library-filter-title">
        <div class="library-toolbar-heading">
            <div>
                <h2 id="library-filter-title">{{ __('Make it yours') }}</h2>
                <p>{{ __('Filter your library, then open a course to explore.') }}</p>
            </div>
            <div class="library-view-control" role="group" aria-label="{{ __('Presentation layout') }}">
                <button type="button" wire:click="$set('switchOn', false)" aria-pressed="{{ $switchOn ? 'false' : 'true' }}">{{ __('List') }}</button>
                <button type="button" wire:click="$set('switchOn', true)" aria-pressed="{{ $switchOn ? 'true' : 'false' }}">{{ __('Grid') }}</button>
            </div>
        </div>
        @include('livewire.partials.presentation-library.filters')
    </section>

    <section id="library-courses" class="library-courses" aria-labelledby="library-courses-title" tabindex="-1">
        <div class="library-section-heading">
            <h2 id="library-courses-title">{{ $coursesTitle }}</h2>
            <p role="status" aria-live="polite" aria-atomic="true">
                {{ trans_choice(':count presentation|:count presentations', $totalCount, ['count' => $totalCount]) }}
                <span aria-hidden="true"> · </span>
                {{ trans_choice(':count course|:count courses', $courseCounts->count(), ['count' => $courseCounts->count()]) }}
            </p>
        </div>
        <p class="library-loading" wire:loading.delay role="status">{{ __('Updating your library…') }}</p>

        @forelse($courseCounts as $courseId => $courseCount)
            @php($isOpen = $activeAccordion === 'course-'.$courseId)
            <section class="library-glass library-course" wire:key="library-course-{{ $courseId }}">
                <h3>
                    <button class="library-course-trigger" type="button"
                            id="trigger-course-{{ $courseId }}"
                            wire:click="toggleCourse(@js('course-'.$courseId))"
                            aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                            aria-controls="panel-course-{{ $courseId }}">
                        <span class="library-course-icon" aria-hidden="true">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v10H5a2 2 0 0 1-2-2Z"/></svg>
                        </span>
                        <span class="library-course-title">{{ strip_tags($titles[$courseId] ?? __('Presentations')) }}</span>
                        <span class="library-count">{{ $courseCount }}<span class="sr-only"> {{ __('Presentations') }}</span></span>
                        <svg class="library-chevron" aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 5 7 7-7 7"/></svg>
                    </button>
                </h3>
                <div id="panel-course-{{ $courseId }}" aria-labelledby="trigger-course-{{ $courseId }}" @if(!$isOpen) hidden @endif>
                    @if($isOpen)
                        <div class="library-course-content" wire:key="library-page-{{ $courseId }}-{{ $courseVideos->currentPage() }}-{{ (int) $switchOn }}">
                            @include('livewire.partials.presentation-library.presentations', ['group' => $courseVideos->getCollection()])
                            <div class="library-pagination">{{ $courseVideos->links(data: ['scrollTo' => false]) }}</div>
                        </div>
                    @endif
                </div>
            </section>
        @empty
            <div class="library-glass library-empty">
                <span aria-hidden="true">◎</span>
                <p>{{ __('No presentations match these filters. Clear a filter to see more of your library.') }}</p>
                <button type="button" class="library-button" wire:click="clearFilters">{{ __('Clear all filters') }}</button>
            </div>
        @endforelse
    </section>
    @include('home.partials.tooltips')
    @include('livewire.search.partials.tooltips')
</div>

@include('livewire.partials.presentation-library.filter-url')
