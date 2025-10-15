<?php

namespace App\Livewire\Home;

use App\Models\Video;
use App\Services\Filters\VisibilityFilter;
use Livewire\Component;

class Newpresentations extends Component
{
    public $newvideos;

    public function mount(VisibilityFilter $visibility)
    {
        //$raw = Video::with('video_course.course')->where('visibility', true)->where('state', true)->latest('creation')->limit(10)->get();
        $raw = Video::query()
            ->select(['id', 'title', 'creation', 'duration', 'visibility', 'state', 'thumb', 'category_id', 'description']) // keep it lean
            ->where('visibility', true)
            ->where('state', true)
            ->latest('creation')
            ->limit(10)
            ->with([
                'video_course:id,video_id,course_id',
                'video_course.course:id,name,designation'
            ])
            ->get();

        //Filter
        $this->newvideos = $visibility->filter($raw);
    }

    public function render()
    {
        return view('livewire.home.newpresentations');
    }
}
