<?php

namespace App\Livewire\Edit\Bulk;

use Livewire\Component;

class EnableDownload extends Component
{
    public bool $bulkdownload = false;

    public function render()
    {
        return view('livewire.edit.bulk.enable-download');
    }
}
