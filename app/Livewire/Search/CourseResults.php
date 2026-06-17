<?php

namespace App\Livewire\Search;

use App\Livewire\Concerns\DSVCourseNames;
use App\Livewire\Concerns\FiltersPresentations;
use App\Services\VideoSearch\VideoSearchService;
use Illuminate\Support\Collection as SupportCollection;
use Livewire\Component;

class CourseResults extends Component
{
    use DSVCourseNames;
    use FiltersPresentations;

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

        $this->initializePresentationFilters($videos, $service);
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

    public function render()
    {
        return view('livewire.search.course-results');
    }
}
