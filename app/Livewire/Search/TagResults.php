<?php

namespace App\Livewire\Search;

use App\Livewire\Concerns\DSVCourseNames;
use App\Livewire\Concerns\FiltersPresentations;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection as SupportCollection;
use App\Services\VideoSearch\VideoSearchService;

class TagResults extends Component
{
    use DSVCourseNames;
    use FiltersPresentations {
        recompute as protected recomputeFilters;
    }
    use WithPagination;

    #[Url(as: 'open', history: true)]
    public ?string $activeAccordion = null;

    public SupportCollection $videos;
    public SupportCollection $allVideos;

    public array $courses = [];
    public array $terms = [];
    public array $presenters = [];
    public array $tags = [];
    public $tag;
    public string $tagName = '';
    public $course, $presenter, $semester;
    public array $selectedCourses = [];
    public array $selectedPresenters = [];
    public array $selectedSemesters = [];
    public array $selectedTags = [];
    public bool $switchOn = false;
    public array $activeFilters = ['courses' => true, 'presenters' => true, 'semesters' => true, 'tags' => false];
    public array $selectedVideos = [];
    public $allowBulkEdit = false;
    public int $totalCount = 0;

    public function mount(SupportCollection $videos, $tag, VideoSearchService $service): void
    {
        $this->tagName = (string) $tag;
        $this->allVideos = $videos;

        $this->selectedTags = [$tag];
        $this->initializePresentationFilters($videos, $service);
        $this->selectedTags = [$tag];
        $this->tag = [$tag];
        $this->totalCount = $videos->count();
    }

    public function toggleSelectAll($videos)
    {
        // Convert JSON into an array of IDs
        $allIds = collect($videos)->pluck('id')->toArray();

        if ($this->selectedVideos == $allIds) {
            $this->selectedVideos = []; // Deselect all
        } else {
            $this->selectedVideos = $allIds; // Select all
        }
    }

    public function updatedActiveAccordion(): void
    {
        $this->resetPage('tagPage');
    }

    protected function recompute(): void
    {
        $this->resetPage('tagPage');
        $this->recomputeFilters();
    }

    public function render()
    {
        $courseId = str_starts_with($this->activeAccordion ?? '', 'course-')
            ? substr($this->activeAccordion, strlen('course-'))
            : null;
        $group = $courseId !== null ? $this->videos->get($courseId, collect()) : collect();
        $perPage = 20;
        $page = min(max(1, $this->getPage('tagPage')), max(1, (int) ceil($group->count() / $perPage)));
        $this->paginators['tagPage'] = $page;
        $courseVideos = new LengthAwarePaginator(
            $group->forPage($page, $perPage)->values(),
            $group->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'pageName' => 'tagPage'],
        );

        return view('livewire.search.tag-results', compact('courseVideos'));
    }

}
