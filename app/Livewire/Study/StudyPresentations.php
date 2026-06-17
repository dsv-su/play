<?php

namespace App\Livewire\Study;

use App\Livewire\Concerns\DSVCourseNames;
use App\Livewire\Concerns\FiltersPresentations;
use App\Models\Video;
use App\Services\Filters\VisibilityFilter;
use App\Services\VideoSearch\VideoSearchService;
use Livewire\Component;

class StudyPresentations extends Component
{
    use DSVCourseNames;
    use FiltersPresentations;
    //Filters
    public array $courses = [];
    public array $terms = [];
    public array $presenters = [];
    public array $tags = [];
    public $course, $presenter, $semester, $tag;
    public array $selectedCourses = [];
    public array $selectedPresenters = [];
    public array $selectedSemesters = [];
    public array $selectedTags = [];
    public array $activeFilters = ['courses' => true, 'presenters' => true, 'semesters' => true, 'tags' => true];
    public array $selectedVideos = [];
    //Switch
    public bool $switchOn = false;
    public $allowBulkEdit = false;
    public $videos, $allVideos;
    public int $totalCount = 0;
    public $studyvideos;

    public function mount(VisibilityFilter $visibility, VideoSearchService $service)
    {
        $raw = Video::query()
            ->select(['id', 'title', 'creation', 'duration', 'visibility', 'state', 'thumb', 'category_id', 'subtitles', 'description'])
            ->where('visibility', true)
            ->where('state', true)
            ->where('category_id', 2)
            ->latest('creation')
            ->with([
                'video_course:id,video_id,course_id',
                'video_course.course:id,name,designation'
            ])
            ->get();

        //Filter
        $videos = $this->allVideos = $this->studyvideos = $visibility->filter($raw);

        $this->totalCount = $videos->count();

        $this->initializePresentationFilters($videos, $service);
    }

    public function render()
    {
        return view('livewire.study.study-presentations');
    }
}
