<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Faq extends Component
{
    public $start, $wiplay, $language, $rap, $navigate, $search, $upload, $download, $manage, $admin;
    public $intended, $url_routes;
    public $toggle;

    public function mount()
    {
        $this->intended = app()->make('play_faq_url');
        $this->url_routes = [
            'start' => '/',
            'search' => '/search',
            'upload' => '/upload',
            'download' => '/download'
        ];

        //Activate intended page
        $this->activatePage($this->intended);
    }

    public function activatePage($url)
    {
        switch($url) {
            case($this->url_routes['start']):
                $this->start = true;
                $this->wiplay = true;
                $this->navigate = true;
                $this->language = true;
                $this->rap = true;
                break;
            case($this->url_routes['search']):
                $this->search = true;
                break;
            case($this->url_routes['upload']):
                $this->upload = true;
                break;
            case($this->url_routes['download']):
                $this->download = true;
                break;

        }
    }
    public function hydrate()
    {
        $this->toggle = true;
    }

    public function wiplay()
    {
        $this->start = false;
        $this->wiplay = true;
        $this->navigate = false;
        $this->language = false;
        $this->rap = false;
    }

    public function language()
    {
        $this->start = false;
        $this->wiplay = false;
        $this->navigate = false;
        $this->language = true;
        $this->rap = false;
    }

    public function rap()
    {
        $this->start = false;
        $this->wiplay = false;
        $this->navigate = false;
        $this->language = false;
        $this->rap = true;
    }

    public function navigate()
    {
        $this->start = false;
        $this->wiplay = false;
        $this->navigate = true;
        $this->language = false;
        $this->rap = false;
    }

    public function render()
    {
        return view('livewire.faq');
    }
}
