<?php

namespace App\Http\Controllers;

use App\IndividualPermission;
use App\ManualPresentation;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Filters\VisibilityFilter;
use App\Services\Student\StudentProfile;
use App\Video;
use App\VideoPermission;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    public function index(DaisyIntegration $daisy, VisibilityFilter $visibility)
    {
        $data['permissions'] = VideoPermission::all();

        //Seconds to hold cache
        $seconds = 3600;

        //If user is student
        $student = new StudentProfile($daisy, $seconds);
        $courses = $student->Student();

        //Retrive presentations with individual permissions set
        $individual_videos = IndividualPermission::where('username', app()->make('play_username'))->pluck('video_id')->toArray();

        if (App::environment('production') &&
            (app()->make('play_auth') == 'Administrator' or app()->make('play_auth') == 'Courseadmin' or app()->make('play_auth') == 'Staff') &&
            (app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Staff')
        )
        {
            // User is Employee store courses in cache
            $courses = Cache::remember(app()->make('play_username'), $seconds, function () use ($daisy){
                if($lookup_course = $daisy->getActiveEmployeeCourses(app()->make('play_username'))) {
                    return $lookup_course;
                } else {
                    return [];
                }
            });
        }

        if (!empty($courses) or !empty($individual_videos)) {
            //My courses/presentations

            $data['mypaginated'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($courses) {
                return $query->whereIn('course_id', $courses);
            })
                ->orWhereIn('id', $individual_videos)
                ->latest('creation')->fastPaginate(24, ['*'], 'my')->onEachSide(1);
            $data['my'] = $visibility->filter($data['mypaginated']);
        }

        // HT2022 Active courses store in cache
        $active_courses_ht = Cache::remember(app()->make('play_username') . '_active_ht', $seconds, function () use ($daisy){
            return $daisy->getActiveCoursesHT();
        });
        $data['activepaginated_ht'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($active_courses_ht) {
            return $query->whereIn('course_id', $active_courses_ht);
        })->latest('creation')->fastPaginate(24, ['*'], 'active_ht')->onEachSide(1);
        $data['active_ht'] = $visibility->filter($data['activepaginated_ht']);

        // VT2022 Active courses store in cache
        $active_courses_vt = Cache::remember(app()->make('play_username') . '_active_vt', $seconds, function () use ($daisy){
            return $daisy->getActiveCoursesVT();
        });
        $data['activepaginated_vt'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($active_courses_vt) {
            return $query->whereIn('course_id', $active_courses_vt);
        })->latest('creation')->fastPaginate(24, ['*'], 'active_vt')->onEachSide(1);
        $data['active_vt'] = $visibility->filter($data['activepaginated_vt']);


        // All courses (tab 3)
        //$data['latest'] = $visibility->filter(Video::with('category', 'video_course.course')->latest('creation')->take(100)->get())->take(24);
        $data['allpaginated'] = Video::with('category', 'video_course.course')->latest('creation')->fastPaginate(24, ['*'], 'all')->onEachSide(1);
        $data['latest'] = $visibility->filter($data['allpaginated']);

        // Add placeholders for manual presentations that are currently processed
        $pending = ManualPresentation::where('user', app()->make('play_username'))->where('status', 'sent')->latest('created')->get();

        $data['upload'] = true;
        $data['pending'] = $pending;

        return view('home.index', $data);
    }

}
