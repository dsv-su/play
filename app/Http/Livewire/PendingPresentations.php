<?php

namespace App\Http\Livewire;

use App\Services\Pending\Pending;
use Livewire\Component;

class PendingPresentations extends Component
{
    public $state;

    public function mount()
    {
        $this->state = Pending::presentations_state();
    }

    public function hydrate()
    {
        if(Pending::presentations_state()) {
            $this->state = true;
        } else {
            $this->state = false;
        }
    }

    public function render()
    {
        return view('livewire.pending-presentations');
    }
}
