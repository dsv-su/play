<?php

namespace App\Livewire\Home;

use App\Models\Video;
use Livewire\Component;

class PendingPresentations extends Component
{
    public $pendingvideos;

    public function pending()
    {
        return Video::query()
            ->where('state', false)
            ->latest('created_at')
            ->with([
                'video_course:id,video_id,course_id',
                'video_course.course:id,name,designation',
                'pending:id,video_id,progress,handlers,updated_at',
            ])
            ->get();
    }

    public function render()
    {
        $pendingvideos = $this->pending();

        $this->pendingvideos = $pendingvideos;

        return view('livewire.home.pending-presentations', compact('pendingvideos'));
    }

}
