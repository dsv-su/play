<?php

namespace App\Http\Livewire;

use App\ManualPresentation;
use Livewire\Component;

class Autosubtitles extends Component
{
    public $subtitles;
    public $presentation;

    public function mount(ManualPresentation $presentation)
    {
        $this->subtitles = false;
        $this->presentation = $presentation;
    }

    public function autosubtitles()
    {
        $this->subtitles = !$this->subtitles;
        $this->presentation->autogenerate_subtitles = $this->subtitles;
        $this->presentation->save();
        $this->dispatchBrowserEvent('contentChanged', ['autosubs' => $this->subtitles]);
    }

    public function render()
    {
        return view('livewire.autosubtitles');
    }
}
