<?php

namespace App\Services\Header;

use App\Category;
use App\Course;
use App\Presenter;
use App\Services\AuthHandler;
use App\Services\Daisy\DaisyIntegration;
use App\VideoCourse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;


class CourseNav extends Model
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */

    public function compose(View $view)
    {
        //$view->with('nav_categories', $this->getCategory()); //For now disabled
        if(!app()->isDownForMaintenance()) {
            //Admin testing -> students
            if(in_array(app()->make('play_role'), [ 'Student1', 'Student2', 'Student3'] )) {
                if(app()->make('play_role') == 'Student1') {
                    $courses = [6761, 6837, 6703, 6839, 6708, 6838, 6769];
                }
                if(app()->make('play_role') == 'Student2') {
                    $courses = [6817,6644,6737,6661,6816,6835,6780,6626,6656,6748,6604,6684,6819,6595];
                }
                if(app()->make('play_role') == 'Student3') {
                    $courses = [6798,6799,6760,6778,6828,6796,6719,6720];
                }
                $view->with('designations', $this->getFakeStudentDesignation($courses));
                $view->with('semesters', $this->getfakeStudentSemesters($courses));
            }
            //If user is Student
            elseif(app()->make('play_role') == 'Student') {
                $view->with('designations', $this->getStudentDesignation(app()->make('play_username')));
                $view->with('semesters', $this->getStudentSemesters(app()->make('play_username')));
            }
            //If user is Employee
            elseif(App::environment('production') and (app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Staff')) {
                $view->with('designations', $this->getEmployeeDesignation(app()->make('play_username')));
                $view->with('semesters', $this->getEmployeeSemesters(app()->make('play_username')));
            }
            //If user is Admin or Dev-enviroment
            else {
                $view->with('designations', $this->getDesignation());
                $view->with('semesters', $this->getSemesters());
            }
            //$view->with('nav_courses', $this->getActiveCourses()); //To be removed
            //--> This should be refactores -> causes expensive db queries
            //$view->with('hasmycourses', ($this->getUserCoursesWithVideos($this->getUserName() ?? 'dsv-dev@su.se')->count() > 0));
            //<--
        }
    }

    private function getUserName(AuthHandler $authHandler)
    {
        $system = $authHandler;
        $system = $system->authorize();
        if($system->global->app_env == 'local') {
            return 'dsv-dev';
        }
        else {
            return $_SERVER['REMOTE_USER'];
        }
    }

    private function getCategory()
    {
        return Category::pluck('category_name')->take(6);
    }

    /************************************************************
     * For testing
     */
    private function getFakeStudentDesignation($courses)
    {
        return Course::whereIn('id', $courses)->take(6)->get()->mapWithKeys(function ($item) {
            //return [$item['designation'] => $item['designation']. ' '.$item['semester'].' '.$item['year']];
            return [$item['designation'] => $item['designation']];
        });
    }

    private function getFakeStudentSemesters($courses)
    {
        $course_segments = Course::whereIn('id', $courses)->distinct('year')->pluck('year')->take(3)->reverse();
        foreach($course_segments as $term) {
            $semester[] = 'VT'.$term;
            $semester[] = 'HT'.$term;
        }
        return $semester ?? '';
    }

    /***************************************************************
     *  end test
     */

    private function getStudentDesignation($username)
    {
        return Cache::remember($username . '_designation', $seconds = 3600, function () use($username) {
            $daisy = app(DaisyIntegration::class);
            return $daisy->getActiveStudentDesignations($username) ?? '';
        });
    }

    private function getStudentSemesters($username)
    {
        return Cache::remember($username . '_semesters', $seconds = 3600, function () use($username){
            $daisy = app(DaisyIntegration::class);
            $semester = [];
            if($courses = $daisy->getActiveStudentCourses($username)) {
                foreach ($courses as $courseid) {
                    $course = Course::find($courseid);
                    if ($course) {
                        $semester[] = $course->semester . $course->year;
                    }
                }
            }

            if (!empty($semester)) {
                return array_unique($semester);
            } else {
                return '';
            }
        });
    }

    private function getEmployeeDesignation($username)
    {
        return Cache::remember($username . '_designation', $seconds = 3600, function () use($username) {
            $daisy = app(DaisyIntegration::class);
            return $daisy->getActiveEmployeeDesignations($username) ?? '';
            //return array_slice($daisy->getActiveEmployeeDesignations($username), 0, 6);
        });
    }

    private function getEmployeeSemesters($username)
    {
        return Cache::remember($username . '_semesters', $seconds = 3600, function () use($username){
            $daisy = app(DaisyIntegration::class);
            $semesters = collect($daisy->getActiveEmployeeSemesters($username));
            $course_segments = $semesters->unique()->sortDesc();
            foreach($course_segments as $term) {
                if (substr($term, 4) == '1') {
                    $semester[] = 'VT' .substr($term,0,-1);
                } else {
                    $semester[] = 'HT'.substr($term,0,-1);
                }
            }
            return $semester ?? '';
        });
    }

    private function getDesignation()
    {
        $courses = VideoCourse::orderByDesc('created_at')->distinct('course_id')->take(6)->pluck('course_id');
        $designations = [];
        foreach ($courses as $course) {
            $course = Course::find($course);
            $designations[$course->designation] = $course->designation;
        }
        return $designations;
        /*
        return $course->mapWithKeys(function ($item) {
            return [$item['designation'] => $item['designation']];
        });*/
    }

    private function getSemesters()
    {
        //$courses = Course::distinct('year')->pluck('year')->sortDesc()->take(3);

        $courses = Course::all()->sortBy('created_at');
        $semester = [];
        foreach ($courses as $course) {
            if ($course->videos()->count()) {
                if ($course->semester == 'VT') {
                    $term = $course->year . '1';
                } else {
                    $term = $course->year . '2';
                }
                if (!in_array($term, $semester)) {
                    $semester[$term] = $course->semester . $course->year;
                }
            }
        }
        krsort($semester);


        return array_values(array_slice($semester, 0 ,6)) ?? '';
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
