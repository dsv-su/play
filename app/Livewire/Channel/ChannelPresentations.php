<?php

namespace App\Livewire\Channel;

use App\Livewire\Concerns\DSVCourseNames;
use App\Livewire\Concerns\FiltersPresentations;
use App\Models\Channel;
use App\Services\Filters\VisibilityFilter;
use App\Services\VideoSearch\VideoSearchService;
use Livewire\Component;

class ChannelPresentations extends Component
{
    use DSVCourseNames, FiltersPresentations;

    public Channel $channel;

    public array $courses = [];

    public array $terms = [];

    public array $presenters = [];

    public array $tags = [];

    public $course;

    public $presenter;

    public $semester;

    public $tag;

    public array $selectedCourses = [];

    public array $selectedPresenters = [];

    public array $selectedSemesters = [];

    public array $selectedTags = [];

    public array $activeFilters = ['courses' => true, 'presenters' => true, 'semesters' => true, 'tags' => true];

    public array $selectedVideos = [];

    public bool $switchOn = false;

    public $allowBulkEdit = false;

    public $videos;

    public $allVideos;

    public int $totalCount = 0;

    public function mount(Channel $channel, VisibilityFilter $visibility, VideoSearchService $service): void
    {
        $this->channel = $channel;
        $raw = $channel->presentations()
            ->where('visibility', true)->where('state', true)
            ->latest('creation')->with(['video_course:id,video_id,course_id', 'video_course.course:id,name,designation'])->get();
        $videos = $this->allVideos = $visibility->filter($raw);
        $this->totalCount = $videos->count();
        $this->initializePresentationFilters($videos, $service);
    }

    public function render()
    {
        return view('livewire.channel.channel-presentations');
    }
}
