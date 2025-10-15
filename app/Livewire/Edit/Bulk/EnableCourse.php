<?php

namespace App\Livewire\Edit\Bulk;

use Livewire\Component;

class EnableCourse extends Component
{
    public bool $bulkcourse = false;

    public function render()
    {
        return view('livewire.edit.bulk.enable-course');
    }
}
