<?php

namespace App\Livewire\Edit;

use Livewire\Component;

class BulkDownload extends Component
{
    public bool $download = false;

    public function render()
    {
        return view('livewire.edit.bulk-download');
    }
}
