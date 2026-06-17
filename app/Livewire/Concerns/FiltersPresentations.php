<?php

namespace App\Livewire\Concerns;

use App\Services\VideoSearch\VideoFilters;
use App\Services\VideoSearch\VideoSearchService;
use App\Support\VideoFiltersFromRequest;
use Livewire\Attributes\On;

trait FiltersPresentations
{
    private const FILTER_SELECTIONS = [
        'course' => 'selectedCourses',
        'presenter' => 'selectedPresenters',
        'semester' => 'selectedSemesters',
        'tag' => 'selectedTags',
    ];

    protected function initializePresentationFilters($videos, VideoSearchService $service): void
    {
        $filters = VideoFiltersFromRequest::make();
        $this->syncSelectedFilters($filters);
        $this->applyPresentationFilters($videos, $filters, $service);
    }

    #[On('recompute')]
    public function handleRecompute(string $prop): void
    {
        if (!array_key_exists($prop, self::FILTER_SELECTIONS)) {
            return;
        }

        $this->{$prop} = null;
        $this->{self::FILTER_SELECTIONS[$prop]} = [];
        $this->recompute();
    }

    public function updatedSelectedCourses($values): void
    {
        $this->setFilterSelection('course', $values);
    }

    public function updatedSelectedPresenters($values): void
    {
        $this->setFilterSelection('presenter', $values);
    }

    public function updatedSelectedSemesters($values): void
    {
        $this->setFilterSelection('semester', $values);
    }

    public function updatedSelectedTags($values): void
    {
        $this->setFilterSelection('tag', $values);
    }

    protected function recompute(): void
    {
        /** @var VideoSearchService $service */
        $service = app(VideoSearchService::class);

        $this->applyPresentationFilters(
            $this->allVideos,
            new VideoFilters(
                $this->normalizedFilterValues($this->selectedCourses),
                $this->normalizedFilterValues($this->selectedSemesters),
                $this->normalizedFilterValues($this->selectedTags),
                $this->normalizedFilterValues($this->selectedPresenters),
            ),
            $service,
        );
    }

    private function setFilterSelection(string $prop, mixed $values): void
    {
        $selected = $this->normalizedFilterValues($values) ?? [];

        $this->{self::FILTER_SELECTIONS[$prop]} = $selected;
        $this->{$prop} = $selected;

        $this->recompute();
    }

    private function syncSelectedFilters(VideoFilters $filters): void
    {
        $this->selectedCourses = $this->normalizedFilterValues($filters->courses) ?? [];
        $this->selectedSemesters = $this->normalizedFilterValues($filters->terms) ?? [];
        $this->selectedTags = $this->normalizedFilterValues($filters->tags) ?? [];
        $this->selectedPresenters = $this->normalizedFilterValues($filters->presenters) ?? [];

        $this->course = $this->selectedCourses;
        $this->semester = $this->selectedSemesters;
        $this->tag = $this->selectedTags;
        $this->presenter = $this->selectedPresenters;
    }

    private function applyPresentationFilters($videos, VideoFilters $filters, VideoSearchService $service): void
    {
        [
            $this->courses,
            $this->terms,
            $this->presenters,
            $this->tags,
            $this->videos,
        ] = $service->performFiltering($videos, $filters);
    }

    private function normalizedFilterValues(mixed $values): ?array
    {
        if ($values === null || $values === '' || $values === []) {
            return null;
        }

        $items = is_array($values) ? $values : explode(',', (string) $values);

        $items = array_values(array_unique(array_filter(
            array_map(static fn ($value) => trim((string) $value), $items),
            static fn ($value) => $value !== '',
        )));

        return $items ?: null;
    }
}
