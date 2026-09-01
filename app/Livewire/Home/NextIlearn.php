<?php

namespace App\Livewire\Home;

use App\Models\Video;
use App\Services\Filters\VisibilityFilter;
use Livewire\Component;

class NextIlearn extends Component
{
    public $nextilearnvideos;
    public int $totalCount = 0;

    public function mount(VisibilityFilter $visibility)
    {
        // Base query for visible and active study videos
        $baseQuery = Video::query()
            ->where('visibility', true)
            ->where('state', true)
            ->where('category_id', 8);

        // Count *all* videos that match the filters (without limit)
        $this->totalCount = $baseQuery->count();

        // Fetch the first 10 videos (with relationships)
        $raw = $baseQuery
            ->select(['id', 'title', 'title_en', 'creation', 'duration', 'visibility', 'state', 'subtitles', 'download',
                'thumb', 'category_id', 'description'])
            ->latest('creation')
            ->limit(10)
            ->with([
                'video_course:id,video_id,course_id',
                'video_course.course:id,name,designation'
            ])
            ->get();

        // Apply visibility filter
        $this->nextilearnvideos = $visibility->filter($raw);
    }

    public function render()
    {
        return view('livewire.home.next-ilearn');
    }
}
