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
use App\Services\Manage\LoadPresentations;
use App\Services\Manage\UncatPresentations;
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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Lang;
use Livewire\Component;

class Manage extends Component
{
    public $view;
    public $video_courses;
    public $uncat, $uncat_videos = [];
    public $uncat_video_courses;
    public $videos = [];
    public $contend = [];
    public $counter, $uncatcounter, $coursesetlist = [];
    public $individual_permissions, $playback_permissions;
    public $user_videos, $individual_videos, $courseadministrator, $video_course_ids;
    public $filter, $filterTerm;
    public $presenter, $course, $semester, $tag;
    public $videopresenters = [], $videoterms = [], $videocourses = [], $videotags = [];
    public $manageview;
    public $filter_course, $filter_presenter, $filter_semester, $filter_tag;
    public $stats_playback = [], $stats_download = [];
    public $videoformat = '';
    public $searchTerm;
    public $filters;
    public $presentations, $test;
    public $grid, $list, $table;

    protected $dropdownfilter;
    protected $loadpresentations;

    protected $queryString = ['filterTerm', 'presenter', 'course', 'semester', 'tag'];

    /**
     * @throws BindingResolutionException
     */
    public function mount()
    {
        //Default settings
        $this->view = 'courses';
        $this->uncat = false;
        $this->videoformat = Cookie::get('videoformat') ?? 'grid';
        $this->manageview = true;
        $dropdownfilter = new DropdownFilters;
        $this->filters = $dropdownfilter->handleUrlParams();
        $this->grid = 'grid';
        $this->list = 'list';
        $this->table = 'table';

        //Redirect depending on role
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            //CourseAdmin and Uploader
            if($this->containsOnlyNull($this->filters)) {
                $this->courseAdminManage();
            } else {
                dd('Hey');
            }

        } else {
            //Administrator
            if($this->containsOnlyNull($this->filters)) {
                $this->loadCourseList();
            } else {
                dd('Hey');
            }

        }
    }

    public function resetFilter()
    {
        $this->reset('videocourses');
        $this->reset('videopresenters');
        $this->reset('videoterms');
        $this->reset('videotags');
        //Redirect depending on role
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            //CourseAdmin and Uploader
            $this->courseAdminManage();
        } else {
            //Administrator
            $this->loadCourseList();
        }
    }

    /**
     * @param $videos
     * @return void
     */
    public function filters()
    {
        $videos = $this->presentations;

        $dropdownfilter = new DropdownFilters;

        list ($this->videocourses, $this->videoterms, $this->videopresenters, $this->videotags, $this->video_courses, $this->presentations) = $dropdownfilter->performFiltering(
            $videos, $this->filters['courses'], $this->filters['terms'], $this->filters['tags'], $this->filters['presenters']
        );

        //Sort the filter arrays
        $this->videopresenters = collect($this->videopresenters)->sort()->toArray();
        sort($this->videotags);
        $this->videocourses = collect($this->videocourses)->sort()->toArray();

        $this->prepareRendering();
    }

    /**
     * @throws BindingResolutionException
     */
    public function courseAdminManage()
    {
        //Load presentations and courses for present user
        $this->courseAdminFilter();

        //Uncat videos
        $this->uncat_video_courses = UncatPresentations::my_uncat_video_course(app()->make('play_username'));

        $this->video_courses = VideoCourse::with('course')
            ->whereIn('video_id', $this->user_videos)
            ->orWhereIn('video_id', $this->individual_videos)
            ->orWhereIn('video_id', $this->courseadministrator)
            ->orWhereIn('video_id', $this->video_course_ids)
            ->groupBy('course_id')
            ->orderBy('course_id', 'desc')
            ->get();

        $this->prepareRendering();

        //Creates arrays for the filter functions
        $this->presentations = Video::whereIn('id', $this->user_videos)
            ->orWhereIn('id', $this->individual_videos)
            ->orWhereIn('id', $this->courseadministrator)
            ->orWhereIn('id', $this->video_course_ids)
            ->latest('creation')->get();

        $this->filters();

    }

    /**
     * @throws BindingResolutionException
     */
    public function updatedPresenter($selected_presenter)
    {
        //Turn into array
        $selected_presenter = explode( ',', $selected_presenter);

        $this->filter_presenter = $selected_presenter;

        if (empty($selected_presenter)) {
            $this->courseAdminManage();
        } else {
            $this->filters['presenters'] = $selected_presenter;
            $this->filters();
        }

        //Uncategorized presentations
        $this->uncat_video_courses = UncatPresentations::my_uncat_video_course_presenter(app()->make('play_username'), $selected_presenter);
        $this->prepareRendering();

    }

    /**
     * @throws BindingResolutionException
     */
    public function updatedCourse($selected_course)
    {
        //Turn into array
        $selected_course = explode( ',', $selected_course);

        $this->filter_course = $selected_course;

        if (empty($selected_course)) {
            $this->courseAdminManage();
        } else {
            $this->filters['courses'] = $selected_course;
            $this->filters();
            //Disable uncat
            $this->uncatcounter = 0;
        }
    }

    /**
     * @throws BindingResolutionException
     */
    public function updatedSemester($selected_semester)
    {
        //Turn into array
        $selected_semester = explode( ',', $selected_semester);

        $this->filter_semester = $selected_semester;
        if (empty($selected_semester)) {
            $this->courseAdminManage();
        } else {
            $this->filters['terms'] = $selected_semester;
            $this->filters();
        }
    }

    /**
     * @throws BindingResolutionException
     */
    public function updatedTag($selected_tag)
    {
        //Turn into array
        $selected_tag = explode( ',', $selected_tag);

        $this->filter_tag = $selected_tag;
        if (empty($selected_tag)) {
            $this->courseAdminManage();
        } else {
            $this->filters['tags'] = $selected_tag;
            $this->filters();
        }

        //Uncategorized presentations
        $this->uncat_video_courses = UncatPresentations::my_uncat_video_course_tag(app()->make('play_username'), $selected_tag);
        $this->prepareRendering();
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

        //Categorized presentations
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {

            //Collection of ids depending on set permissions and role Courseadmin, Uploader or Staff
            $this->courseAdminFilter();

            //Filter all presentations depending on user
            $this->video_courses = [];
            $videos_collection = Video::whereIn('id', $this->user_videos)
                ->orWhereIn('id', $this->individual_videos)
                ->orWhereIn('id', $this->courseadministrator)
                ->orWhereIn('id', $this->video_course_ids)
                ->pluck('id')->toArray();

            //Filter after video title
            $videos_match_title = Video::whereIn('id', $videos_collection)
                ->where('title', 'LIKE', $filterTerm)
                ->pluck('id')->toArray();

            $video_course_ids = VideoCourse::whereIn('video_id', $videos_collection)->distinct()->pluck('course_id');

            //Filter course specific attributes
            $video_course_courses = VideoCourse::with('course')
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

            //Filter after Presenters
            $video_course_presenters = VideoCourse::with('course', 'video.video_presenter.presenter')
                ->whereIn('course_id', $video_course_ids)
                ->whereHas('video.video_presenter.presenter', function ($query) use ($filterTerm) {
                    $query->where('username', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm);
                })
                ->pluck('course_id');
            //Filter after Tags
            $video_course_tags = VideoCourse::with('video.video_tag.tag')
                ->whereIn('course_id', $video_course_ids)
                ->WhereHas('video.video_tag.tag', function ($query) use ($filterTerm) {
                    $query->where('id', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm);
                })
                ->pluck('course_id');

            //Create public course list
            $this->video_courses = VideoCourse::whereIn('course_id', $video_course_courses)
                ->orWhereIn('course_id', $video_course_presenters)
                ->orWhereIn('course_id', $video_course_tags)
                ->orWhereIn('video_id', $videos_match_title)
                ->groupBy('course_id')
                ->orderBy('course_id', 'desc')
                ->get();

        } else {
            //Administrators
            $this->video_courses = VideoCourse::with('course', 'video.video_tag.tag', 'video.video_presenter.presenter')
                ->whereHas('Course', function ($query) use ($filterTerm) {
                    $query->where('id', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm)->orWhere('name_en', 'like', $filterTerm)
                        ->orWhere('designation', 'LIKE', $filterTerm)
                        ->orWhere('semester', 'LIKE', $filterTerm)
                        ->orWhere('year', 'LIKE', $filterTerm);
                })
                ->orWhereHas('video.video_presenter.presenter', function ($query) use ($filterTerm) {
                    $query->where('username', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm);
                })
                ->orWhereHas('video.video_tag.tag', function ($query) use ($filterTerm) {
                    $query->where('id', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm);
                })
                ->orWhereHas('video', function ($query) use ($filterTerm) {
                    $query->where('title', 'LIKE', $filterTerm)
                        ->orwhere('title_en','LIKE', $filterTerm);
                })
                ->groupBy('course_id')->orderBy('course_id', 'desc')->get();
        }

        $this->courseSettings($this->video_courses);
        $this->countPresentations($this->video_courses);

    }

    /**
     * @return void
     */
    public function prepareRendering()
    {
        $this->collapseAll($this->video_courses);
        $this->countPresentations($this->video_courses);
        $this->countUncatPresentations($this->uncat_video_courses);
        $this->courseSettings($this->video_courses);
    }

    /**
     * @return void
     */
    public function loadCourseList()
    {
        //Uncat videos
        $this->uncat_video_courses = UncatPresentations::unfiltered_uncat_video_course();

        $this->video_courses = VideoCourse::with('course', 'video.video_presenter.presenter')->groupBy('course_id')->orderBy('course_id', 'desc')->get();
        $this->prepareRendering();
        //Load filters
        //Creates arrays for the filter functions
        $this->presentations = Video::all();
        $this->filters($this->presentations);
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
        $term = $this->searchTerm;
        //dd($this->test[$courseid]);
        //Load presentations
        if ($this->videos[$courseid] == null) {
            //Loads presentations
            $this->loadpresentations = new LoadPresentations();
            $load = new DropdownFilters();
            if(!empty($term)) {
                $this->videos[$courseid] = $visibility->filter($this->loadpresentations->queryTitle($courseid, $term));
            } else {
                $this->videos[$courseid] = $visibility->filter($load->loadVideos($this->presentations, $courseid));
            }


        } else {
            $this->videos[$courseid] = [];
        }
        $this->stats($this->videos[$courseid]);
    }


    /**
     * @param VisibilityFilter $visibility
     * @return void
     */
    public function loadUncat(VisibilityFilter $visibility)
    {
        $this->uncat = !$this->uncat;
        $this->uncat_videos = $visibility->filter($this->uncat_video_courses);
        $this->stats($this->uncat_videos);
    }

    /**
     * @return void
     */
    public function hydrate()
    {
        $visibility = app(VisibilityFilter::class);
        $this->uncat_videos = $visibility->filter($this->uncat_video_courses);
        $this->courseSettings($this->video_courses);
        // Rehydrate already expanded courses since they're turned to array
        $term = $this->searchTerm;
        foreach ($this->videos as $courseid => $videos) {
            if (!empty($videos)) {
                if(!empty($term)) {
                    $this->loadpresentations = new LoadPresentations();
                    $this->videos[$courseid] = $visibility->filter($this->loadpresentations->queryTitle($courseid, $term));
                } else {
                    $load = new DropdownFilters();
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
     * @return void
     */
    public function countUncatPresentations($course)
    {
        $this->uncatcounter = $course->count();
    }

    /**
     * @param $courses
     * @return void
     */
    public function countPresentations($courses)
    {
        foreach ($courses as $course) {
            $courseid = $course->course_id;

            //Count presentations
            if($this->containsOnlyNull($this->filters)) {
                //Initial state or a textsearch is used
                $countpresentations = new LoadPresentations();
                $this->counter[$course->course_id] = $countpresentations->queryTitle($courseid, $this->searchTerm)->count();
            } else {
                //A dropdownfilter is used
                $load = new DropdownFilters();
                $this->counter[$course->course_id] = $load->loadVideos($this->presentations, $courseid)->count();
            }

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

    /**
     * @param Collection $videos_collection
     * @return void
     * @throws BindingResolutionException
     */
    private function getVideoCourses(Collection $videos_collection): void
    {
        /***
         * Returns a colletion of Video Courses from a collection of Videos
         * the returned collection is returned in the public variable
         * $this->video_courses
         */

        $video_course_ids = VideoCourse::whereIn('video_id', $videos_collection)->pluck('course_id');

        $courseids = [];
        foreach ($video_course_ids as $course_id) {
            if (!key_exists($course_id, $courseids)) {
                $courseids[$course_id] = $course_id;
            }
        }

        $this->video_courses = [];
        //Query depending on user
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            $this->video_courses = VideoCourse::with('course')
                ->whereHas('video', function ($query) {
                    $query->whereIn('video_id', $this->user_videos)
                        ->orWhereIn('video_id', $this->individual_videos)
                        ->orWhereIn('video_id', $this->courseadministrator)
                        ->orWhereIn('video_id', $this->video_course_ids);
                })
                ->whereIn('course_id', $courseids)
                ->groupBy('course_id')->orderBy('course_id', 'desc')->get();
        } else {
            $this->video_courses = VideoCourse::with('course')
                ->whereIn('course_id', $courseids)
                ->groupBy('course_id')->orderBy('course_id', 'desc')->get();
        }
    }

    private function getVideos(Collection $video_courses_collection, $presenter = null)
    {
        /***
         * Returns a colletion of Videos from a collection of Video_Courses
         */
        $courselist = $video_courses_collection->pluck('course_id')->toArray();
        $getvideos = new LoadPresentations();
        foreach ($courselist as $course) {
                $videos[] = $getvideos->queryTitle($course, $presenter)->pluck('id')->toArray();
            }
        return collect($videos ?? [])->flatten(1)->toArray();
    }

    private function containsOnlyNull($filterarray)
    {
        return empty(array_filter($filterarray, function ($a) { return $a != null;}));
    }
}
