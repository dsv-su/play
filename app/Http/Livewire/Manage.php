<?php

namespace App\Http\Livewire;

use App\CoursePermissions;
use App\CoursesettingsPermissions;
use App\CoursesettingsUsers;
use App\Services\Filters\VisibilityFilter;
use App\Video;
use App\VideoCourse;
use Livewire\Component;

class Manage extends Component
{
    public $video_courses;
    public $uncat, $uncat_videos = [], $uncat_paginate;
    public $videos = [];
    public $contend = [];
    public $counter, $uncatcounter, $coursesetlist;
    public $individual_permissions, $playback_permissions;
    public $filterTerm;
    public $test;
    protected $queryString = ['filterTerm'];

    public function mount()
    {
        $this->loadCourseList();
        $this->uncat = false;
    }

    public function updatedFilterTerm()
    {
        $filterTerm = '%' . $this->filterTerm . '%';
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

        $this->courseSettings($this->video_courses);
    }

    public function loadCourseList()
    {
        $this->video_courses = VideoCourse::with('course')->groupBy('course_id')->orderBy('course_id', 'desc')->get();
        $this->collapseAll($this->video_courses);
        $this->countPresentations($this->video_courses);
        $this->countUncatPresentations();
        $this->courseSettings($this->video_courses);
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
        $this->uncat_paginate = Video::doesntHave('video_course')->get();
    }

    /*public function hydrate()
    {
        $visibility = app(VisibilityFilter::class);
        $this->uncat_videos = $visibility->filter(Video::doesntHave('video_course')->get());
        $this->courseSettings($this->video_courses);
    }*/


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
        $this->updatedFilterTerm();
        return view('livewire.manage');
    }
}
