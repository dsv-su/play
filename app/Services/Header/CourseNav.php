<?php

namespace App\Services\Header;

use App\Category;
use App\Course;
use App\Presenter;
use App\Services\AuthHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;


class CourseNav extends Model
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */

    public function compose(View $view)
    {
        //$view->with('nav_categories', $this->getCategory()); //For now disabled
        $view->with('designations', $this->getDesignation());
        $view->with('semesters', $this->getSemesters());
        //$view->with('nav_courses', $this->getActiveCourses()); //To be removed
        //--> This should be refactores -> causes expensive db queries
        //$view->with('hasmycourses', ($this->getUserCoursesWithVideos($this->getUserName() ?? 'dsv-dev@su.se')->count() > 0));
        //<--
    }

    private function getUserName()
    {
        $system = new AuthHandler();
        $system = $system->authorize();
        if($system->global->app_env == 'local') {
            return 'dsv-dev';
        }
        else {
            return $_SERVER['eppn'];
        }
    }

    private function getCategory()
    {
        return Category::pluck('category_name')->take(6);
    }

    private function getDesignation()
    {
        return Course::pluck('designation')->sortByDesc('id')->take(6);
    }

    private function getSemesters()
    {
        $courses = Course::distinct('year')->pluck('year')->take(3);
        foreach($courses as $course) {
            $semester[] = 'VT '.$course;
            $semester[] = 'HT '.$course;
        }

        return $semester ?? '';
    }

    private function getActiveCourses()
    {
        $courses = Course::where('designation', '<>', '')->orderBy('designation')->get()->filter(function ($course) {
            return !$course->videos()->isEmpty();
        });
        return $courses->chunk(ceil($courses->count() / 3));
    }

    private function getUserCoursesWithVideos($username)
    {
        // Get all videos where the current user is a presenter
        $mycourses = Course::all();
        foreach ($mycourses as $key => $course) {
            $course->myvideos = $course->userVideos(Presenter::where('username', $username)->first());
            if ($course->myvideos->isEmpty()) {
                unset($mycourses[$key]);
            }
        }
        return $mycourses;
    }
}
