<?php

namespace App\Livewire\Nextilearn;

use App\Livewire\Concerns\DSVCourseNames;
use App\Models\Video;
use App\Services\Filters\VisibilityFilter;
use App\Services\VideoSearch\VideoSearchService;
use App\Support\VideoFiltersFromRequest;
use Livewire\Attributes\On;
use Livewire\Component;

class NextIlearnPresentations extends Component
{
    use DSVCourseNames;
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
    public $nextilearnvideos;

    public function mount(VisibilityFilter $visibility, VideoSearchService $service)
    {
        $raw = Video::query()
            ->select(['id', 'title', 'creation', 'duration', 'visibility', 'state', 'thumb', 'category_id', 'subtitles', 'description'])
            ->where('visibility', true)
            ->where('state', true)
            ->where('category_id', 8)
            ->latest('creation')
            ->with([
                'video_course:id,video_id,course_id',
                'video_course.course:id,name,designation'
            ])
            ->get();

        //Filter
        $videos = $this->allVideos = $this->nextilearnvideos = $visibility->filter($raw);

        $this->totalCount = $videos->count();

        $filters = VideoFiltersFromRequest::make();

        [
            $this->courses,
            $this->terms,
            $this->presenters,
            $this->tags,
            $this->videos,
        ] = $service->performFiltering($videos, $filters);
    }

    #[On('recompute')]
    public function handleRecompute(string $prop): void
    {
        // only allow known properties
        if (!in_array($prop, ['course', 'presenter', 'semester', 'tag'], true)) {
            return;
        }

        $this->{$prop} = null;
        $this->recompute();
    }

    public function updatedSelectedCourses($values) { $this->course = $values; $this->recompute(); }
    public function updatedSelectedPresenters($values) { $this->presenter = $values; $this->recompute(); }
    public function updatedSelectedSemesters($values) { $this->semester = $values; $this->recompute(); }
    public function updatedSelectedTags($values) { $this->tag = $values; $this->recompute(); }

    protected function recompute(): void
    {
        $filters = VideoFiltersFromRequest::make([
            'course' => $this->course ? explode(',', $this->course) : null,
            'semester' => $this->semester ? explode(',', $this->semester) : null,
            'tag' => $this->tag ? explode(',', $this->tag) : null,
            'presenter' => $this->presenter ? explode(',', $this->presenter) : null,
        ]);

        /** @var VideoSearchService $service */
        $service = app(VideoSearchService::class);

        [
            $this->courses,
            $this->terms,
            $this->presenters,
            $this->tags,
            $this->videos,
        ] = $service->performFiltering($this->allVideos, $filters);
    }

    public function render()
    {
        return view('livewire.nextilearn.next-ilearn-presentations');
    }
}
