<?php

namespace App\Http\Livewire;

use App\Course;
use App\CourseadminPermission;
use App\CoursePermissions;
use App\CoursesettingsPermissions;
use App\CoursesettingsUsers;
use App\IndividualPermission;
use App\Presenter;
use App\Services\Filters\VisibilityFilter;
use App\Services\Manage\DropdownFilters;
use App\Services\Manage\InitFilters;
use App\Tag;
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
    public $page, $admin, $show_course_list;
    public $checkAll, $checked_videos, $allChecked;
    public $presentations = [], $presentations_by_courseid;
    public $adminInit;

    protected $dropdownfilter;
    protected $search_query, $user_collection = [];
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
        $this->show_course_list = true;
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
        $qs = true;
        foreach(array_filter($this->filters) as $filter => $value) {
            if($filter == 'filterTerm' && !$this->IsNullOrEmptyString($value)) {
                $qs = false;
            }
            if($filter != 'FilterTerm') return false;
        }
        if(!$qs) {
            return false;
        } else {
            return true;
        }

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
        $videos = $this->search_query;

        if(count($this->search_query ?? []) == count($this->user_collection ?? [])) {
            $uc = $this->user_collection;
        } else {
            $uc = [];
        }

        //Check filters
        if($this->admin && !$this->checkActiveFilter() && $this->IsNullOrEmptyString($this->searchTerm)) {

            //Init state
            $this->adminInit = true;
            $this->createAdminSelect();

        } else {
            $this->adminInit = false;

            //Filter
            $dropdownfilter = new DropdownFilters;

            list ($this->videoterms, $this->videopresenters, $this->videotags, $this->video_courses, $this->presentations, $this->presentations_by_courseid) = $dropdownfilter->performFiltering(
                $videos, $uc, $this->filters['course'], $this->filters['term'], $this->filters['tag'], $this->filters['presenter'], $this->filters['filterTerm']
            );

        }

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

            //Pass collection
            $this->user_collection = $videos_collection;

            $video_course_ids = VideoCourse::select('course_id')->whereIn('video_id', $videos_collection)->distinct()->pluck('course_id');

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

            $this->search_query = Video::select('id')->with('video_course.course', 'video_tag.tag', 'video_presenter.presenter')
                ->whereIn('id', $videos_collection)
                ->WhereIn('id', $videos_match_title)
                ->orWhereIn('id', $video_course_presenters)
                ->orWhereIn('id', $video_course_tags)
                ->get();

        } else {
            //Administrators
            $this->admin = true;

            //Check filters
            if(!$this->checkActiveFilter() && $this->IsNullOrEmptyString($filterTerm)) {
                //Init
                $this->video_courses = VideoCourse::select('id','course_id')->groupBy('course_id')->distinct()->with('course','video.video_tag.tag')->orderBy('course_id', 'desc')->get();

                //Disable courselist
                //$this->show_course_list = false;


            } else {
                //Show course list
                $this->show_course_list = true;

                //Filter
                $videos_collection = Video::select('id')->pluck('id')->toArray();
                //Pass collection
                $this->user_collection = $videos_collection;

                //Filter after video title or description
                $videos_match_title = Video::select(['id', 'title', 'title_en', 'description'])->where('title', 'LIKE', $filterTerm)
                    ->orwhere('title_en', 'LIKE', $filterTerm)
                    ->orWhere('description', 'LIKE', $filterTerm)
                    ->pluck('id')->toArray();

                //Filter after Presenters
                $video_course_presenters = DB::table('presenters')
                    ->join('video_presenters', 'presenters.id', '=', 'video_presenters.presenter_id')
                    ->join('videos', 'video_presenters.video_id', '=', 'videos.id')
                    ->select('videos.id','presenters.username', 'presenters.name')
                    ->where('username', 'LIKE', $filterTerm)
                    ->orwhere('name', 'LIKE', $filterTerm)
                    ->pluck('id');

                //Filter after Tags
                $video_course_tags = DB::table('tags')
                    ->join('video_tags', 'tags.id', '=', 'video_tags.tag_id')
                    ->join('videos', 'video_tags.video_id', '=', 'videos.id')
                    ->select('videos.id', 'tags.name')
                    ->where('name', 'LIKE', $filterTerm)
                    ->pluck('id');

                $this->search_query = Video::select('id')->with('video_course.course', 'video_tag.tag', 'video_presenter.presenter')
                    ->whereIn('id', $videos_match_title)
                    ->orWhereIn('id', $video_course_presenters)
                    ->orWhereIn('id', $video_course_tags)
                    ->get();
                //end filter
            }



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
            $videocourses = VideoCourse::with('course')
                ->groupBy('course_id')
                ->orderBy('course_id', 'desc')
                ->get();
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

    public function createAdminSelect()
    {
        //Dropdowns
        $vcs = VideoCourse::with([
            'video' => function($query) {
                $query->select('id');
            },
            'video.video_tag' =>function($query) {
                $query->select('id', 'video_id', 'tag_id');
            },
            'video.video_tag.tag' => function($query) {
                $query->select('id','name');
            },
            'video.video_presenter' => function($query) {
                $query->select('id', 'video_id', 'presenter_id');
            },
            'video.video_presenter.presenter' => function($query) {
                $query->select('id','username', 'name');
            },
            'course' => function($query) {
                $query->select('id', 'semester', 'year');
            }
        ])
            ->get();

        $this->presentations_by_courseid = [];
        foreach($vcs as $vc) {
            //Tags
            foreach($vc->video->video_tag as $vt) {
                if (!in_array($vt->tag->name, $this->videotags)) {
                    $this->videotags[] = $vt->tag->name;
                }
            }
            //Presenter
            foreach($vc->video->video_presenter as $vp) {
                if (!in_array($vp->presenter->username, $this->videopresenters)) {
                    $this->videopresenters[$vp->presenter->username] = $vp->presenter->name;
                }
            }
            //Semesters
            if (!in_array($vc->course->semester . $vc->course->year, $this->videoterms)) {
                $this->videoterms[] = $vc->course->semester . $vc->course->year;
            }
            //Group by courseid
            if (!in_array($vc->course_id, $this->presentations_by_courseid)) {
                $this->presentations_by_courseid[$vc->course_id][] = $vc->video_id;
            }
        }

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
            if($this->adminInit) {
                //Init state for admin
                $this->videos[$courseid] = $visibility->filter($load->loadVideosafterCoursid($courseid));
            } else {

                $this->videos[$courseid] = $visibility->filter($load->loadVideos($this->presentations, $courseid));
            }

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
        $this->createCourseSelect();
        // Rehydrate already expanded courses since they're turned to array

        foreach ($this->videos as $courseid => $videos) {

            if (!empty($videos)) {
                $load = new DropdownFilters();
                if($this->adminInit) {
                    $this->videos[$courseid] = $visibility->filter($load->loadVideosafterCoursid($courseid));
                } else {
                    $this->videos[$courseid] = $visibility->filter($load->loadVideos($this->presentations, $courseid));
                }

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
            if ($courseSettings = CoursesettingsPermissions::select('visibility','downloadable')->where('course_id', $course->course_id)->first()) {
                //Visibility
                $this->coursesetlist[$course->course_id]['visibility'] = $courseSettings->visibility;
                //Downloadable
                $this->coursesetlist[$course->course_id]['downloadable'] = $courseSettings->downloadable;
            }
            //Individual users
            $this->individual_permissions[$course->course_id] = CoursesettingsUsers::select('id')->where('course_id', $course->course_id)->count();
            //Group permissions
            $this->playback_permissions[$course->course_id] = CoursePermissions::select('id')->where('course_id', $course->course_id)->first();
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
            $this->counter[$course->course_id] = count($this->presentations_by_courseid[$course->course_id] ?? []);
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
            $this->stats_playback[$video['id']] = VideoStat::select('playback')->where('video_id', $video['id'])->pluck('playback')->first();
            //Download
            $this->stats_download[$video['id']] = VideoStat::select('download')->where('video_id', $video['id'])->pluck('download')->first();
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

    public function IsNullOrEmptyString($str): bool
    {
        return ($str === '%%' || trim($str) === '% %');
    }
}
