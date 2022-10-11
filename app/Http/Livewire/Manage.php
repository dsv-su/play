<?php

namespace App\Http\Livewire;

use App\CourseadminPermission;
use App\CoursePermissions;
use App\CoursesettingsPermissions;
use App\CoursesettingsUsers;
use App\IndividualPermission;
use App\Presenter;
use App\Services\Filters\VisibilityFilter;
use App\Services\Manage\DropdownFilters;
use App\Services\Manage\InitFilters;
use App\Services\Manage\LoadPresentations;
use App\Video;
use App\VideoCourse;
use App\VideoPresenter;
use App\VideoStat;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Manage extends Component
{
    public $view;
    public $video_courses;
    public $uncat;
    public $videos = [];
    public $contend = [];
    public $counter, $coursesetlist = [];
    public $individual_permissions, $playback_permissions;
    public $user_videos, $individual_videos, $courseadministrator, $video_course_ids;
    public $filter, $filterTerm;
    public $presenter, $course, $term, $tag;
    public $videopresenters = [], $videoterms = [], $videocourses = [], $videotags = [];
    public $manageview;
    public $filter_course, $filter_presenter, $filter_term, $filter_tag;
    public $stats_playback = [], $stats_download = [];
    public $videoformat = '';
    public $searchTerm;
    public $filters;
    public $grid, $list, $table;
    public $page, $admin;
    public $checkAll, $checked_videos, $allChecked;

    public $presentations = [], $presentations_by_courseid;
    protected $dropdownfilter;
    protected $queryString = ['filterTerm', 'presenter', 'course', 'term', 'tag'];

    /**
     * @throws BindingResolutionException
     */
    public function mount($page)
    {
        //Redirect
        $this->page = $page;

        //Default settings
        $this->admin = false;
        $this->view = 'courses';
        $this->videoformat = Cookie::get('videoformat') ?? 'grid';
        $this->manageview = true;
        $this->allChecked = false;
        $dropdownfilter = new DropdownFilters;
        $this->filters = $dropdownfilter->handleUrlParams();
        $this->grid = 'grid';
        $this->list = 'list';
        $this->table = 'table';

        $this->updatedFilterTerm();
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
        $path = 'manage_n';

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
        $this->reset('videocourses');
        $this->reset('videopresenters');
        $this->reset('videoterms');
        $this->reset('videotags');
    }

    /**
     * @param $videos
     * @return void
     */
    public function filters()
    {
        $videos = $this->presentations;
        $dropdownfilter = new DropdownFilters;

        list ($this->videoterms, $this->videopresenters, $this->videotags, $this->video_courses, $this->presentations, $this->presentations_by_courseid) = $dropdownfilter->performFiltering(
            $videos, $this->filters['course'], $this->filters['term'], $this->filters['tag'], $this->filters['presenter']
        );

        //Sort the filter arrays
        $this->videopresenters = collect($this->videopresenters)->sort()->toArray();
        sort($this->videotags);
        krsort($this->videoterms);
        $this->injectToSession();
        $this->prepareRendering();
    }

    /**
     * @throws BindingResolutionException
     */
    public function courseAdminManage()
    {
        //Load presentations and courses for present user
        $this->courseAdminFilter();

        $this->video_courses = VideoCourse::with('course')
            ->whereIn('video_id', $this->user_videos)
            ->orWhereIn('video_id', $this->individual_videos)
            ->orWhereIn('video_id', $this->courseadministrator)
            ->orWhereIn('video_id', $this->video_course_ids)
            ->groupBy('course_id')
            ->orderBy('course_id', 'desc')
            ->get();

        //Creates arrays for the filter functions
        $this->presentations = Video::with('video_course')
            ->whereHas('video_course', function ($query) {
            $query->whereIn('video_id', $this->user_videos)
                ->orWhereIn('video_id', $this->individual_videos)
                ->orWhereIn('video_id', $this->courseadministrator)
                ->orWhereIn('video_id', $this->video_course_ids);
        })->latest('creation')->get();

        $this->filters();
        $this->prepareRendering();
    }

    public function filter()
    {
        $this->updatedFilterTerm();
    }

    /**
     * @throws BindingResolutionException
     */
    public function updatedPresenter($selected_presenter)
    {
        $this->presenter = $selected_presenter;

        $this->filter_presenter = $selected_presenter;
        $this->filters['presenter'] = $selected_presenter;

        $this->filters();

        return redirect(session('links')[0]);
    }

    /**
     * @throws BindingResolutionException
     */
    public function updatedCourse($selected_course)
    {
        $this->course = $selected_course;

        $this->filter_course = $selected_course;
        $this->filters['course'] = $selected_course;

        //$this->uncatcounter = 0;
        $this->filters();

        return redirect(session('links')[0]);

    }

    /**
     * @throws BindingResolutionException
     */
    public function updatedTerm($selected_term)
    {
        $this->term = $selected_term;

        $this->filter_term = $selected_term;
        $this->filters['term'] = $selected_term;

        $this->filters();

        return redirect(session('links')[0]);
    }

    /**
     * @throws BindingResolutionException
     */
    public function updatedTag($selected_tag)
    {
        $this->tag = $selected_tag;

        $this->filter_tag = $selected_tag;
        $this->filters['tag'] = $selected_tag;

        $this->filters();

        return redirect(session('links')[0]);
    }

    /**
     * @throws BindingResolutionException
     */
    public function courseAdminFilter()
    {
        $videos_id = [];
        $user = Presenter::where('username', app()->make('play_username'))->first();
        $this->user_videos = VideoPresenter::where('presenter_id', $user->id ?? 0)->pluck('video_id')->toArray();

        //Check if user is course administrator
        $this->courseadministrator = CourseadminPermission::where('username', app()->make('play_username'))
            ->where('permission', 'delete')
            ->pluck('video_id')
            ->toArray();

        //Check for individual permissions settings
        $this->individual_videos = IndividualPermission::where('username', app()->make('play_username'))->where(function ($query) {
            $query->where('permission', 'edit')
                ->orWhere('permission', 'delete');
        })->pluck('video_id')->toArray();

        //Check for course individual settings
        if (count($course_user_admins = CoursesettingsUsers::where('username', app()->make('play_username'))->whereIn('permission', ['edit', 'delete'])->get()) >= 1) {
            foreach ($course_user_admins as $course_user_admin) {
                $videos_id[] = VideoCourse::where('course_id', $course_user_admin->course_id)->pluck('video_id');
            }
        }
        $this->video_course_ids = collect($videos_id)->flatten(1)->toArray();
    }


    /**
     * @throws BindingResolutionException
     */
    public function updatedFilterTerm()
    {
        //Prepare
        $filterTerm = '%' . $this->filterTerm . '%';
        $this->searchTerm = $filterTerm;

        //Categorized presentations
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {

            //Collection of ids depending on set permissions and role Courseadmin, Uploader or Staff
            $this->courseAdminFilter();

            //Filter all presentations depending on user
            $this->video_courses = [];
            $videos_collection = Video::select('id')->whereIn('id', $this->user_videos)
                ->orWhereIn('id', $this->individual_videos)
                ->orWhereIn('id', $this->courseadministrator)
                ->orWhereIn('id', $this->video_course_ids)
                ->pluck('id')->toArray();

            $video_course_ids = VideoCourse::select('course_id')->whereIn('video_id', $videos_collection)->distinct()->pluck('course_id');

            //Filter course specific attributes
            $video_course_courses = VideoCourse::select('course_id')->with('course')
                ->whereIn('course_id', $video_course_ids)
                ->whereHas('course', function ($query) use ($filterTerm) {
                    $query->where('id', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm)->orWhere('name_en', 'like', $filterTerm)
                        ->orWhere('designation', 'LIKE', $filterTerm)
                        ->orWhere('semester', 'LIKE', $filterTerm)
                        ->orWhere('year', 'LIKE', $filterTerm);
                })
                ->distinct()
                ->pluck('course_id');

            //Filter after video title or description
            $videos_match_title = Video::whereIn('id', $videos_collection)
                ->where('title', 'LIKE', $filterTerm)
                ->orwhere('title_en', 'LIKE', $filterTerm)
                ->orWhere('description', 'LIKE', $filterTerm)
                ->pluck('id')->toArray();

            //Filter after Presenters
            $video_course_presenters = VideoCourse::select('course_id', 'video_id')->with('course', 'video.video_presenter.presenter')
                ->whereIn('course_id', $video_course_ids)
                ->whereHas('video.video_presenter.presenter', function ($query) use ($filterTerm) {
                    $query->where('username', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm);
                })
                ->pluck('video_id');

            //Filter after Tags
            $video_course_tags = VideoCourse::select('course_id', 'video_id')->with('video.video_tag.tag')
                ->whereIn('course_id', $video_course_ids)
                ->WhereHas('video.video_tag.tag', function ($query) use ($filterTerm) {
                    $query->where('id', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm);
                })
                ->pluck('video_id');

            //Create public course list
            $this->video_courses = VideoCourse::select('course_id', 'video_id')->whereIn('course_id', $video_course_courses)
                ->orWhereIn('video_id', $video_course_presenters)
                ->orWhereIn('video_id', $video_course_tags)
                ->orWhereIn('video_id', $videos_match_title)
                ->groupBy('course_id')
                ->orderBy('course_id', 'desc')
                ->get();

            $this->presentations = Video::select('id')->whereIn('id', $videos_collection)
                ->WhereIn('id', $videos_match_title)
                ->orWhereIn('id', $video_course_presenters)
                ->orWhereIn('id', $video_course_tags)
                ->get();

        } else {
            //Administrators
            $this->admin = true;
            
            $this->video_courses = VideoCourse::select('course_id')->with(['course' => function($query) {
                $query->select('id', 'name', 'designation', 'semester', 'year');
            }, 'video.video_tag.tag' => function($query) {
                $query->select('name');
            }, 'video.video_presenter.presenter' => function($query) {
                $query->select('username', 'name');
            }])
                ->whereHas('Course', function ($query) use ($filterTerm) {
                    $query->where('id', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm)->orWhere('name_en', 'LIKE', $filterTerm)
                        ->orWhere('designation', 'LIKE', $filterTerm)
                        ->orWhere('semester', 'LIKE', $filterTerm)
                        ->orWhere('year', 'LIKE', $filterTerm);
                })
                ->orWhereHas('video.video_presenter.presenter', function ($query) use ($filterTerm) {
                    $query->select('username', 'name')
                        ->where('username', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm);
                })
                ->orWhereHas('video.video_tag.tag', function ($query) use ($filterTerm) {
                    $query->select('name')
                        //->where('id', 'LIKE', $filterTerm)
                        ->where('name', 'LIKE', $filterTerm);
                })
                ->orWhereHas('video', function ($query) use ($filterTerm) {
                    $query->select('id', 'title', 'title_en', 'description')
                        ->where('id', 'LIKE', $filterTerm)
                        ->orwhere('title', 'LIKE', $filterTerm)
                        ->orwhere('title_en','LIKE', $filterTerm)
                        ->orWhere('description', 'LIKE', $filterTerm);
                })
                ->distinct()->groupBy('course_id')->orderBy('course_id', 'desc')->get();


                $videos_in_courses = VideoCourse::select('course_id', 'video_id')->whereIn('course_id', $this->video_courses->pluck('course_id'))->pluck('video_id')->toArray();
                $this->presentations = Video::select('id')->whereIn('id', $videos_in_courses)->with('video_course')->select('id')->get();

        }

        //Querystring
        $this->filters['filterTerm'] = Arr::wrap($this->filterTerm);
        $this->filters();

    }

    public function createCourseSelect()
    {
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            //CourseAdmin and Uploader
            $videocourses = VideoCourse::with('course')
                ->whereIn('video_id', $this->user_videos)
                ->orWhereIn('video_id', $this->individual_videos)
                ->orWhereIn('video_id', $this->courseadministrator)
                ->orWhereIn('video_id', $this->video_course_ids)
                ->groupBy('course_id')
                ->orderBy('course_id', 'desc')
                ->get();
        } else {
            //Administrator
            $videocourses = VideoCourse::with('course', 'video.video_presenter.presenter')->groupBy('course_id')->orderBy('course_id', 'desc')->get();
        }
        foreach($videocourses as $vc) {
            if(\Illuminate\Support\Facades\Lang::locale() == 'swe') {
                    $this->videocourses[$vc->course->designation] = $vc->course->designation. ' - '.$vc->course->name;
                } else {
                    $this->videocourses[$vc->course->designation] = $vc->course->designation. ' - '.$vc->course->name_en;
                    }
        }
        $this->videocourses = collect($this->videocourses)->sort()->toArray();
    }
    /**
     * @return void
     */
    public function prepareRendering()
    {
        $this->collapseAll($this->video_courses);
        $this->countPresentations($this->video_courses);
        $this->courseSettings($this->video_courses);
        $this->createCourseSelect();
    }

    /**
     * @param VisibilityFilter $visibility
     * @param $courseid
     * @return void
     */
    public function loadCourseVideos(VisibilityFilter $visibility, $courseid)
    {
        //Toggle courselist
        $this->contend[$courseid] = !$this->contend[$courseid];

        //Load presentations
        if ($this->videos[$courseid] == null) {
            //Loads presentations
            $load = new DropdownFilters();
            $this->videos[$courseid] = $visibility->filter($load->loadVideos($this->presentations, $courseid));
        } else {
            $this->videos[$courseid] = [];
        }
        $this->stats($this->videos[$courseid]);
    }

    public function checkAll(VisibilityFilter $visibility, $courseid)
    {
        $this->allChecked = !$this->allChecked;
        if($this->allChecked) {
            $load = new DropdownFilters();
            $this->checked_videos = $visibility->filter($load->loadVideos($this->presentations, $courseid))->pluck('id')->toArray();
        } else {
            $this->checked_videos = [];
        }
    }

    /**
     * @return void
     */
    public function hydrate()
    {
        $visibility = app(VisibilityFilter::class);
        $this->courseSettings($this->video_courses);
        $this->createCourseSelect($this->video_courses);
        // Rehydrate already expanded courses since they're turned to array
        foreach ($this->videos as $courseid => $videos) {

            if (!empty($videos)) {
                $load = new DropdownFilters();
                $this->videos[$courseid] = $visibility->filter($load->loadVideos($this->presentations, $courseid));
            }
        }
        $this->videoformat = Cookie::get('videoformat') ?? 'grid';
    }

    /**
     * @param $courses
     * @return void
     */
    public function courseSettings($courses)
    {
        foreach ($courses as $course) {
            if ($courseSettings = CoursesettingsPermissions::where('course_id', $course->course_id)->first()) {
                //Visibility
                $this->coursesetlist[$course->course_id]['visibility'] = $courseSettings->visibility;
                //Downloadable
                $this->coursesetlist[$course->course_id]['downloadable'] = $courseSettings->downloadable;
            }
            //Individual users
            $this->individual_permissions[$course->course_id] = CoursesettingsUsers::where('course_id', $course->course_id)->count();
            //Group permissions
            $this->playback_permissions[$course->course_id] = CoursePermissions::where('course_id', $course->course_id)->first();
        }
    }

    /**
     * @param $courses
     * @return void
     */
    public function countPresentations($courses)
    {
        foreach ($courses as $course) {
            //Count presentations
            $this->counter[$course->course_id] = count($this->presentations_by_courseid[$course->course_id]);
        }
    }

    /**
     * @param $courses
     * @return void
     */
    public function collapseAll($courses)
    {
        foreach ($courses as $course) {
            $this->contend[$course->course_id] = false;
            $this->videos[$course->course_id] = [];
        }
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

    /**
     * @param $videoformat
     * @return Application|RedirectResponse|Redirector
     */
    public function videoformat($videoformat)
    {
        Cookie::queue('videoformat', $videoformat, 999999999);
        $this->videoformat = $videoformat;
    }

    public function updatedVideoformat($videoformat)
    {
        Cookie::queue('videoformat', $videoformat, 999999999);
        $this->videoformat = $videoformat;
        //return redirect(request()->header('Referer'));
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.manage');
    }

    private function containsOnlyNull($filterarray)
    {
        return empty(array_filter($filterarray, function ($a) { return $a != null;}));
    }
}
