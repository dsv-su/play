<?php

namespace App\Http\Controllers;

use App\IndividualPermission;
use App\ManualPresentation;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Filters\VisibilityFilter;
use App\Services\Pending\Pending;
use App\Services\Student\StudentProfile;
use App\Video;
use App\VideoPermission;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('redirect-links');
    }

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

        if (App::environment('production') && $this->staff())
        {
            // User is Employee store courses in cache
            $courses = Cache::remember(app()->make('play_username'), $seconds, function () use ($daisy){
                return $daisy->getActiveEmployeeCourses(app()->make('play_username')) ? : [];
            });
        }

        if (!empty($courses) or !empty($individual_videos)) {

            //My courses/presentations
            if ($this->administrator()) {
                //Administrator full visibility
                $data['mypaginated'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($courses) {
                    return $query->whereIn('course_id', $courses)->where('state', true);
                })
                    ->orWhereIn('id', $individual_videos)->where('state', true)
                    ->latest('creation')->Paginate(24, ['*'], 'my')->onEachSide(1);
            } else {
                //Non administrator restricted visibility
                $data['mypaginated'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($courses) {
                    return $query->whereIn('course_id', $courses)->where('visibility', true)->where('state', true);
                })
                    ->orWhereIn('id', $individual_videos)->where('state', true)
                    ->latest('creation')->Paginate(24, ['*'], 'my')->onEachSide(1);
            }

            //Filter
            $data['my'] = $visibility->filter($data['mypaginated']);
        }

        // HT2024 Active courses store in cache
        $active_courses_ht = Cache::remember(app()->make('play_username') . '_active_ht', $seconds, function () use ($daisy){
            return $daisy->getActiveCoursesHT();
        });

        // HT2023 Prevoius year courses store in cache
        $previous_courses_ht = Cache::remember(app()->make('play_username') . '_previous_ht', $seconds, function () use ($daisy){
            return $daisy->getPreviousYearCoursesHT();
        });

        if($this->administrator()) {
            //Administrator full visibility
            $data['activepaginated_ht'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($active_courses_ht) {
                return $query->whereIn('course_id', $active_courses_ht)->where('state', true);
            })->latest('creation')->fastPaginate(24, ['*'], 'active_ht')->onEachSide(1);

            if($previous_courses_ht ?? false) {
                $data['previouspaginated_ht'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($previous_courses_ht) {
                    return $query->whereIn('course_id', $previous_courses_ht)->where('state', true);
                })->latest('creation')->fastPaginate(24, ['*'], 'previous_ht')->onEachSide(1);
            }


        } else {
            //Non administrator restricted visibility
            $data['activepaginated_ht'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($active_courses_ht) {
                return $query->whereIn('course_id', $active_courses_ht)->where('visibility', true)->where('state', true);
            })->latest('creation')->fastPaginate(24, ['*'], 'active_ht')->onEachSide(1);

            if($previous_courses_ht ?? false) {
                $data['previouspaginated_ht'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($previous_courses_ht) {
                    return $query->whereIn('course_id', $previous_courses_ht)->where('visibility', true)->where('state', true);
                })->latest('creation')->fastPaginate(24, ['*'], 'previous_ht')->onEachSide(1);
            }
        }

        //Filter
        $data['active_ht'] = $visibility->filter($data['activepaginated_ht']);
        if($data['previouspaginated_ht'] ?? false) {
            $data['previous_ht'] = $visibility->filter($data['previouspaginated_ht']);
        }


        // VT2024 Active courses store in cache
        $active_courses_vt = Cache::remember(app()->make('play_username') . '_active_vt', $seconds, function () use ($daisy){
            return $daisy->getActiveCoursesVT();
        });

        if($this->administrator()) {
            //Administrator full visibility
            $data['activepaginated_vt'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($active_courses_vt) {
                return $query->whereIn('course_id', $active_courses_vt)->where('state', true);
            })->latest('creation')->fastPaginate(24, ['*'], 'active_vt')->onEachSide(1);
        } else {
            //Non administrator restricted visibility
            $data['activepaginated_vt'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($active_courses_vt) {
                return $query->whereIn('course_id', $active_courses_vt)->where('visibility', true)->where('state', true);
            })->latest('creation')->fastPaginate(24, ['*'], 'active_vt')->onEachSide(1);
        }

        //Filter
        $data['active_vt'] = $visibility->filter($data['activepaginated_vt']);

        // Studyadministration and All courses
        if($this->administrator()) {
            //Administrator full visibility
            $data['allpaginated'] = Video::with('category', 'video_course.course')->where('state', true)->latest('creation')->fastPaginate(24, ['*'], 'all')->onEachSide(1);
            $data['studyinfo'] = Video::with('category', 'video_course.course')->where('category_id', 2)->where('state', true)->latest('creation')->fastPaginate(24, ['*'], 'all')->onEachSide(1);
        } else {
            //Non administrator restricted visibility
            $data['allpaginated'] = Video::with('category', 'video_course.course')->where('visibility', true)->where('state', true)->latest('creation')->fastPaginate(24, ['*'], 'all')->onEachSide(1);
            $data['studyinfo'] = Video::with('category', 'video_course.course')->where('category_id', 2)->where('visibility', true)->where('state', true)->latest('creation')->fastPaginate(24, ['*'], 'all')->onEachSide(1);
        }

        //Filter
        $data['latest'] = $visibility->filter($data['allpaginated']);
        $data['studyinfo_filtered'] = $visibility->filter($data['studyinfo']);

        return view('home.index', $data);
    }

    public function staff()
    {
        if((app()->make('play_auth') == 'Administrator' or app()->make('play_auth') == 'Courseadmin' or app()->make('play_auth') == 'Staff') &&
            (app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Staff')){
            return true;
        }
        return false;
    }

    public function administrator()
    {
        if((app()->make('play_auth') == 'Administrator' and app()->make('play_role') == 'Administrator')) {
            return true;
        }
        return false;
    }

}
