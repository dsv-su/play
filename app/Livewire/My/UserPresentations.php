<?php

namespace App\Livewire\My;

use App\Livewire\Concerns\DSVCourseNames;
use App\Services\Filters\VisibilityFilter;
use App\Services\MyPresentation\MyPresentationsService;
use App\Services\VideoSearch\VideoSearchService;
use App\Support\VideoFiltersFromRequest;
use Livewire\Attributes\On;
use Livewire\Component;

class UserPresentations extends Component
{
    use DSVCourseNames;

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
        return view('livewire.my.user-presentations');
    }
}
