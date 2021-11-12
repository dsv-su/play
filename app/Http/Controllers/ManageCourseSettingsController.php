<?php

namespace App\Http\Controllers;

use App\Services\Daisy\DaisyAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ManageCourseSettingsController extends Controller
{
    public function index()
    {
        $daisy = new DaisyAPI();
        //Get user DaisyID
        $daisyPersonID = $daisy->getDaisyPersonId('gwett');

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



                }
            }
            //dd($courselist);
        }
        else {
            return 'Not a courseadmin';
        }

        return view('manage.manage_course', compact('courselist'));

    }

    public function edit($courseid)
    {
        dd($courseid);
    }
}
