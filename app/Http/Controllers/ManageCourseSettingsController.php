<?php

namespace App\Http\Controllers;

use App\Course;
use App\CoursePermissions;
use App\CoursesettingsPermissions;
use App\CoursesettingsUsers;
use App\CourseTag;
use App\Permission;
use App\Services\Daisy\DaisyAPI;
use App\Services\Daisy\DaisyIntegration;
use App\VideoCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ManageCourseSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('redirect-links');
    }

    public function index()
    {
        $coursesetlist = [];
        $individual_permissions = [];
        $playback_permissions = [];
        $presentations = [];

        $daisy = new DaisyAPI();
        if (app()->make('play_role') == 'Administrator') {
            //Play-Administrator
            $courses = $daisy->getDaisyCourses();
        } else {
            //Courseadmin

            /*if(!app()->environment('local')) {
                //Get user DaisyID
                $daisyPersonID = $daisy->getDaisyPersonId(app()->make('play_username'));
                //Get all courses where user is courseadmin
                $courses = $daisy->getDaisyEmployeeResponsibleCourses($daisyPersonID);
            }*/

            //Get user DaisyID
            $daisyPersonID = $daisy->getDaisyPersonId(app()->make('play_username'));
            //Get all courses where user is courseadmin
            $courses = $daisy->getDaisyEmployeeResponsibleCourses($daisyPersonID);

            if (!$courses) {
                return 'Not a courseadmin';
            }
        }
        //Group after term
        $courselist = [];
        foreach ($courses as $course) {
            $year = substr($course['semester'], 0, 4);
            $term = (substr($course['semester'], 4) == '1') ? 'VT' : 'HT';
            $name = Lang::locale() == 'swe' ? $course['name'] : $course['name_en'];
            //$courselist[$term . $year][$course['id']] = $course['designation'] . ' ' . $term . $year . ' — ' . $name . ' (' . __('id') . ' ' . $course['id'] . ')';
            $courselist[$term . $year][$course['id']] = $course['designation'] . ' ' . $term . $year . ' — ' . $name;
            $this->checkCourseSettings($course['id'], $coursesetlist, $presentations, $individual_permissions, $playback_permissions);
        }
        return view('manage.manage_course', compact('courselist', 'coursesetlist', 'individual_permissions', 'playback_permissions', 'presentations'));
    }

    public function checkCourseSettings($courseid, &$coursesetlist, &$presentations, &$individual_permissions, &$playback_permissions)
    {
        //Check settings for course
        if ($courseSettings = CoursesettingsPermissions::where('course_id', $courseid)->first()) {
            //Visibility
            $coursesetlist[$courseid]['visibility'] = $courseSettings->visibility;
            //Downloadable
            $coursesetlist[$courseid]['downloadable'] = $courseSettings->downloadable;
            //Individual users
            if ($ipermissions = CoursesettingsUsers::where('course_id', $courseid)->count()) {
                $individual_permissions[$courseid] = $ipermissions;
            }
            //Group permissions
            $playback_permissions[$courseid] = CoursePermissions::where('course_id', $courseid)->first();
            //Presentations
            $presentations[$courseid] = VideoCourse::where('course_id', $courseid)->count();
        }
    }

    public function edit($courseid)
    {
        //Check if course exist else update Course
        if ($course = Course::find($courseid)) {
            $individual_permissions = [];
            $coursesettings_permissions = CoursesettingsPermissions::where('course_id', $courseid)->first();
            //Individual user settings
            if ($ipermissions = CoursesettingsUsers::where('course_id', $courseid)->get()) {
                $individual_permissions = $ipermissions;
            }
            //Group permissions
            $permissions = Permission::all();
            $user_permission = $course->userPermission();
            // If user has neither course responsibility nor individual permission, prevent it.
            if (!$user_permission || !in_array($user_permission, ['edit', 'delete'])) {
                abort(401);
            }

            return view('manage.editcourse', compact('course', 'coursesettings_permissions', 'individual_permissions', 'permissions', 'user_permission'));
        } else {
            return redirect()->action(
                [ManageCourseSettingsController::class, 'edit'], ['courseid' => $this->updateCourse($courseid)]
            );
        }
    }

    public function store($course_id, Request $request)
    {
        if ($request->isMethod('post')) {
            $coursesettings_permissions = CoursesettingsPermissions::firstOrNew(['course_id' => $course_id]);
            //Store
            $coursesettings_permissions->course_id = $course_id;
            //Visibility
            if ($request->visibility) {
                $coursesettings_permissions->visibility = true;
            } else {
                $coursesettings_permissions->visibility = false;
            }
            //Downloadable
            if ($request->downloadable) {
                $coursesettings_permissions->downloadable = true;
            } else {
                $coursesettings_permissions->downloadable = false;
            }

            //Update group permission for presentation
            if ($coursePermission = CoursePermissions::where('course_id', $course_id)->first()) {
                //Exist
                $coursePermission->permission_id = $request->course_permission;
                if ($request->course_permission == 1) {
                    $coursePermission->type = 'public';
                } elseif ($request->course_permission == 4) {
                    $coursePermission->type = 'external';
                } else {
                    $coursePermission->type = 'private';
                }
                $coursePermission->save();
            } else {
                //Doesnt exist
                if ($request->course_permission == 1) {
                    CoursePermissions::create([
                        'course_id' => $course_id,
                        'permission_id' => $request->course_permission,
                        'type' => 'public'
                    ]);
                } else {
                    CoursePermissions::create([
                        'course_id' => $course_id,
                        'permission_id' => $request->course_permission ?? 1,
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

            // Update tags
            CourseTag::where(['course_id' => $course_id])->delete();
            if (!$request->tags == null) {
                foreach ($request->tags as $tagid) {
                    CourseTag::updateOrcreate(['course_id' => $course_id, 'tag_id' => $tagid]);
                }
            }

            $coursesettings_permissions->save();
        }

        if(count(session('links') ?? []) <= 3) {
            return redirect()->route('home')->with('success', true)->with('message', __('The course was successfully updated'));
        } else {
            return redirect(session('links')[2])->with('success', true)->with('message', __('The course was successfully updated'));
        }

    }

    private function updateCourse($course_id)
    {
        //For updating missing course from Daisy

        $daisy = new DaisyIntegration();

        $this->retrieved_course = $daisy->getCourseSegment($course_id);
        //Update or Create Course
        if (substr($this->retrieved_course['semester'], 4) == '1') {
            $this->course = Course::updateOrCreate(
                ['id' => $this->retrieved_course['id'], 'designation' => $this->retrieved_course['designation'], 'semester' => 'VT', 'year' => substr($this->retrieved_course['semester'], 0, 4)],
                ['name' => $this->retrieved_course['name'], 'name_en' => $this->retrieved_course['name_en']]
            );
        } else {
            $this->course = Course::updateOrCreate(
                ['id' => $this->retrieved_course['id'], 'designation' => $this->retrieved_course['designation'], 'semester' => 'HT', 'year' => substr($this->retrieved_course['semester'], 0, 4)],
                ['name' => $this->retrieved_course['name'], 'name_en' => $this->retrieved_course['name_en']]
            );
        }

        return $course_id;

    }
}
