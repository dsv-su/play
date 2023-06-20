<?php

namespace App\Http\Livewire;

use App\ManualPresentation;
use App\Video;
use Livewire\Component;

class HandleSubtitles extends Component
{
    public $video, $presentation;
    public $purge = [];

    public function mount(Video $video, ManualPresentation $presentation)
    {
        $this->video = $video;
        $this->presentation = $presentation;
        if(!empty(json_decode($this->video->subtitles, true))) {
            foreach (json_decode($this->video->subtitles, true) as $key => $sub) {
                $this->purge[$key] = false;
            }
        }
    }

    public function remove($subtitle)
    {
        $this->purge[$subtitle] = true;
        switch($subtitle) {
            case('Generated'):
                if(!empty($this->presentation->subtitles)) {
                    $this->presentation->subtitles = array_merge($this->presentation->subtitles, [
                        'Generated' => ''
                    ]);
                } else {
                    $this->presentation->subtitles = [
                        'Generated' => ''
                    ];
                }
                break;
            case('Svenska'):
                if(!empty($this->presentation->subtitles)) {
                    $this->presentation->subtitles = array_merge($this->presentation->subtitles, [
                        'Svenska' => ''
                    ]);
                } else {
                    $this->presentation->subtitles = [
                        'Svenska' => ''
                    ];
                }
                break;
            case('English'):
                if(!empty($this->presentation->subtitles)) {
                    $this->presentation->subtitles = array_merge($this->presentation->subtitles, [
                        'English' => ''
                    ]);
                } else {
                    $this->presentation->subtitles = [
                        'English' => ''
                    ];
                }
                break;
        }
        $this->presentation->save();
    }

    public function render()
    {
        return view('livewire.handle-subtitles');
    }
}
