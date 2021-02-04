<?php

namespace App\Services\Header;

use App\Course;
use App\Presenter;
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
        $view->with('courses', $this->getActiveCourses());
        $view->with('hasmycourses', ($this->getUserCoursesWithVideos(app()->make('presenter') ?? 'dsv-dev@su.se')->count() > 0));
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
