<?php

namespace App\Http\Livewire;

use App\Services\Pending\Pending;
use Livewire\Component;

class Hometab extends Component
{
    protected $hasMy;
    protected $hasStudieadmin;
    protected $studyinfo;
    protected $hasActiveHT;
    protected $hasActiveVT;
    protected $hasPreviousHT;
    protected $previouspaginated_ht;
    protected $hasLatest;
    protected $allpaginated;
    public $hasQueued;
    public $pending;

    public function mount($hasMy, $hasStudieadmin, $studyinfo, $hasActiveHT, $hasActiveVT, $hasPreviousHT, $previouspaginated_ht, $hasLatest, $allpaginated)
    {
        $this->hasMy = $hasMy;
        $this->hasStudieadmin = $hasStudieadmin;
        $this->studyinfo = $studyinfo;
        $this->hasActiveHT = $hasActiveHT;
        $this->hasActiveVT = $hasActiveVT;
        $this->hasPreviousHT = $hasPreviousHT;
        $this->previouspaginated_ht = $previouspaginated_ht;
        $this->hasLatest = $hasLatest;
        $this->allpaginated = $allpaginated;
        $this->checkQueue();
    }

    public function checkQueue()
    {
        $this->pending = Pending::presentations();
        $this->hasQueued = isset($this->pending) && $this->pending->count();
    }

    public function hydrate()
    {
        $this->checkQueue();
    }

    public function render()
    {
        return view('livewire.hometab');
    }
}
