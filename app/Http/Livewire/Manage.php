<?php

namespace App\Http\Livewire;

use App\CourseadminPermission;
use App\CoursePermissions;
use App\CoursesettingsPermissions;
use App\CoursesettingsUsers;
use App\IndividualPermission;
use App\Presenter;
use App\Services\Filters\VisibilityFilter;
use App\Video;
use App\VideoCourse;
use App\VideoPresenter;
use Livewire\Component;

class Manage extends Component
{
    public $video_courses;
    public $uncat, $uncat_videos = [];
    public $videos = [];
    public $contend = [];
    public $counter, $uncatcounter, $coursesetlist = [];
    public $individual_permissions, $playback_permissions;
    public $user_videos, $individual_videos, $courseadministrator, $video_course_ids;
    public $filter, $filterTerm;
    public $presenter, $course, $semester, $tag;
    public $videopresenters = [], $videoterms = [], $videocourses, $videotags = [];
    public $filterswitch;
    protected $queryString = ['filterTerm'];

    public function mount()
    {
        //Default settings
        $this->filterswitch = true;
        $this->uncat = false;

        //Redirect depending on role
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            //CourseAdmin and Uploader
            $this->courseAdminManage();
            //Load filters
            $this->filters();
        } else {
            //Administrator
            $this->loadCourseList();
        }

    }

    public function filters()
    {
        //Creates arrays for the filter functions
        $videos = Video::whereIn('id', $this->user_videos)
            ->orWhereIn('id', $this->individual_videos)
            ->orWhereIn('id', $this->courseadministrator)
            ->orWhereIn('id', $this->video_course_ids)
            ->latest('creation')->get();

        foreach ($videos as $video) {
            //Presenters
            foreach ($video->presenters() as $presenter) {
                if (!key_exists($presenter->username, $this->videopresenters)) {
                    $this->videopresenters[$presenter->username] = $presenter->name;
                }
            }
            //Terms
            foreach ($video->courses() as $term) {
                if (!key_exists($term->semester.$term->year, $this->videoterms)) {
                    $this->videoterms[$term->semester.$term->year] = $term->semester.$term->year;
                }
            }
            //Tags
            foreach ($video->tags() as $tag) {
                if (!key_exists($tag->id, $this->videotags)) {
                    $this->videotags[$tag->id] = $tag->name;
                }
            }
        }
        //Courses
        $this->videocourses = $this->video_courses;


    }

    public function filterToggle()
    {
        //Toggles the textfilter visibility
        $this->filterswitch = !$this->filterswitch;
    }

    public function courseAdminManage()
    {
        //Default setting for courseadmin or uploader
        $this->coursAdminFilter();
        $this->video_courses = VideoCourse::with('course')
                        ->whereIn('video_id', $this->user_videos)
                        ->orWhereIn('video_id', $this->individual_videos)
                        ->orWhereIn('video_id', $this->courseadministrator)
                        ->orWhereIn('video_id', $this->video_course_ids)
                        ->groupBy('course_id')
                        ->orderBy('course_id', 'desc')
                        ->get();

        $this->prepareRendering();
    }

    public function filter()
    {
        $this->updatedFilterTerm();
    }

    public function updatedPresenter($selected_presenter)
    {
        if(empty($selected_presenter)) {
            $this->courseAdminManage();
        } else {
            //Filters presenters
            $videos_collection = [];
            $this->video_courses = [];

            $videos_collection = Video::with( 'video_course.course', 'video_presenter.presenter')
                ->whereHas('video_presenter.presenter', function ($query) use ($selected_presenter) {
                    $query->whereIn('username', $selected_presenter);
                })->pluck('id');

            $video_course_ids = VideoCourse::whereIn('video_id', $videos_collection)->pluck('course_id');

            $courseids = [];
            foreach ($video_course_ids as $course_id) {
                if (!key_exists($course_id, $courseids)) {
                    $courseids[$course_id] = $course_id;
                }
            }

            $this->video_courses = [];
            $this->video_courses = VideoCourse::with('course')
                ->whereHas('video', function ($query){
                    $query->whereIn('video_id', $this->user_videos)
                        ->orWhereIn('video_id', $this->individual_videos)
                        ->orWhereIn('video_id', $this->courseadministrator)
                        ->orWhereIn('video_id', $this->video_course_ids);
                })
                ->whereIn('course_id', $courseids)
                ->groupBy('course_id')->orderBy('course_id', 'desc')->get();
        }

        $this->courseSettings($this->video_courses);
    }

    public function updatedCourse($selected_course)
    {
        if(empty($selected_course)) {
            $this->courseAdminManage();
        } else {
            $this->coursAdminFilter();
            $this->video_courses = [];
            $this->video_courses = VideoCourse::with('course')
                    ->whereHas('video', function ($query) {
                        $query->whereIn('video_id', $this->user_videos)
                            ->orWhereIn('video_id', $this->individual_videos)
                            ->orWhereIn('video_id', $this->courseadministrator)
                            ->orWhereIn('video_id', $this->video_course_ids);
                    })
                    ->whereHas('course', function ($query) use ($selected_course) {
                        $query->whereIn('designation',  $selected_course);
                    })
                    ->groupBy('course_id')->orderBy('course_id', 'desc')->get();

            $this->courseSettings($this->video_courses);
        }
    }

    public function updatedSemester($selected_semester)
    {
        if(empty($selected_semester)) {
            $this->courseAdminManage();
        } else {
           foreach ($selected_semester as $semester) {
               $year[] = substr($semester, -4);
               $term[] = substr($semester, 0, 2);
           }
            $this->coursAdminFilter();
            $this->video_courses = [];
            $this->video_courses = VideoCourse::with('course')
                ->whereHas('video', function ($query) {
                    $query->whereIn('video_id', $this->user_videos)
                        ->orWhereIn('video_id', $this->individual_videos)
                        ->orWhereIn('video_id', $this->courseadministrator)
                        ->orWhereIn('video_id', $this->video_course_ids);
                })
                ->whereHas('course', function ($query) use ($term, $year) {
                    $query->whereIn('semester',  $term)
                        ->whereIn('year',  $year);
                })
                ->groupBy('course_id')->orderBy('course_id', 'desc')->get();

            $this->courseSettings($this->video_courses);
        }
    }

    public function updatedTag($selected_tag)
    {
        if(empty($selected_tag)) {
            $this->courseAdminManage();
        } else {
            //Filters tags
            $videos_collection = [];
            $this->video_courses = [];

            $videos_collection = Video::with( 'video_tag.tag')
                ->whereHas('video_tag.tag', function ($query) use ($selected_tag) {
                    $query->whereIn('name', $selected_tag);
                })->pluck('id');
            $video_course_ids = VideoCourse::whereIn('video_id', $videos_collection)->pluck('course_id');

            $courseids = [];
            foreach ($video_course_ids as $course_id) {
                if (!key_exists($course_id, $courseids)) {
                    $courseids[$course_id] = $course_id;
                }
            }

            $this->video_courses = [];
            $this->video_courses = VideoCourse::with('course')
                ->whereHas('video', function ($query){
                    $query->whereIn('video_id', $this->user_videos)
                        ->orWhereIn('video_id', $this->individual_videos)
                        ->orWhereIn('video_id', $this->courseadministrator)
                        ->orWhereIn('video_id', $this->video_course_ids);
                })
                ->whereIn('course_id', $courseids)
                ->groupBy('course_id')->orderBy('course_id', 'desc')->get();
        }

        $this->courseSettings($this->video_courses);
    }

    public function coursAdminFilter()
    {
        $videos_id = [];
        $user = Presenter::where('username', app()->make('play_username'))->first();
        $this->user_videos = $user_videos = VideoPresenter::where('presenter_id', $user->id ?? 0)->pluck('video_id');

        //Check if user is course administrator
        $this->courseadministrator = CourseadminPermission::where('username', app()->make('play_username'))->where('permission', 'delete')->pluck('video_id');

        //Check for individual permissions settings
        $this->individual_videos = IndividualPermission::where('username', app()->make('play_username'))->where(function ($query) {
            $query->where('permission', 'edit')
                ->orWhere('permission', 'delete');
        })->pluck('video_id');

        //Check for course individual settings
        if (count($course_user_admins = CoursesettingsUsers::where('username', app()->make('play_username'))->whereIn('permission', ['edit', 'delete'])->get()) >= 1) {
            foreach ($course_user_admins as $course_user_admin) {
                $videos_id[] = VideoCourse::where('course_id', $course_user_admin->course_id)->pluck('video_id');
            }
        }
        $this->video_course_ids = collect($videos_id)->flatten(1)->toArray();
    }

    public function updatedFilterTerm()
    {
        $filterTerm = '%' . $this->filterTerm . '%';
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {

            //Courseadmin, Uploader or Staff
            $this->coursAdminFilter();
            $videos_collection = [];
            $this->video_courses = [];
            $videos_collection = Video::whereIn('id', $this->user_videos)
                ->orWhereIn('id', $this->individual_videos)
                ->orWhereIn('id', $this->courseadministrator)
                ->orWhereIn('id', $this->video_course_ids)
                ->pluck('id');

            $video_course_ids = VideoCourse::whereIn('video_id', $videos_collection)->pluck('course_id');
            $video_course_courses = VideoCourse::with('course')
                ->whereIn('course_id', $video_course_ids)
                ->whereHas('course', function ($query) use ($filterTerm) {
                    $query->where('id', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm)->orWhere('name_en', 'like', $filterTerm)
                        ->orWhere('designation', 'LIKE', $filterTerm)
                        ->orWhere('semester', 'LIKE', $filterTerm)
                        ->orWhere('year', 'LIKE', $filterTerm);
                })
                ->pluck('course_id');
            $video_course_presenters = VideoCourse::with('course','video.video_presenter.presenter')
                ->whereIn('course_id', $video_course_ids)
                ->whereHas('video.video_presenter.presenter', function ($query) use ($filterTerm) {
                    $query->where('username', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm);
                })
                ->pluck('course_id');
            $video_course_tags = VideoCourse::with('video.video_tag.tag')
                ->whereIn('course_id', $video_course_ids)
                ->WhereHas('video.video_tag.tag', function($query) use ($filterTerm) {
                    $query->where('id', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm);
                })
                ->pluck('course_id');
            $this->video_courses = VideoCourse::whereIn('course_id', $video_course_courses)
                                            ->orWhereIn('course_id', $video_course_presenters)
                                            ->orWhereIn('course_id', $video_course_tags)
                                            ->groupBy('course_id')
                                            ->orderBy('course_id', 'desc')
                                            ->get();

       } else {
            //Administrators
            $this->video_courses = VideoCourse::with('course', 'video.video_tag.tag', 'video.video_presenter.presenter')
                ->whereHas('Course', function($query) use ($filterTerm) {
                    $query->where('id', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm)->orWhere('name_en', 'like', $filterTerm)
                        ->orWhere('designation', 'LIKE', $filterTerm)
                        ->orWhere('semester', 'LIKE', $filterTerm)
                        ->orWhere('year', 'LIKE', $filterTerm);
                })
                ->orWhereHas('video.video_presenter.presenter', function($query) use ($filterTerm) {
                    $query->where('username', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm);
                })
                ->orWhereHas('video.video_tag.tag', function($query) use ($filterTerm) {
                    $query->where('id', 'LIKE', $filterTerm)
                        ->orwhere('name', 'LIKE', $filterTerm);
                })
                ->groupBy('course_id')->orderBy('course_id', 'desc')->get();
        }


        $this->courseSettings($this->video_courses);
    }

    public function prepareRendering()
    {
        $this->collapseAll($this->video_courses);
        $this->countPresentations($this->video_courses);
        $this->countUncatPresentations();
        $this->courseSettings($this->video_courses);
    }

    public function loadCourseList()
    {
        $this->video_courses = VideoCourse::with('course','video.video_presenter.presenter')->groupBy('course_id')->orderBy('course_id', 'desc')->get();
        $this->prepareRendering();
    }

    public function loadCourseVideos(VisibilityFilter $visibility, $courseid)
    {
        //Toggle courselist
        $this->contend[$courseid] = !$this->contend[$courseid];

        //Load presentations
        if($this->videos[$courseid] == null) {
            $this->videos[$courseid] = $visibility->filter(Video::whereHas('video_course.course', function($query) use($courseid){
                $query->where('course_id', $courseid);
            })->with('video_course.course','video_presenter.presenter')->get())->toArray();
        }

    }

    public function loadUncat(VisibilityFilter $visibility)
    {
        $this->uncat = !$this->uncat;
        $this->uncat_videos = $visibility->filter(Video::doesntHave('video_course')->get());
    }

    public function hydrate()
    {
        $visibility = app(VisibilityFilter::class);
        $this->uncat_videos = $visibility->filter(Video::doesntHave('video_course')->get());
        $this->courseSettings($this->video_courses);
    }


    public function courseSettings($courses)
    {
        foreach($courses as $course) {
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

    public function countUncatPresentations()
    {
        $this->uncatcounter = Video::doesntHave('video_course')->count();
    }

    public function countPresentations($courses)
    {
        foreach($courses as $course) {
            $courseid = $course->course_id;
            $this->counter[$course->course_id] = Video::whereHas('video_course.course', function($query) use($courseid){
                $query->where('course_id', $courseid);
            })->count();
        }
    }

    public function collapseAll($courses)
    {
        foreach($courses as $course) {
            $this->contend[$course->course_id] = false;
            $this->videos[$course->course_id] = [];
        }
    }

    public function render()
    {
        return view('livewire.manage');
    }
}
