<?php

namespace App\Livewire\Home;

use App\Models\Video;
use Livewire\Component;

class PendingPresentations extends Component
{
    public $pendingvideos;

    public function mount()
    {
        $this->pendingvideos = Video::query()
            ->select(['id', 'title', 'creation', 'duration', 'visibility', 'state', 'thumb', 'category_id', 'description']) // keep it lean
            ->where('state', false)
            ->latest('creation')
            ->with([
                'video_course:id,video_id,course_id',
                'video_course.course:id,name,designation'
            ])
            ->get();
    }

    public function render()
    {
        return view('livewire.home.pending-presentations');
    }
}
