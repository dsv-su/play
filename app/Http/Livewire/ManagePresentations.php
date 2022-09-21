<?php

namespace App\Http\Livewire;

use App\Services\Filters\VisibilityFilter;
use App\Services\Manage\DropdownFilters;
use App\Services\Manage\UncatPresentations;
use App\VideoStat;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class ManagePresentations extends Component
{
    public $grid, $list, $table;
    public $videoformat = '';
    public $videopresenters = [], $videoterms = [], $videocourses = [], $videotags = [];
    public $view;
    public $counter, $uncatcounter;
    public $uncat, $uncat_videos = [];
    public $stats_playback = [], $stats_download = [];
    public $filter, $filterTerm;

    public function mount()
    {
        //Initial default settings
        $this->view = 'presenters';
        $this->uncat = false;
        $this->videoformat = Cookie::get('videoformat') ?? 'grid';
        $dropdownfilter = new DropdownFilters;
        $this->filters = $dropdownfilter->handleUrlParams();
        $this->grid = 'grid';
        $this->list = 'list';
        $this->table = 'table';

        //Redirect depending on role
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            //Uploader
            if($this->containsOnlyNull($this->filters)) {
                $this->uploaderManage();
            } else {
                dd('Hey');
            }

        } else {
            //Administrator
            if($this->containsOnlyNull($this->filters)) {
                $this->adminManage();
            } else {
                dd('Hey');
            }

        }
    }

    public function uploaderManage()
    {
        //Uncat videos
        $this->uncat_video_courses = UncatPresentations::my_uncat_video_course(app()->make('play_username'));
        $this->prepareRendering();
        //$this->filters();
    }

    public function adminManage()
    {

    }

    public function updatedFilterTerm()
    {
        //Prepare
        $filterTerm = '%' . $this->filterTerm . '%';
        $this->searchTerm = $filterTerm;

        //Filters uncategorized presentations
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            //Not administrator
            $this->uncat_video_courses = UncatPresentations::my_uncat_video_course(app()->make('play_username'), $filterTerm);
        } else {
            //Administrator
            $this->uncat_video_courses = UncatPresentations::unfiltered_uncat_video_course($filterTerm);
        }
        //Counter for uncategorized presentations
        $this->countUncatPresentations($this->uncat_video_courses);
    }

    public function loadUncat(VisibilityFilter $visibility)
    {
        $this->uncat = !$this->uncat;
        $this->uncat_videos = $visibility->filter($this->uncat_video_courses);
        $this->stats($this->uncat_videos);
    }

    public function prepareRendering()
    {
        //$this->collapseAll($this->video_courses);
        //$this->countPresentations($this->video_courses);
        $this->countUncatPresentations($this->uncat_video_courses);
        //$this->courseSettings($this->video_courses);
    }

    public function countUncatPresentations($course)
    {
        $this->uncatcounter = $course->count();
    }

    /**
     * @param $videoformat
     * @return Application|RedirectResponse|Redirector
     */
    public function videoformat($videoformat)
    {
        Cookie::queue('videoformat', $videoformat, 999999999);
        $this->videoformat = $videoformat;
    }

    public function render()
    {
        return view('livewire.manage-presentations');
    }

    /**
     * @param $videos
     * @return void
     */
    public function stats($videos)
    {
        foreach ($videos as $video) {
            //Playback
            $this->stats_playback[$video['id']] = VideoStat::where('video_id', $video['id'])->pluck('playback')->first();
            //Download
            $this->stats_download[$video['id']] = VideoStat::where('video_id', $video['id'])->pluck('download')->first();
        }
    }

    private function containsOnlyNull($filterarray)
    {
        return empty(array_filter($filterarray, function ($a) { return $a != null;}));
    }

}
