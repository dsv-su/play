<?php

namespace App\Http\Livewire;

use App\Services\Pending\Pending;
use Livewire\Component;

class PendingVideo extends Component
{
    public $pending;

    public function mount()
    {
        $this->pending = Pending::presentations();
    }

    public function hydrate()
    {
        $this->pending = Pending::presentations();
    }

    public function render()
    {
        return view('livewire.pending-video');
    }
}
