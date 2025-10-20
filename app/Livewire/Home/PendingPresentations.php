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
            ->select()
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
