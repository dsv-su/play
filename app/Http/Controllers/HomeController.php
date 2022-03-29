<?php

namespace App\Http\Controllers;

use App\ManualPresentation;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Filters\VisibilityFilter;
use App\System;
use App\Video;
use App\VideoPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(DaisyIntegration $daisy, VisibilityFilter $visibility)
    {

        $data['permissions'] = VideoPermission::all();
        $courses = [];
        //Seconds to hold cache
        $seconds = 3600;

        //For testing
        //Fake students
        if (in_array(app()->make('play_role'), ['Student1', 'Student2', 'Student3'])) {
            if (app()->make('play_role') == 'Student1') {
                $courses = [6442, 6841, 6761, 6837, 6703, 6839, 6708, 6838, 6769];
            } elseif (app()->make('play_role') == 'Student2') {
                $courses = [6817, 6644, 6737, 6661, 6816, 6835, 6780, 6626, 6656, 6748, 6604, 6684, 6819, 6595, 6852];
            } elseif (app()->make('play_role') == 'Student3') {
                $courses = [6798, 6799, 6760, 6778, 6828, 6796, 6719, 6720];
            } // End testing
        }
        elseif (App::environment('production') &&
            (app()->make('play_auth') == 'Student' && (app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Student'))) {
            // User is Student store courses in cache
            $courses = Cache::remember(app()->make('play_username'), $seconds, function () use ($daisy){
                return $daisy->getActiveStudentCourses(app()->make('play_username'));
            });

        }
        elseif (App::environment('production') &&
            (app()->make('play_auth') == 'Administrator' or app()->make('play_auth') == 'Courseadmin' or app()->make('play_auth') == 'Staff') &&
            (app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Staff')
        ) {
            // User is Employee store courses in cache
            $courses = Cache::remember(app()->make('play_username'), $seconds, function () use ($daisy){
                return $daisy->getActiveEmployeeCourses(app()->make('play_username'));
            });

        }

        if (!empty($courses)) {
            //My courses (tab 1)
            $data['my'] = $visibility->filter(Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($courses) {
                return $query->whereIn('course_id', $courses);
            })->latest('creation')->get());
            /*
            $data['mypaginated'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($courses) {
                return $query->whereIn('course_id', $courses);
            })->latest('creation')->Paginate(24, ['*'], 'my');
            $data['my'] = $visibility->filter($data['mypaginated']);
            */
        }

        // Active courses (current semester) store in cache
        $active_courses = Cache::remember(app()->make('play_username') . '_active', $seconds, function () use ($daisy){
            return $daisy->getActiveCourses();
        });

        //Active (tab2)
        $data['active'] = $visibility->filter(Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($active_courses) {
            return $query->whereIn('course_id', $active_courses);
        })->latest('creation')->take(24)->get());
        /*
        $data['activepaginated'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($active_courses) {
            return $query->whereIn('course_id', $active_courses);
        })->latest('creation')->Paginate(24, ['*'], 'active');
        $data['active'] = $visibility->filter($data['activepaginated']);
        */

        // All courses (tab 3)
        $data['latest'] = $visibility->filter(Video::with('category', 'video_course.course')->latest('creation')->take(24)->get());
        /*
        $data['allpaginated'] = Video::with('category', 'video_course.course')->latest('creation')->Paginate(24, ['*'], 'all');
        $data['latest'] = $visibility->filter($data['allpaginated']);
        */

        // Add placeholders for manual presentations that are currently processed
        $pending = ManualPresentation::where('user', app()->make('play_username'))->where('status', 'sent')->get();
        $data['upload'] = true;
        $data['pending'] = $pending;

        return view('home.index', $data);
    }

}
