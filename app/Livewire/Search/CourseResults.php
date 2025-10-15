<?php

namespace App\Livewire\Search;

use App\Livewire\Concerns\DSVCourseNames;
use App\Services\VideoSearch\VideoSearchService;
use App\Support\VideoFiltersFromRequest;
use Illuminate\Support\Collection as SupportCollection;
use Livewire\Attributes\On;
use Livewire\Component;

class CourseResults extends Component
{
    use DSVCourseNames;

    public SupportCollection $videos;
    public SupportCollection $allVideos;

    public array $courses = [];
    public array $terms = [];
    public array $presenters = [];
    public array $tags = [];
    public $designation;
    public $course, $presenter, $semester, $tag;
    public array $selectedCourses = [];
    public array $selectedPresenters = [];
    public array $selectedSemesters = [];
    public array $selectedTags = [];
    public bool $switchOn = false;
    public array $activeFilters = ['courses' => true, 'presenters' => true, 'semesters' => true, 'tags' => true];
    public array $selectedVideos = [];
    public $allowBulkEdit = false;
    public int $totalCount = 0;

    public function mount(SupportCollection $videos, $designation, VideoSearchService $service): void
    {
        $this->designation = $designation;
        $this->allVideos = $videos;

        $filters = VideoFiltersFromRequest::make();

        [
            $this->courses,
            $this->terms,
            $this->presenters,
            $this->tags,
            $this->videos,
        ] = $service->performFiltering($videos, $filters);
        $this->totalCount = $this->videos->count();
        $this->recompute();
    }

    #[On('recompute')]
    public function handleRecompute(string $prop): void
    {
        // only allow known properties for safety
        if (!in_array($prop, ['course', 'presenter', 'semester', 'tag'], true)) {
            return;
        }

        $this->{$prop} = null;
        $this->recompute();
    }

    public function updatedSelectedCourses($values){ $this->course = $values; $this->recompute(); }
    public function updatedSelectedPresenters($values){ $this->presenter = $values; $this->recompute(); }
    public function updatedSelectedSemesters($values){ $this->semester = $values; $this->recompute(); }
    public function updatedSelectedTags($values){ $this->tag = $values; $this->recompute(); }

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

    public function updatedSelectedVideos()
    {
        // This method gets triggered whenever a checkbox changes
        dd($this->selectedVideos);
    }

    public function bulkedit()
    {
        dd($this->selectedVideos);
    }

    protected function recompute(): void
    {
        $filters = VideoFiltersFromRequest::make([
            'course' => $this->course ? explode(',', $this->course) : null,
            'semester' => $this->semester ? explode(',', $this->semester) : null,
            'tag' => $this->tag ? explode(',', $this->tag) : null,
            'presenter' => $this->presenter ? explode(',', $this->presenter) : null,
        ]);

        $service = app(VideoSearchService::class);

        [
            $this->courses,
            $this->terms,
            $this->presenters,
            $this->tags,
            $this->videos,
        ] = $service->performFiltering($this->allVideos, $filters);
        $this->totalCount = $this->videos->count();
    }

    public function render()
    {
        return view('livewire.search.course-results');
    }
}
