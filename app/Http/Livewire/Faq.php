<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Faq extends Component
{
    public $start, $wiplay, $language, $rap, $navigate, $upload, $download, $manage_presentations, $manage_courses;
    public $edit, $player, $semester, $designation;
    public $admin;
    public $intended, $url_routes;
    public $toggle;
    public $role_staff, $role_admin;
    protected $queryString = ['start', 'wiplay', 'language', 'rap', 'navigate', 'player', 'upload', 'download', 'edit', 'manage_presentations', 'manage_courses', 'semester'];

    public function mount()
    {
        $this->intended = app()->make('play_faq_url');
        $this->url_routes = [
            'start' => '/',
            'search' => '/search',
            'upload' => '/upload',
            'download' => '/download',
            'edit' => '/edit/',
            'manage_presentations' => '/manage_presentations',
            'manage_courses' => '/manage_n',
            'semester' => '/semester/',
            'designation' => '/designation/',
            'course' => '/course/'
        ];

        //Check role
        $this->checkRole();

        //Activate intended page
        $this->activatePage($this->intended);
    }

    public function checkRole()
    {
        if(app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff' or app()->make('play_role') == 'Administrator') {
            $this->role_staff = true;
        } else {
            $this->role_staff = false;
        }

        //For admins
        if(app()->make('play_role') == 'Administrator') {
            $this->role_admin = true;
        }
    }

    public function activatePage($url)
    {
        switch($url) {
            case($this->url_routes['start']):
                $this->start = true;
                $this->wiplay = false;
                $this->navigate = true;
                $this->language = false;
                $this->rap = false;
                $this->player = false;
                $this->upload = false;
                $this->download = false;
                $this->manage_presentations = false;
                $this->manage_courses = false;
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
            case($this->url_routes['manage_presentations']):
                $this->manage_presentations = true;
                break;
            case($this->url_routes['manage_courses']):
                $this->manage_courses = true;
                break;

        }
        //Check parameter in URL
        switch(true) {
            case stristr($url, $this->url_routes['edit']):
                $this->edit = true;
                break;
            case stristr($url, $this->url_routes['semester']):
                $this->semester = true;
                break;
            case stristr($url, $this->url_routes['designation']):
                $this->designation = true;
                break;
            case stristr($url, $this->url_routes['course']):
                //$this->designation = true;
                break;
        }

    }

    public function hydrate()
    {
        $this->toggle = true;
    }

    public function start()
    {
        $this->start = true;
        $this->wiplay = false;
        $this->navigate = false;
        $this->language = false;
        $this->rap = false;
        $this->player = false;
        $this->upload = false;
        $this->download = false;
        $this->edit = false;
        $this->manage_presentations = false;
        $this->manage_courses = false;
        $this->semester = false;
        $this->designation = false;
    }

    public function wiplay()
    {
        $this->start = true;
        $this->wiplay = true;
        $this->navigate = false;
        $this->language = false;
        $this->rap = false;
        $this->player = false;
        $this->upload = false;
        $this->download = false;
        $this->edit = false;
        $this->manage_presentations = false;
        $this->manage_courses = false;
        $this->semester = false;
        $this->designation = false;
    }

    public function language()
    {
        $this->start = false;
        $this->wiplay = false;
        $this->navigate = false;
        $this->language = true;
        $this->rap = false;
        $this->player = false;
        $this->upload = false;
        $this->download = false;
        $this->edit = false;
        $this->manage_presentations = false;
        $this->manage_courses = false;
        $this->semester = false;
        $this->designation = false;
    }

    public function rap()
    {
        $this->start = false;
        $this->wiplay = false;
        $this->navigate = false;
        $this->language = false;
        $this->rap = true;
        $this->player = false;
        $this->upload = false;
        $this->download = false;
        $this->edit = false;
        $this->manage_presentations = false;
        $this->manage_courses = false;
        $this->semester = false;
        $this->designation = false;
    }

    public function navigate()
    {
        $this->start = false;
        $this->wiplay = false;
        $this->navigate = true;
        $this->language = false;
        $this->rap = false;
        $this->player = false;
        $this->upload = false;
        $this->download = false;
        $this->edit = false;
        $this->manage_presentations = false;
        $this->manage_courses = false;
        $this->semester = false;
        $this->designation = false;
    }

    public function player()
    {
        $this->player = true;
        $this->start = false;
        $this->wiplay = false;
        $this->navigate = false;
        $this->language = false;
        $this->rap = false;
        $this->upload = false;
        $this->download = false;
        $this->edit = false;
        $this->manage_presentations = false;
        $this->manage_courses = false;
        $this->semester = false;
        $this->designation = false;
    }

    public function upload()
    {
        $this->start = false;
        $this->wiplay = false;
        $this->navigate = false;
        $this->language = false;
        $this->rap = false;
        $this->player = false;
        $this->upload = true;
        $this->download = false;
        $this->edit = false;
        $this->manage_presentations = false;
        $this->manage_courses = false;
        $this->semester = false;
        $this->designation = false;
    }

    public function download()
    {
        $this->start = false;
        $this->wiplay = false;
        $this->navigate = false;
        $this->language = false;
        $this->rap = false;
        $this->player = false;
        $this->upload = false;
        $this->download = true;
        $this->edit = false;
        $this->manage_presentations = false;
        $this->manage_courses = false;
        $this->semester = false;
        $this->designation = false;
    }

    public function edit()
    {
        $this->start = false;
        $this->wiplay = false;
        $this->navigate = false;
        $this->language = false;
        $this->rap = false;
        $this->player = false;
        $this->upload = false;
        $this->download = false;
        $this->edit = true;
        $this->manage_presentations = false;
        $this->manage_courses = false;
        $this->semester = false;
        $this->designation = false;
    }

    public function manage_presentations()
    {
        $this->start = false;
        $this->wiplay = false;
        $this->navigate = false;
        $this->language = false;
        $this->rap = false;
        $this->player = false;
        $this->upload = false;
        $this->download = false;
        $this->edit = false;
        $this->manage_presentations = true;
        $this->manage_courses = false;
        $this->semester = false;
        $this->designation = false;
    }

    public function manage_courses()
    {
        $this->start = false;
        $this->wiplay = false;
        $this->navigate = false;
        $this->language = false;
        $this->rap = false;
        $this->player = false;
        $this->upload = false;
        $this->download = false;
        $this->edit = false;
        $this->manage_presentations = false;
        $this->manage_courses = true;
        $this->semester = false;
        $this->designation = false;
    }

    public function render()
    {
        return view('livewire.faq');
    }
}
