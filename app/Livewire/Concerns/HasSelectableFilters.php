<?php
declare(strict_types=1);
namespace App\Livewire\Concerns;

use App\Support\VideoFilters;
use Illuminate\Support\Collection;

trait HasSelectableFilters
{
    public VideoFilters $filters;

    public $videos;
    /** Persisted across requests (Livewire-safe) */
    #[\Livewire\Attributes\Locked] // optional: prevents client tampering
    public $allVideos;

    public int $totalCount = 0;

    /** Buckets for UI */
    public array $courses = [];
    public array $terms = [];
    public array $presenters = [];
    public array $tags = [];

    /** “Select all” */
    public array $selectedVideos = [];

    //protected Collection $allVideos;

    /** Map “selectedFoo” props to filter keys */
    protected array $selectedMap = [
        'selectedCourses'    => 'courses',
        'selectedPresenters' => 'presenters',
        'selectedSemesters'  => 'semesters',
        'selectedTags'       => 'tags',
    ];

    /** Children can override if they need a different source */
    protected function sourceVideos(): Collection
    {
        return $this->allVideos ?? collect();
    }

    /** Todo; Use only used attributes */
    protected function seedAllVideos(Collection $videos): void
    {
        $this->allVideos = $videos;
        /*$this->allVideos = $videos->values()->map(fn ($v) => [
            'id'        => $v->id,
            'title'     => $v->title ?? null,
            'creation'  => $v->creation ?? null,
            'duration'  => $v->duration ?? null,
            'thumbnail' => $v->thumbnail_url ?? null,
            // only what you actually need in Blade
        ]);*/
    }


    protected function buildFiltersFromState(): VideoFilters
    {
        // Legacy `$this->course`, `$this->semester`, etc. merge here.
        return $this->filters ??= VideoFilters::from();
    }

    protected function applyFilters(): void
    {
        /** @var \App\Services\VideoSearch\VideoSearchService $service */
        $service = app(\App\Services\VideoSearch\VideoSearchService::class);

        $filtersArray = \App\Support\VideoFiltersFromRequest::make(
            $this->buildFiltersFromState()->toSearchArray()
        );

        [$courses, $terms, $presenters, $tags, $grouped] =
            $service->performFiltering($this->sourceVideos(), $filtersArray);

        // Buckets are arrays already:
        $this->courses    = $courses;
        $this->terms      = $terms;
        $this->presenters = $presenters;
        $this->tags       = $tags;

        // Convert grouped: Collection<int|string, Collection<Model>> -> array<int|string, array<array>>
        //$this->videos = $this->normalizeGrouped($grouped);
        $this->videos = $grouped;

    }

    /** @return array */
    protected function normalizeGrouped(Collection $grouped): array
    {
        // Todo: map each model into a lightweight DTO for Livewire hydration safety
        return $grouped->map(function (Collection $g) {
            return $g->values()->map(function ($v) {
                return [
                    'id'        => $v->id,
                    'title'     => $v->title ?? null,
                    'creation'  => $v->creation ?? null,
                    'duration'  => $v->duration ?? null,
                    'thumbnail' => $v->thumbnail_url ?? null,
                    // add only the fields used in Blade
                ];
            })->all();
        })->toArray();
    }
    /** Single updated handler for all selected* arrays */
    public function updated($name, $value): void
    {
        if (str_starts_with($name, 'filters.selected.')) {
            $this->recompute();
            return;
        }

        // Legacy bindings fallback (selectedSemesters, selectedCourses, ...)
        if (isset($this->selectedMap[$name])) {
            $key = $this->selectedMap[$name];
            $this->filters->selected[$key] = is_array($value) ? $value : explode(',', (string) $value);
            $this->recompute();
        }
    }

    public function recompute(): void
    {
        $this->applyFilters();
        $this->recomputeComputedFields();
    }

    /** let children compute extra derived data like titles */
    protected function recomputeComputedFields(): void {}
}
