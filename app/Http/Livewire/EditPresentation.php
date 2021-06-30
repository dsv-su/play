<?php

namespace App\Http\Livewire;

use App\Course;
use Carbon\Carbon;
use Livewire\Component;

class EditPresentation extends Component
{
    public $video;
    public $title, $thumb, $created, $date, $origin, $duration;
    public $presenters = [];
    public $presenter, $course, $coursedetail, $course_semester, $course_year;

    public function mount($video)
    {
        $this->title = $video->title;
        $this->thumb = $video->thumb;
        $this->origin = $video->origin;
        $this->duration = $video->duration;
        $this->created = $this->getDateAttribute($video->creation);
        //dd($video->courses());
        foreach($video->presenters() as $this->presenter) {
            $this->presenters[] = $this->presenter->name;
        }
        foreach($video->courses() as $this->coursedetail) {
            $this->course = $this->coursedetail->name.' '.$this->coursedetail->semester.' '.$this->coursedetail->year;
            $this->course_semester = $this->coursedetail->semester;
            $this->course_year = $this->coursedetail->year;
        }

    }

    public function getDateAttribute($date)
    {
        $this->date = Carbon::createFromTimestamp($date)->format('Y-m-d');

        return $this->date;
    }

    public function presenteradd()
    {
        $this->presenters[] = '';
    }

    public function video()
    {
        foreach($this->presenters as $this->presenter) {
            if(empty($this->presenter)) {

            }
        }
        dd($this->presenters);

    }

    public function render()
    {
        return view('livewire.edit-presentation');
    }
}
