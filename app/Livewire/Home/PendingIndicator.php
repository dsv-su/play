<?php

namespace App\Livewire\Home;

use App\Models\Video;
use Livewire\Component;

class PendingIndicator extends Component
{
    public int $pending;

    public function render()
    {
        $this->pending = Video::query()
            ->select('id') // keep it lean
            ->where('state', false)
            ->count();
        return view('livewire.home.pending-indicator');
    }
}
