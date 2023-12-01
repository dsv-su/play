<?php

namespace App\Http\Livewire;

use App\ManualPresentation;
use Livewire\Component;

class WhisperLanguage extends Component
{
    public $lang;
    public $presentation;
    public $whisper;
    public $test;

    public function mount(ManualPresentation $presentation)
    {
        $this->lang = false;
        $this->presentation = $presentation;
        $this->presentation->sublanguage = null;
        $this->presentation->save();
    }
    public function subtitleslanguage()
    {
        $this->lang = !$this->lang;

        //$this->dispatchBrowserEvent('contentChanged', ['langsubs' => $this->lang]);
    }

    public function updatedWhisper($state)
    {
        $this->presentation->sublanguage = $state;
        $this->presentation->save();
    }

    public function render()
    {
        return view('livewire.whisper-language');
    }
}
