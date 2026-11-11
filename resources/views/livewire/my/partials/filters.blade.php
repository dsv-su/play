@php
    $filterGroups = [
        'courses' => [__('Courses'), 'selectedCourses', 'course', $courses],
        'presenters' => [__('Presenters'), 'selectedPresenters', 'presenter', $presenters],
        'semesters' => [__('Semesters'), 'selectedSemesters', 'semester', array_combine($terms, $terms)],
        'tags' => [__('Tags'), 'selectedTags', 'tag', array_combine($tags, $tags)],
    ];
@endphp
<div class="library-filters">
    @foreach($filterGroups as $filter => [$label, $property, $event, $options])
        @if($activeFilters[$filter] ?? false)
            <details class="library-filter" wire:key="library-filter-{{ $filter }}">
                <summary>{{ $label }} <span class="library-count">{{ count($$property) }}<span class="sr-only"> {{ __('selected') }}</span></span></summary>
                <div class="library-filter-body" x-data="{ query: '' }">
                    <label class="library-filter-search">
                        <span>{{ __('Search :filter', ['filter' => $label]) }}</span>
                        <input type="search" x-model="query" autocomplete="off" placeholder="{{ __('Type to filter…') }}">
                    </label>
                    <fieldset>
                        <legend class="sr-only">{{ $label }}</legend>
                        @foreach($options as $value => $name)
                            <label class="library-option" wire:key="library-option-{{ $filter }}-{{ md5((string) $value) }}"
                                   x-show="!query || $el.textContent.toLocaleLowerCase().includes(query.toLocaleLowerCase())">
                                <input type="checkbox" wire:model.live="{{ $property }}" value="{{ $value }}">
                                <span>{{ $filter === 'courses' && $value !== 'nocourse' ? $value.' · '.$name : $name }}</span>
                            </label>
                        @endforeach
                    </fieldset>
                    @if(empty($options))<p>{{ __('No options available') }}</p>@endif
                    <button class="library-button" type="button" wire:click="handleRecompute(@js($event))">{{ __('Clear :filter', ['filter' => $label]) }}</button>
                </div>
            </details>
        @endif
    @endforeach
</div>
