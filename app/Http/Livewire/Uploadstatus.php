<?php

namespace App\Http\Livewire;

use App\ManualPresentation;
use Livewire\Component;

class Uploadstatus extends Component
{
    public $files;

    protected $listeners = [
        'fileAdded' => 'incrementFileCount',
        'fileRemoved' => 'decrementFileCount'
    ];

    public function mount(ManualPresentation $presentation)
    {
        $this->files = (int)$presentation->files;
    }

    public function incrementFileCount()
    {
        $this->files++;
    }

    public function decrementFileCount()
    {
        $this->files--;
    }
    public function render()
    {
        return view('livewire.uploadstatus');
    }
}
