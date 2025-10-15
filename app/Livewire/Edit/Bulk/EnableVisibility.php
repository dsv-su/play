<?php

namespace App\Livewire\Edit\Bulk;

use Livewire\Component;

class EnableVisibility extends Component
{
    public bool $bulkvisibility = false;

    public function render()
    {
        return view('livewire.edit.bulk.enable-visibility');
    }
}
