<?php

namespace App\Livewire\My;

use App\Services\MyPresentation\PresentationLibrary;
use App\Services\VideoSearch\VideoFilters;
use App\Support\VideoFiltersFromRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UserPresentations extends Component
{
    use WithPagination;

    #[Url(as: 'open', history: true)]
    public ?string $activeAccordion = null;

    public array $selectedCourses = [];

    public array $selectedPresenters = [];

    public array $selectedSemesters = [];

    public array $selectedTags = [];

    public bool $switchOn = false;

    public array $activeFilters = ['courses' => true, 'presenters' => true, 'semesters' => true, 'tags' => true];

    public bool $allowBulkEdit = true;

    protected ?array $libraryState = null;

    private const FILTER_SELECTIONS = [
        'course' => 'selectedCourses',
        'presenter' => 'selectedPresenters',
        'semester' => 'selectedSemesters',
        'tag' => 'selectedTags',
    ];

    public function mount(): void
    {
        $filters = VideoFiltersFromRequest::make();
        $this->selectedCourses = $filters->courses ?? [];
        $this->selectedPresenters = $filters->presenters ?? [];
        $this->selectedSemesters = $filters->terms ?? [];
        $this->selectedTags = $filters->tags ?? [];
    }

    public function toggleCourse(string $id): void
    {
        if (! str_starts_with($id, 'course-')) {
            return;
        }
        // Every read is scoped to the current user, including client-supplied IDs.
        [, , $summary] = $this->libraryState();
        $counts = $summary['counts'];
        if (! $counts->has(substr($id, 7))) {
            return;
        }
        $this->activeAccordion = $this->activeAccordion === $id ? null : $id;
        $this->resetPage('presentationsPage');
    }

    public function clearFilters(): void
    {
        $this->libraryState = null;
        $this->selectedCourses = $this->selectedPresenters = $this->selectedSemesters = $this->selectedTags = [];
        $this->resetPage('presentationsPage');
    }

    #[On('recompute')]
    public function handleRecompute(string $prop): void
    {
        if (isset(self::FILTER_SELECTIONS[$prop])) {
            $this->libraryState = null;
            $this->{self::FILTER_SELECTIONS[$prop]} = [];
            $this->resetPage('presentationsPage');
        }
    }

    public function updated(string $name): void
    {
        $this->libraryState = null;
        if ($name === 'activeAccordion' || in_array(explode('.', $name)[0], self::FILTER_SELECTIONS, true)) {
            $this->resetPage('presentationsPage');
        }
    }

    private function filters(): VideoFilters
    {
        return new VideoFilters($this->selectedCourses, $this->selectedSemesters, $this->selectedTags, $this->selectedPresenters);
    }

    protected function libraryState(): array
    {
        if ($this->libraryState === null) {
            $library = app(PresentationLibrary::class);
            $query = $library->query($this->filters());
            $this->libraryState = [$library, $query, $library->summary($query)];
        }

        return $this->libraryState;
    }

    public function render()
    {
        [$library, $query, $summary] = $this->libraryState();
        $courseId = str_starts_with($this->activeAccordion ?? '', 'course-') ? substr($this->activeAccordion, 7) : null;
        $courseVideos = new LengthAwarePaginator([], 0, 20, 1, [
            'path' => request()->url(), 'pageName' => 'presentationsPage',
        ]);
        if ($courseId !== null && $summary['counts']->has($courseId)) {
            $courseVideos = $library->page(
                $query, $courseId, $this->getPage('presentationsPage'), total: $summary['counts']->get($courseId),
            );
        }
        $this->paginators['presentationsPage'] = $courseVideos->currentPage();

        return view('livewire.my.my-presentations', [
            'courseCounts' => $summary['counts'], 'titles' => $summary['titles'],
            'courses' => $summary['courses'], 'terms' => $summary['terms'],
            'tags' => $summary['tags'], 'presenters' => $summary['presenters'],
            'totalCount' => $summary['total'], 'courseVideos' => $courseVideos,
        ]);
    }
}
