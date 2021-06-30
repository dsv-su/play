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

    //Test
    public $viralSongs = '';

    public $songs = [
        'Say So',
        'The Box',
        'Laxed',
        'Savage',
        'Dance Monkey',
        'Viral',
        'Hotline Billing',
    ];
    //end Test

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

    public function remove_presenter($index)
    {
        unset($this->presenters[$index]);
    }

    public function remove_course()
    {
        $this->course = '';
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
