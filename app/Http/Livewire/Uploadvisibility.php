<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Uploadvisibility extends Component
{
    public $visibility;

    public function mount()
    {
        $this->visibility = 'visible';
    }

    public function updatedVisibility($state)
    {
        switch($state) {
            case('visible'):
                $this->visibility = 'visible';
                break;
            case('private'):
                $this->visibility = 'private';
                break;
            case('unlisted'):
                $this->visibility = 'unlisted';
                break;
        }

    }

    public function render()
    {
        return view('livewire.uploadvisibility');
    }
}
