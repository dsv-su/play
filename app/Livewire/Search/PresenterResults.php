<?php

namespace App\Livewire\Search;

use App\Livewire\Concerns\DSVCourseNames;
use App\Livewire\Concerns\DSVPresenters;
use App\Livewire\Concerns\FiltersPresentations;
use App\Services\VideoSearch\VideoSearchService;
use Illuminate\Support\Collection as SupportCollection;
use Livewire\Component;

class PresenterResults extends Component
{
    use DSVCourseNames, DSVPresenters;
    use FiltersPresentations;

    public SupportCollection $videos;
    public SupportCollection $allVideos;

    public array $courses = [];
    public array $terms = [];
    public array $presenters = [];
    public array $tags = [];
    public $presenter_search;
    public $course, $presenter, $semester, $tag;
    public array $selectedCourses = [];
    public array $selectedPresenters = [];
    public array $selectedSemesters = [];
    public array $selectedTags = [];
    public bool $switchOn = false;
    public array $activeFilters = ['courses' => true, 'presenters' => false, 'semesters' => true, 'tags' => true];
    public array $selectedVideos = [];
    public $allowBulkEdit = false;
    public int $totalCount = 0;

    public function mount(SupportCollection $videos, $presenter_search, VideoSearchService $service): void
    {
        $this->presenter_search = $presenter_search;
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
        return view('livewire.search.presenter-results');
    }
}
