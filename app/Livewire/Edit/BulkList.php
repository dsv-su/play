<?php

namespace App\Livewire\Edit;

use Livewire\Component;

class BulkList extends Component
{
    public $videos;

    public function mount($videos)
    {
        $this->videos = $videos;
    }

    public function render()
    {
        return view('livewire.edit.bulk-list');
    }
}
