<?php

namespace App\Http\Livewire;

use App\Cattura;
use App\Course;
use App\Jobs\ProcessCatturaStatus;
use App\ManualPresentation;
use App\MediasiteFolder;
use App\Permission;
use App\Presentation;
use App\Services\Cattura\CatturaRecoders;
use App\Services\CountPresentations;
use App\Video;
use App\VideoPermission;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $store_status, $daisy_status, $daisy_ok_status;
    public $presentations, $stats_mediasite, $percent_mediasite, $stats_mediasite_folders;
    public $stats_cattura, $percent_cattura, $stats_manual, $percent_manual;
    public $total_uploads, $init_uploads, $pending_uploads, $sent_uploads, $stored_uploads, $completed_uploads;
    public $total_downloads, $requested_downloads, $stored_downloads;
    public $stats_permissions, $stats_permissions_dsv, $stats_permissions_staff, $stats_permissions_public, $stats_permissions_private, $total_set;
    public $videos, $cattura, $json_files;
    public $total_courses, $courses_2022, $percent_courses_2022, $courses_2021, $percent_courses_2021, $courses_2020, $percent_courses_2020, $courses_2019, $percent_courses_2019;
    protected $file;
    protected $listeners = ['refreshCattura' => '$refresh'];

    public function mount(CatturaRecoders $catturaRecoders, Cattura $cattura, CountPresentations $countPresentations)
    {
        $this->externalApiStatus();
        $catturaRecoders->init();
        $this->checkStats($cattura, $countPresentations);
        //Stats
        $this->stats($countPresentations);
    }

    public function checkStats(Cattura $cattura, CountPresentations $countPresentations)
    {
        //Checks Cattura-recorders status asynchronus
        $this->cattura = $cattura->all()->toArray();
        ProcessCatturaStatus::dispatch();
        //Stats
        $this->stats($countPresentations);

    }

    private function stats(CountPresentations $countPresentations)
    {
        //$this->videos = new CountPresentations();
        $this->presentations =  $countPresentations->latest();
        //Mediasite
        $this->stats_mediasite = Video::where('origin', 'mediasite')->count();
        $this->percent_mediasite = (int)$this->stats_mediasite / (int)$this->presentations * 100;
        $this->stats_mediasite_folders = MediasiteFolder::count();
        //Cattura
        $this->stats_cattura = Video::where('origin', 'cattura')->count();
        $this->percent_cattura = (int)$this->stats_cattura / (int)$this->presentations * 100;
        //Manual
        $this->stats_manual = Video::where('origin', 'manual')->count();
        $this->percent_manual = (int)$this->stats_manual / (int)$this->presentations * 100;
        //Uploads
        $this->total_uploads = ManualPresentation::all()->count();
        $this->init_uploads = ManualPresentation::where('status', 'init')->count();
        $this->pending_uploads = ManualPresentation::where('status', 'pending')->count();
        $this->sent_uploads = ManualPresentation::where('status', 'sent')->count();
        $this->stored_uploads = ManualPresentation::where('status', 'stored')->count();
        $this->completed_uploads = ManualPresentation::where('status', 'completed')->count();
        //Downloads
        $this->total_downloads = Presentation::all()->count();
        $this->requested_downloads = Presentation::where('status', 'request download')->count();
        $this->stored_downloads = Presentation::where('status', 'stored')->count();
        //Permissions
        $this->stats_permissions = Permission::count();
        $this->stats_permissions_dsv = VideoPermission::with('permission')->where('permission_id', 1)->count();
        $this->stats_permissions_staff =VideoPermission::with('permission')->where('permission_id', 2)->count();
        $this->stats_permissions_public = VideoPermission::with('permission')->where('permission_id', 4)->count();
        $this->stats_permissions_private = VideoPermission::with('permission')->where('permission_id', 3)->count();
        $this->total_set = VideoPermission::all()->count();
        //JSON files
        $this->json_files = $this->checkJsonFiles();
        //Courses
        $this->total_courses = Course::all()->count();
        $this->courses_2022 = Course::where('year', 2022)->count();
        $this->percent_courses_2022 = (int)$this->courses_2022 / (int)$this->total_courses * 100;
        $this->courses_2021 = Course::where('year', 2021)->count();
        $this->percent_courses_2021 = (int)$this->courses_2021 / (int)$this->total_courses * 100;
        $this->courses_2020 = Course::where('year', 2020)->count();
        $this->percent_courses_2020 = (int)$this->courses_2020 / (int)$this->total_courses * 100;
        $this->courses_2019 = Course::where('year', 2019)->count();
        $this->percent_courses_2019 = (int)$this->courses_2019 / (int)$this->total_courses * 100;

    }
    private function checkJsonFiles()
    {
        $directory = 'backup';
        $files = Storage::disk('public')->files($directory);
        return count($files);
    }

    private function externalApiStatus()
    {
        if(app()->make('store_status') == 'on') {
            $this->store_status = true;
        } else {
            $this->store_status = false;
        }
        if(app()->make('daisy_db_status') == 'on') {
            $this->daisy_status = true;
        } else {
            $this->daisy_status = false;
        }
        if(app()->make('daisy_ok_status') == 'on') {
            $this->daisy_ok_status = true;
        } else {
            $this->daisy_ok_status = false;
        }
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
