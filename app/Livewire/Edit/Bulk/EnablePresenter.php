<?php

namespace App\Livewire\Edit\Bulk;

use Livewire\Component;

class EnablePresenter extends Component
{
    public bool $bulkpresenter = false;

    public function render()
    {
        return view('livewire.edit.bulk.enable-presenter');
    }
}
