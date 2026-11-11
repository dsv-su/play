<?php

namespace App\Livewire\My;

use App\Livewire\Concerns\DSVCourseNames;
use App\Livewire\Concerns\FiltersPresentations;
use App\Services\Filters\VisibilityFilter;
use App\Services\MyPresentation\MyPresentationsService;
use App\Services\VideoSearch\VideoSearchService;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UserPresentations extends Component
{
    use DSVCourseNames;
    use FiltersPresentations {
        recompute as protected recomputeFilters;
    }
    use WithPagination;

    #[Url(as: 'open', history: true)]
    public ?string $activeAccordion = null;

    public array $courses = [];
    public array $terms = [];
    public array $presenters = [];
    public array $tags = [];
    public $course, $presenter, $semester, $tag;
    public array $selectedCourses = [];
    public array $selectedPresenters = [];
    public array $selectedSemesters = [];
    public array $selectedTags = [];
    public bool $switchOn = false;
    public $videos, $allVideos;
    public int $totalCount = 0;
    public array $activeFilters = ['courses' => true, 'presenters' => true, 'semesters' => true, 'tags' => true];
    public array $selectedVideos = [];
    public $allowBulkEdit = true;
    //Test
    public string $group = 'group1';

    public function mount(MyPresentationsService $my, VisibilityFilter $visibility, VideoSearchService $service)
    {
        $username = (string) app()->make('play_username');
        $authRole = (string) app()->make('play_auth');
        $playRole = (string) app()->make('play_role');

        $result = $my->getTopForUser($username, $authRole, $playRole, limit: 1000);

        $videos = $this->allVideos = $visibility->filter($result['videos']);

        $this->totalCount = $result['total'];

        $this->initializePresentationFilters($videos, $service);
    }

    public function toggleCourse(string $id): void
    {
        $courseId = str_starts_with($id, 'course-') ? substr($id, 7) : null;
        if ($courseId === null || !$this->videos->has($courseId)) {
            return;
        }

        $this->activeAccordion = $this->activeAccordion === $id ? null : $id;
        $this->resetPage('presentationsPage');
    }

    public function clearFilters(): void
    {
        $this->selectedCourses = $this->selectedPresenters = $this->selectedSemesters = $this->selectedTags = [];
        $this->course = $this->presenter = $this->semester = $this->tag = [];
        $this->recompute();
    }

    public function updatedActiveAccordion(): void
    {
        $this->resetPage('presentationsPage');
    }

    protected function recompute(): void
    {
        $this->resetPage('presentationsPage');
        $this->recomputeFilters();
    }

    public function render()
    {
        $courseId = str_starts_with($this->activeAccordion ?? '', 'course-')
            ? substr($this->activeAccordion, strlen('course-'))
            : null;
        $group = $courseId !== null ? $this->videos->get($courseId, collect()) : collect();
        $perPage = 20;
        $page = min(max(1, $this->getPage('presentationsPage')), max(1, (int) ceil($group->count() / $perPage)));
        $this->paginators['presentationsPage'] = $page;
        $courseVideos = new LengthAwarePaginator(
            $group->forPage($page, $perPage)->values(),
            $group->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'pageName' => 'presentationsPage'],
        );

        return view('livewire.my.my-presentations', compact('courseVideos'));
    }
}
