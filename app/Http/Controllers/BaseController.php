<?php

namespace App\Http\Controllers;

use App\Course;
use App\Services\ConfigurationHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    public function __construct()
    {
        //Initiate system
        $init = new ConfigurationHandler();
        $init->check_system();

        // If the environment is local
        if (app()->environment('local')) {
            $user = 'För Efternamn';
        } else {
            $user = $_SERVER['displayName'];
        }
        $courses = $this->getActiveCourses();

        View::share('play_user', $user);
        View::share('courses', $courses);
    }

    private function getActiveCourses() {
        $courses = Course::where('designation', '<>', '')->orderBy('designation')->get()->filter(function ($course) {
            return !$course->videos()->isEmpty();
        });
        return $courses->chunk(ceil($courses->count() / 3));
    }
}
