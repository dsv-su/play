<?php

namespace App\Livewire\My;

use App\Livewire\Concerns\DSVCourseNames;
use App\Livewire\Concerns\FiltersPresentations;
use App\Services\Filters\VisibilityFilter;
use App\Services\MyPresentation\MyPresentationsService;
use App\Services\VideoSearch\VideoSearchService;
use Livewire\Component;

class UserPresentations extends Component
{
    use DSVCourseNames;
    use FiltersPresentations;

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

    public function render()
    {
        return view('livewire.my.old_user-presentations');
    }
}
