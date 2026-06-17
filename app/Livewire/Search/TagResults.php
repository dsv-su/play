<?php

namespace App\Livewire\Search;

use App\Livewire\Concerns\DSVCourseNames;
use App\Livewire\Concerns\FiltersPresentations;
use Livewire\Component;
use Illuminate\Support\Collection as SupportCollection;
use App\Services\VideoSearch\VideoSearchService;

class TagResults extends Component
{
    use DSVCourseNames;
    use FiltersPresentations;

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

    public function render()
    {
        return view('livewire.search.tag-results');
    }

}
