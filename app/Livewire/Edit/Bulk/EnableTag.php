<?php

namespace App\Livewire\Edit\Bulk;

use Livewire\Component;

class EnableTag extends Component
{
    public bool $bulktag = false;

    public function render()
    {
        return view('livewire.edit.bulk.enable-tag');
    }
}
