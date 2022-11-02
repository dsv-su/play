<?php

namespace App\Http\Livewire;

use App\Services\Filters\VisibilityFilter;
use App\Services\Manage\DropdownFilters;
use App\Services\Manage\MyPresentations;
use App\Video;
use App\VideoCourse;
use App\VideoPresenter;
use App\VideoStat;
use App\VideoTag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class ManagePresentations extends Component
{
    public $grid, $list, $table;
    public $videoformat = '';
    public $videopresenters = [], $videoterms = [], $videotags = [];
    public $presenter, $semester, $term, $tag;
    public $view;
    public $counter, $uncatcounter;
    public $uncat_videos = [];
    public $stats_playback = [], $stats_download = [];
    public $filter, $filterTerm;
    public $searchTerm;
    public $presentations;
    public $page;
    public $checkAll, $checked_videos, $allChecked;
    public $admin;
    public $uncat_video_courses;
    public $admin_total;

    protected $queryString = ['filterTerm', 'presenter', 'tag'];

    public function mount($page)
    {
        //Redirect
        $this->page = $page;

        //Initial default settings
        $this->view = 'presenters';
        $this->allChecked = false;
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
                $this->admin = false;
                $this->uploaderManage();
            } else {
                //Administrator
                $this->admin = true;
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

    public function checkActiveFilter()
    {
        foreach(array_filter($this->filters) as $filter) {
            if($filter) {
                return true;
            }
        }
        return false;
    }

    public function injectToSession()
    {
        $path = 'manage_presentations';

        //Retrive session links array
        $links = session()->has('links') ? session('links') : [];

        //Set filters
        $values = array_filter($this->filters);

        //Current link
        $currentLink = $path . '?';

        //Merge current link with filters
        foreach($values as $filter => $value) {
            foreach($value as $key => $parameter) {
                if ($key === 0) {
                    if($filter != 'filterTerm') {
                        $currentLink = $currentLink . $filter . '['. $key.']'. '=' . $parameter;
                    } else {
                        $currentLink = $currentLink . $filter . '=' . $parameter;
                    }
                }
                else {
                    if($filter != 'filterTerm') {
                        $currentLink = $currentLink . '&' . $filter . '[' . $key . ']' . '=' . $parameter;
                    } else {
                        $currentLink = $currentLink . '&' . $filter . '=' . $parameter;
                    }
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

    public function resetDropdown()
    {
        $this->reset('videopresenters');
        $this->reset('videotags');
        $this->presenter = [];
        $this->tag = [];
    }

    public function filter()
    {
        $this->updatedFilterTerm();
    }

    public function filters()
    {
        $videos = $this->uncat_video_courses;
        $dropdownfilter = new DropdownFilters;

        list ($this->videoterms, $x, $this->videotags, $this->video_courses, $this->uncat_video_courses, $x) = $dropdownfilter->performFiltering(
            $videos, $unfiltered_videos = [], $this->filters['course'], $this->filters['term'], $this->filters['tag'], $this->filters['presenter'], $term = []
        );

        //Sort the filter arrays
        $this->videopresenters = collect($this->videopresenters)->sort()->toArray();
        sort($this->videotags);
        $this->injectToSession();
        $this->loadUncat();
    }

    public function updatedPresenter($selected_presenter)
    {
        $this->presenter = $selected_presenter;
        $this->filter_presenter = $selected_presenter;
        $this->filters['presenter'] = $selected_presenter;

        $this->filters();
        $this->prepareRendering();

        return redirect(session('links')[0]);
    }

    public function updatedTerm($selected_term)
    {
        $this->term = $selected_term;
        $this->filter_term = $selected_term;
        $this->filters['term'] = $selected_term;

        $this->filters();
        $this->prepareRendering();

        return redirect(session('links')[0]);
    }

    public function updatedTag($selected_tag)
    {
        $this->tag = $selected_tag;
        $this->filter_tag = $selected_tag;
        $this->filters['tag'] = $selected_tag;

        $this->filters();
        $this->prepareRendering();

        return redirect(session('links')[0]);
    }

    public function uploaderManage()
    {
        //Users presentations
        $this->uncat_video_courses = MyPresentations::my_uncat_video_course(app()->make('play_username'));
        $this->loadUncat();
        $this->createPresenterSelect();
        $this->filters();
        $this->prepareRendering();

    }

    public function adminManage()
    {
        //Count entire collection
        $this->admin_total = Video::count();

        if(!$this->checkActiveFilter()) {
            //Init state for admin
            $this->uncat_video_courses = MyPresentations::unfiltered_uncat_video_course();
            $this->loadUncat();

            //Initiate dropdown filters
            $this->createPresenterSelect();
            $this->createTermSelect();
            $this->createTagSelect();

            $this->prepareRendering();
        } else {
            //Filter with dropdowm
            $this->uncat_video_courses = MyPresentations::filterHandler($this->filters);
            $this->loadUncat();
            $this->createPresenterSelect();
            //Filter
            $this->filters();
            $this->prepareRendering();
        }

    }

    public function createPresenterSelect()
    {
        //Init state for presenters dropdown
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            //User
            $videos = MyPresentations::my_uncat_video_course(app()->make('play_username'));
            foreach($videos as $video) {
                foreach ($video->presenters() as $presenter) {
                    $this->videopresenters[$presenter->username] = $presenter->name;
                }
            }

        } else {
            //Admin
            $vps = VideoPresenter::with('presenter')->get();
            foreach ($vps as $vp) {
                $this->videopresenters[$vp->presenter->username] = $vp->presenter->name;
            }
            $this->videopresenters = collect($this->videopresenters)->sort()->toArray();
        }
    }

    public function createTermSelect()
    {
        //Init state for Semester dropdown
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            //Users not used

        } else {
            //Admin
            $vss = VideoCourse::with('course')->get();
            foreach ($vss as $term) {
                if (!in_array($term->course->semester . $term->course->year, $this->videoterms)) {
                    $this->videoterms[] = $term->course->semester . $term->course->year;
                }
            }
            $this->videoterms = collect($this->videoterms)->sort()->toArray();
        }
    }

    public function createTagSelect()
    {
        //Init state for Tag dropdown
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            //Users not used

        } else {
            //Admin
            $vts = VideoTag::with('tag')->get();
            foreach ($vts as $vt) {
                if (!in_array($vt->tag->name, $this->videotags)) {
                    $this->videotags[] = $vt->tag->name;
                }
            }
            $this->videotags = collect($this->videotags)->sort()->toArray();
        }
    }

    public function updatedFilterTerm()
    {
        //Prepare
        $filterTerm = '%' . $this->filterTerm . '%';
        $this->searchTerm = $filterTerm;

        //Filters presentations through text input
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {

            //Not administrator
            $this->uncat_video_courses = MyPresentations::my_uncat_video_course(app()->make('play_username'), $filterTerm);

            //Count presentations
            $this->countUncatPresentations($this->uncat_video_courses);

        } else {

            //Administrator
            $this->admin = true;
            $this->uncat_video_courses = MyPresentations::unfiltered_uncat_video_course($this->filters, $filterTerm);

            //Count presentations
            $this->countUncatPresentations($this->uncat_video_courses);
        }

        //Querystring
        $this->filters['filterTerm'] = Arr::wrap($this->filterTerm);
        $this->filters();

        //Render filtered collection
        $this->loadUncat();
    }

    public function loadUncat()
    {
        $visibility = new VisibilityFilter;
        $this->uncat_videos = $visibility->filter($this->uncat_video_courses);
        $this->stats($this->uncat_videos);
    }

    public function checkAll(VisibilityFilter $visibility)
    {
        $this->allChecked = !$this->allChecked;

        if($this->allChecked) {
            $this->checked_videos = $visibility->filter($this->uncat_video_courses)->pluck('id')->toArray();
        } else {
            $this->checked_videos = [];
        }
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

    public function hydrate()
    {
        $this->loadUncat();
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
