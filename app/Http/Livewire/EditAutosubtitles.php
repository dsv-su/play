<?php

namespace App\Http\Livewire;

use App\ManualPresentation;
use App\Video;
use Livewire\Component;

class EditAutosubtitles extends Component
{
    public $subtitles;
    public $presentation, $video;
    public $generated;

    public function mount(ManualPresentation $presentation, Video $video)
    {
        $this->subtitles = false;
        $this->presentation = $presentation;
        $this->video = $video;
        $this->generated = false;
        $this->checkSubtitles();
    }

    public function autosubtitles()
    {
        $this->subtitles = !$this->subtitles;
        $this->presentation->autogenerate_subtitles = $this->subtitles;
        $this->presentation->save();
        $this->dispatchBrowserEvent('contentChanged', ['autosubs' => $this->subtitles]);
    }

    public function checkSubtitles()
    {
        if($this->video->subtitles) {
            //Checks for generated subtitles
            foreach(json_decode($this->video->subtitles) as $key => $sub) {
                if($key == 'Generated') {
                    $this->generated = true;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.edit-autosubtitles');
    }
}
