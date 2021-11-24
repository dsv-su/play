<?php

namespace App\Http\Controllers;

use App\Course;
use App\CoursePermissions;
use App\CoursesettingsPermissions;
use App\CoursesettingsUsers;
use App\Permission;
use App\Services\Daisy\DaisyAPI;
use App\VideoCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ManageCourseSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('course-admin');
    }

    public function index()
    {
        $coursesetlist = [];
        $individual_permissions = [];
        $playback_permissions = [];
        $presentations = [];

        $daisy = new DaisyAPI();
        //Get user DaisyID
        $daisyPersonID = $daisy->getDaisyPersonId(app()->make('play_username'));

        //Get all courses where user is courseadmin
        if($courses = $daisy->getDaisyEmployeeResponsibleCourses($daisyPersonID)) {
            //dd($courses);
            /*
             * [0] Coursename swedish
             * [1] Coursename english
             * [2] CourseID
             * [3] Semester in format year XXXX and term 1 spring(VT) 2 fall(HT) - e.g. 20212
             * [4] Designation
             * [5] Courseadmin true/false
             */

            //Group after year
            if(App::currentLocale() == 'swe') {
                //Courselist in Swedish
                $start = 0;
                foreach ($courses as $course) {
                    if($start == 0) {
                        $year = substr($course[3], 0, 4);
                    }
                    if ($year == substr($course[3], 0, 4)) {
                        if(substr($course[3], 4) == '1') {
                            $courselist[$year][$course[2]] = 'VT' . substr($course[3], 0, 4) . ' ' . $course[4] . ' - ' . $course[0] . ' (' . 'KursID: ' . ' ' . $course[2] . ')';
                        } else {
                            $courselist[$year][$course[2]] = 'HT' . substr($course[3], 0, 4) . ' ' . $course[4] . ' - ' . $course[0] . ' (' . 'KursID: '. ' '. $course[2] . ')';
                        }
                        $start++;
                    }
                    else {
                        $start = 0;
                    }
                    //Check settings for course
                    if($courseSettings = CoursesettingsPermissions::where('course_id', $course[2])->first()) {
                        //Visibility
                        $coursesetlist[$course[2]]['visibility'] = $courseSettings->visibility;
                        //Downloadable
                        $coursesetlist[$course[2]]['downloadable'] = $courseSettings->downloadable;
                        //Individual users
                        if($ipermissions = CoursesettingsUsers::where('course_id', $course[2])->count()){
                            $individual_permissions[$course[2]] = $ipermissions;
                        }
                        //Group permissions
                        $gpermission = CoursePermissions::where('course_id', $course[2])->first();
                        $playback_permissions[$course[2]] = $gpermission;
                        //Presentations
                        $number_presentations = VideoCourse::where('course_id', $course[2])->count();
                        $presentations[$course[2]] = $number_presentations;
                    }


                }
            }
            else {
                //Courselist in english
                $start = 0;
                foreach ($courses as $course) {
                    if($start == 0) {
                        $year = substr($course[3], 0, 4);
                    }
                    if ($year == substr($course[3], 0, 4)) {
                        if(substr($course[3], 4) == '1') {
                            $courselist[$year][$course[2]] = 'VT' . substr($course[3], 0, 4) . ' ' . $course[4] . ' - ' . $course[1] . ' (' . 'CourseID:' . ' ' . $course[2] . ')';
                        }
                        else {
                            $courselist[$year][$course[2]] = 'HT' . substr($course[3], 0, 4) . ' ' . $course[4] . ' - ' . $course[1] . ' (' . 'CourseID:' . ' ' . $course[2] . ')';
                        }
                        $start++;
                    }
                    else {
                        $start = 0;
                    }
                    //Check settings for course
                    if($courseSettings = CoursesettingsPermissions::where('course_id', $course[2])->first()) {
                        //Visibility
                        $coursesetlist[$course[2]]['visibility'] = $courseSettings->visibility;
                        //Downloadable
                        $coursesetlist[$course[2]]['downloadable'] = $courseSettings->downloadable;
                        //Individual users
                        if($ipermissions = CoursesettingsUsers::where('course_id', $course[2])->count()){
                            $individual_permissions[$course[2]] = $ipermissions;
                        }
                        //Group permissions
                        $gpermission = CoursePermissions::where('course_id', $course[2])->first();
                        $playback_permissions[$course[2]] = $gpermission;
                        //Presentations
                        $number_presentations = VideoCourse::where('course_id', $course[2])->count();
                        $presentations[$course[2]] = $number_presentations;
                    }

                }
            }

        }
        else {
            return 'Not a courseadmin';
        }

        return view('manage.manage_course', compact('courselist', 'coursesetlist', 'individual_permissions', 'playback_permissions','presentations'));

    }

    public function edit($courseid)
    {
        $course = Course::find($courseid);
        $individual_permissions = [];
        $coursesettings_permissions = CoursesettingsPermissions::where('course_id', $courseid)->first();
        //Individual user settings
        if($ipermissions = CoursesettingsUsers::where('course_id', $courseid)->get()){
            $individual_permissions = $ipermissions;
        }
        //Group permissions
        $permissions = Permission::all();

        return view('manage.editcourse', compact('course', 'coursesettings_permissions', 'individual_permissions', 'permissions'));
    }

    public function store($course_id, Request $request)
    {
        if ($request->isMethod('post')) {
            //dd($request->all());
            $coursesettings_permissions = CoursesettingsPermissions::firstOrNew(['course_id' => $course_id]);
            //Store
            $coursesettings_permissions->course_id = $course_id;
            //Visibility
            if($request->visibility) {
                $coursesettings_permissions->visibility = true;
            }
            else {
                $coursesettings_permissions->visibility = false;
            }
            //Downloadable
            if($request->downloadable) {
                $coursesettings_permissions->downloadable = true;
            }
            else {
                $coursesettings_permissions->downloadable = false;
            }

            //Update group permission for presentation
            if($coursePermission = CoursePermissions::where('course_id', $course_id)->first()) {
                //Exist
                $coursePermission->permission_id = $request->course_permission;
                if($request->course_permission == 1) {
                    $coursePermission->type = 'public';
                }
                elseif($request->course_permission == 4) {
                    $coursePermission->type = 'external';
                }
                else {
                    $coursePermission->type = 'private';
                }
                $coursePermission->save();
            }
            else {
                //Doesnt exist
                if($request->course_permission == 1) {
                    CoursePermissions::create([
                        'course_id' => $course_id,
                        'permission_id' => $request->course_permission,
                        'type' => 'public'
                    ]);
                } else {
                    CoursePermissions::create([
                        'course_id' => $course_id,
                        'permission_id' => $request->course_permission,
                        'type' => 'private'
                    ]);
                }
            }

            //Remove all individual permissions linked to course
            CoursesettingsUsers::where('course_id', $course_id)->delete();
            if ($request->individual_permissions) {
                foreach ($request->individual_permissions as $key => $ind) {
                    $username = preg_filter("/[^(]*\(([^)]+)\)[^()]*/", "$1", $ind);
                    $name = trim(preg_replace("/\([^)]+\)/", "", $ind));
                    if ($username) {
                        $iperm = CoursesettingsUsers::updateOrCreate([
                            'course_id' => $course_id,
                            'username' => $username
                        ], [
                            'name' => $name,
                            'permission' => $request->individual_perm_type[$key]
                        ]);
                    }
                }
            }


            $coursesettings_permissions->save();
        }
        return redirect()->route('manage_course');
    }
}
