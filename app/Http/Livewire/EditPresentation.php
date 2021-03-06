<?php

namespace App\Http\Livewire;

use App\VideoCourse;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPresentation extends Component
{
    //use WithFileUploads;

    public $video;
    public $title, $thumb, $created, $date, $origin, $duration, $category;
    public $presenters = [], $presenters_uid = [];
    public $presenter, $course, $coursedetail, $course_semester, $course_year, $courseId;
    public $courseselect = [];
    public $sukatusers = [];
    public $courseEdit;
    public $permissions, $presentationpermissonId, $presentationpermissonScope;
    public $sources = [], $playAudio = [], $poster = [];


    public function mount($video, $courses, $permissions)
    {
        $this->video = $video;
        $this->title = $video->title;
        $this->thumb = $video->thumb;
        $this->origin = $video->origin;
        $this->duration = $video->duration;
        $this->created = $this->getDateAttribute($video->creation);
        $this->persmissions = $permissions;
        $this->category = $video->category->category_name;
        //dd($this->sources = json_decode($video->sources));
        $this->sources = json_decode($video->sources);

        foreach($video->presenters() as $this->presenter) {
            $this->presenters[] = $this->presenter->name. ' ('.$this->presenter->username.')';
            $this->presenters_uid[] = $this->presenter->username;
        }
        foreach($video->courses() as $this->coursedetail) {
            $this->course = $this->coursedetail->name.' '.$this->coursedetail->semester.' '.$this->coursedetail->year;
            $this->courseId = $this->coursedetail->id;
            $this->course_semester = $this->coursedetail->semester;
            $this->course_year = $this->coursedetail->year;
        }
        foreach($courses as $data) {
            $this->courseselect[$data->id] = $data->name. ' '. $data->semester. ' '. $data->year;
        }

        foreach($video->permissions() as $p) {
            $this->presentationpermissonId = $p->id;
            $this->presentationpermissonScope = $p->scope;
        }

        foreach($this->sources as $source) {
            $this->playAudio[] = $source->playAudio;
            $this->poster[] = $source->poster;
        }

    }

    public function getDateAttribute($date)
    {
        $this->date = Carbon::createFromTimestamp($date)->format('Y-m-d');

        return $this->date;
    }

    public function newpresenter()
    {
        $this->presenters[] = '';
        $this->presenters_uid[] = '';
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function remove_presenter($index)
    {
        unset($this->presenters[$index]);
    }

    public function remove_course()
    {
        $this->course = '';
    }

    public function render()
    {
        return view('livewire.edit-presentation');
    }
}
