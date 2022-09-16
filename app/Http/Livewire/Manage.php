<?php

namespace App\Http\Livewire;

use App\CourseadminPermission;
use App\CoursePermissions;
use App\CoursesettingsPermissions;
use App\CoursesettingsUsers;
use App\IndividualPermission;
use App\Presenter;
use App\Services\Filters\VisibilityFilter;
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
    public $filterswitch, $manageview;
    public $filter_course, $filter_presenter, $filter_semester, $filter_tag;
    public $stats_playback = [], $stats_download = [];
    public $videoformat = '';
    public $searchTerm;
    protected $loadpresentations;
    protected $queryString = ['filterTerm'];

    /**
     * @throws BindingResolutionException
     */
    public function mount()
    {
        //Default settings
        $this->filterswitch = true;
        $this->uncat = false;
        $this->videoformat = Cookie::get('videoformat') ?? 'grid';
        $this->manageview = true;

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
    public function filters($videos)
    {
        //dd($this->video_courses);
        foreach ($videos as $video) {
            //Presenters
            foreach ($video->presenters() as $presenter) {
                if (!key_exists($presenter->username, $this->videopresenters)) {
                    $this->videopresenters[$presenter->username] = $presenter->name;
                }
            }

            //Terms
            foreach ($video->courses() as $term) {
                $key = $term->year . ($term->semester == 'VT' ? 1 : 2);
                if (!key_exists($key, $this->videoterms)) {
                    $this->videoterms[$key] = $term->semester . $term->year;
                }
            }
            //Tags
            foreach ($video->tags() as $tag) {
                if (!key_exists($tag->id, $this->videotags)) {
                    $this->videotags[$tag->id] = $tag->name;
                }
            }
        }

        // Sort filters
        //sort($this->videopresenters);
        sort($this->videotags);

        //Courses
        foreach ($this->video_courses as $vc) {
            if (!key_exists($vc->course->designation, $this->videocourses)) {
                $this->videocourses[$vc->course->designation] = (Lang::locale() == 'swe') ? $vc->course->name : $vc->course->name_en . ' (' .$vc->course->designation.')';
            }
        }
    }

    /**
     * @return void
     */
    public function filterToggle()
    {
        //Toggles the textfilter visibility
        $this->filterswitch = !$this->filterswitch;
    }

    /**
     * @throws BindingResolutionException
     */
    public function courseAdminManage()
    {
        //$this->updatedFilterTerm();
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
        //Load filters
        //Creates arrays for the filter functions
        $videos = Video::whereIn('id', $this->user_videos)
            ->orWhereIn('id', $this->individual_videos)
            ->orWhereIn('id', $this->courseadministrator)
            ->orWhereIn('id', $this->video_course_ids)
            ->latest('creation')->get();

        $this->filters($videos);

    }

    /**
     * @throws BindingResolutionException
     */
    public function filter()
    {
        $this->updatedFilterTerm();
    }

    /**
     * @throws BindingResolutionException
     */
    public function updatedPresenter($selected_presenter)
    {
        $this->filter_presenter = $selected_presenter;

        if (empty($selected_presenter)) {
            $this->courseAdminManage();
        } else {
            //Filters presenters
            $this->video_courses = [];

            $videos_collection = Video::with('video_course.course', 'video_presenter.presenter')
                ->whereHas('video_presenter.presenter', function ($query) use ($selected_presenter) {
                    $query->whereIn('username', $selected_presenter);
                })->pluck('id');

            $this->getVideoCourses($videos_collection);
        }

        $this->courseSettings($this->video_courses);

        //Uncategorized presentations
        $this->uncat_video_courses = UncatPresentations::my_uncat_video_course_presenter(app()->make('play_username'), $selected_presenter);
        $this->prepareRendering();

    }

    /**
     * @throws BindingResolutionException
     */
    public function updatedCourse($selected_course)
    {
        $this->filter_course = $selected_course;
        if (empty($selected_course)) {
            $this->courseAdminManage();
        } else {
            $this->courseAdminFilter();
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
                    ->whereHas('course', function ($query) use ($selected_course) {
                        $query->whereIn('designation', $selected_course);
                    })
                    ->groupBy('course_id')->orderBy('course_id', 'desc')->get();
            } else {
                $this->video_courses = VideoCourse::with('course')
                    ->whereHas('course', function ($query) use ($selected_course) {
                        $query->whereIn('designation', $selected_course);
                    })
                    ->groupBy('course_id')->orderBy('course_id', 'desc')->get();
            }

            $this->courseSettings($this->video_courses);
            $this->prepareFilter($this->video_courses);
        }
    }

    public function prepareFilter($video_courses)
    {
        $courselist = $video_courses->pluck('video_id')->toArray();

        $filtervideos = Video::whereIn('id', $courselist)->get();

        $this->reset('videopresenters');
        $this->filters($filtervideos);
    }

    /**
     * @throws BindingResolutionException
     */
    public function updatedSemester($selected_semester)
    {
        $this->filter_semester = $selected_semester;
        if (empty($selected_semester)) {
            $this->courseAdminManage();
        } else {
            $year = $term = [];
            foreach ($selected_semester as $semester) {
                $year[] = substr($semester, -4);
                $term[] = substr($semester, 0, 2);
            }
            $this->courseAdminFilter();
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
                    ->whereHas('course', function ($query) use ($term, $year) {
                        $query->whereIn('semester', $term)
                            ->whereIn('year', $year);
                    })
                    ->groupBy('course_id')->orderBy('course_id', 'desc')->get();
            } else {
                $this->video_courses = VideoCourse::with('course')
                    ->whereHas('course', function ($query) use ($term, $year) {
                        $query->whereIn('semester', $term)
                            ->whereIn('year', $year);
                    })
                    ->groupBy('course_id')->orderBy('course_id', 'desc')->get();
            }

            $this->courseSettings($this->video_courses);
        }
    }

    /**
     * @throws BindingResolutionException
     */
    public function updatedTag($selected_tag)
    {
        $this->filter_tag = $selected_tag;
        if (empty($selected_tag)) {
            $this->courseAdminManage();
        } else {
            //Filters tags
            $this->video_courses = [];

            $videos_collection = Video::with('video_tag.tag')
                ->whereHas('video_tag.tag', function ($query) use ($selected_tag) {
                    $query->whereIn('name', $selected_tag);
                })->pluck('id');
            $this->getVideoCourses($videos_collection);
        }

        $this->courseSettings($this->video_courses);

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
        $videos = Video::all();
        $this->filters($videos);
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

        //Load presentations
        if ($this->videos[$courseid] == null) {
            //Loads presentations
            $this->loadpresentations = new LoadPresentations();
            $this->videos[$courseid] = $visibility->filter($this->loadpresentations->queryTitle($courseid, $term));

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
                $this->loadpresentations = new LoadPresentations();
                $this->videos[$courseid] = $visibility->filter($this->loadpresentations->queryTitle($courseid, $term));

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
            $countpresentations = new LoadPresentations();
            $this->counter[$course->course_id] = $countpresentations->queryTitle($courseid, $this->searchTerm)->count();
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
}
