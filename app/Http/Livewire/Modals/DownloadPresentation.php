<?php

namespace App\Http\Livewire\Modals;

use App\Video;
use Livewire\Component;

class DownloadPresentation extends Component
{
    public $video, $title;
    public $show, $status;

    protected $listeners = ['showModal', 'doClose'];

    public function mount()
    {
        $this->show = false;
    }

    public function showModal(Video $video)
    {
        $this->video = $video;
        $this->status = 'Starting download';
        $this->title = $video->title;
        $this->doShow();
    }

    public function doShow()
    {
        $this->show = true;
    }

    public function doClose()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.modals.download-presentation');
    }
}
