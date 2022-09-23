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
    public $videopresenters = [], $videoterms = [], $videotags = [];
    public $presenter, $semester, $tag;
    public $view;
    public $counter, $uncatcounter;
    public $uncat_videos = [];
    public $stats_playback = [], $stats_download = [];
    public $filter, $filterTerm;
    public $searchTerm;
    public $presentations;

    protected $queryString = ['filterTerm', 'presenter', 'tag'];

    public function mount()
    {
        //Initial default settings
        $this->view = 'presenters';
        $this->videoformat = Cookie::get('videoformat') ?? 'grid';
        $dropdownfilter = new DropdownFilters;
        $this->filters = $dropdownfilter->handleUrlParams();
        $this->grid = 'grid';
        $this->list = 'list';
        $this->table = 'table';

        if($this->checkQueryString()) {
            $this->updatedFilterTerm();
        } else {
            //Redirect depending on role
            if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
                //Uploader
                $this->uploaderManage();
            } else {
                //Administrator
                $this->adminManage();
            }
        }

    }

    public function checkQueryString()
    {
        foreach(array_filter($this->filters) as $filter => $value) {
            if($filter == 'filterTerm' && !is_null($value)) {
                return true;
            }
        }
        return false;
    }

    public function injectToSession()
    {
        //Retrive session links array
        $links = session()->has('links') ? session('links') : [];

        //Set filters
        $values = array_filter($this->filters);

        //Current link
        $currentLink = 'manage_presentations?';

        //Merge current link with filters
        foreach($values as $filter => $value) {
            foreach($value as $key => $parameter) {
                if ($key === 0) {
                    $currentLink = $currentLink . $filter . '=' . $parameter;
                } else {
                    $currentLink = $currentLink . '&' . $filter . '=' . $parameter;
                }
            }
            if(!(end($values) == $value)) {
                $currentLink = $currentLink . '&';
            }

        }

        //Putting it in the beginning of links array
        array_unshift($links, $currentLink);

        //Saving links array to the session
        session(['links' => $links]);
    }

    public function resetFilter()
    {
        $this->reset('videopresenters');
        $this->reset('videotags');
        //Redirect depending on role
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            //CourseAdmin and Uploader
            $this->uploaderManage();
        } else {
            //Administrator
            $this->adminManage();
        }
    }

    public function filters()
    {
        $videos = $this->uncat_video_courses;

        $dropdownfilter = new DropdownFilters;

        list ($courses, $this->videoterms, $this->videopresenters, $this->videotags, $this->video_courses, $this->uncat_video_courses) = $dropdownfilter->performFiltering(
            $videos, $this->filters['course'], $this->filters['term'], $this->filters['tag'], $this->filters['presenter']
        );

        //Sort the filter arrays
        $this->videopresenters = collect($this->videopresenters)->sort()->toArray();
        sort($this->videotags);
        $this->loadUncat();

    }

    public function updatedPresenter($selected_presenter)
    {
        //Turn into array
        $selected_presenter = explode( ',', $selected_presenter);

        $this->filter_presenter = $selected_presenter;

        if (empty($selected_presenter)) {
            //TODO
            $this->uploaderManage();
        } else {
            $this->filters['presenter'] = $selected_presenter;
            $this->filters();
        }

        //Uncategorized presentations
        $this->uncat_video_courses = UncatPresentations::my_uncat_video_course_presenter(app()->make('play_username'), $selected_presenter);
        $this->injectToSession();
        $this->prepareRendering();

    }

    public function updatedTag($selected_tag)
    {
        //Turn into array
        $selected_tag = explode( ',', $selected_tag);

        $this->filter_tag = $selected_tag;
        if (empty($selected_tag)) {
            //TODO
            $this->uploaderManage();
        } else {
            $this->filters['tag'] = $selected_tag;
            $this->filters();
        }

        //Uncategorized presentations
        $this->uncat_video_courses = UncatPresentations::my_uncat_video_course_tag(app()->make('play_username'), $selected_tag);
        $this->injectToSession();
        $this->prepareRendering();
    }

    public function uploaderManage()
    {
        //Uncat videos
        $this->uncat_video_courses = UncatPresentations::my_uncat_video_course(app()->make('play_username'));
        $this->loadUncat();
        $this->filters();
        $this->prepareRendering();
    }

    public function adminManage()
    {
        //Uncat videos
        $this->uncat_video_courses = UncatPresentations::unfiltered_uncat_video_course();
        $this->loadUncat();
        $this->filters();
        $this->prepareRendering();
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

        //Querystring
        $this->filters['filterTerm'] = explode( ',', $this->filterTerm);
        $this->filters();
        $this->injectToSession();

        //Counter for uncategorized presentations
        $this->countUncatPresentations($this->uncat_video_courses);
        //Render filtered collection
        $this->loadUncat();
    }

    public function loadUncat()
    {
        $visibility = new VisibilityFilter;
        $this->uncat_videos = $visibility->filter($this->uncat_video_courses);
        $this->stats($this->uncat_videos);
    }

    public function prepareRendering()
    {
        $this->countUncatPresentations($this->uncat_videos);
    }

    public function countUncatPresentations($presentations)
    {
        $this->uncatcounter = count($presentations);
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
