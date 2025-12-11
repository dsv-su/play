<?php

namespace App\Livewire\Share;

use App\Models\Video;
use Livewire\Component;

class SelectDefaultSubs extends Component
{
    public Video $video;

    public string $shareUrl = '';

    public string $mode = 'multiplayer'; // example: controlled by buttons
    public ?string $language = null;     // example: subtitle language

    public function mount(Video $video)
    {
        $this->video = $video;
        $this->updateShareUrl();
    }

    public function setMode(string $mode)
    {
        $this->mode = $mode;
        $this->updateShareUrl();
    }

    public function setLanguage(?string $language)
    {
        $this->language = $language;
        $this->updateShareUrl();
    }

    protected function updateShareUrl(): void
    {
        // Adjust this to match your real route & params
        $this->shareUrl = url('/multiplayer', [
            'p'    => $this->video->id,
            'mode' => $this->mode,
            'lang' => $this->language,
        ]);
    }

    public function render()
    {
        return view('livewire.share.select-default-subs');
    }
}
