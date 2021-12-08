<?php

namespace App\Services\Filters;

use App\Services\Daisy\DaisyAPI;
use Illuminate\Support\Facades\App;
use LdapRecord\Models\Model;

class SortByCourseAdmin extends model
{
    public function course_after_year($username)
    {
        $daisy = new DaisyAPI();
        //Get user DaisyID
        $daisyPersonID = $daisy->getDaisyPersonId($username);

        //Get all courses where user is courseadmin
        if ($courses = $daisy->getDaisyEmployeeResponsibleCourses($daisyPersonID)) {
            /*
             * [0] Coursename swedish
             * [1] Coursename english
             * [2] CourseID
             * [3] Semester in format year XXXX and term 1 spring(VT) 2 fall(HT) - e.g. 20212
             * [4] Designation
             * [5] Courseadmin true/false
             */
            //Group after year
            $start = 0;
            if (App::currentLocale() == 'swe') {
                //Courselist in Swedish
                foreach ($courses as $course) {
                    if ($start == 0) {
                        $year = substr($course[3], 0, 4);
                    }
                    if ($year == substr($course[3], 0, 4)) {
                        if (substr($course[3], 4) == '1') {
                            $courselist[$year][$course[2]] = 'VT' . substr($course[3], 0, 4) . ' ' . $course[4] . ' - ' . $course[0] . ' (' . 'KursID: ' . ' ' . $course[2] . ')';
                        } else {
                            $courselist[$year][$course[2]] = 'HT' . substr($course[3], 0, 4) . ' ' . $course[4] . ' - ' . $course[0] . ' (' . 'KursID: ' . ' ' . $course[2] . ')';
                        }
                        $start++;
                    } else {
                        $start = 0;
                    }
                }
            } else {
                //Courselist in english
                foreach ($courses as $course) {
                    if ($start == 0) {
                        $year = substr($course[3], 0, 4);
                    }
                    if ($year == substr($course[3], 0, 4)) {
                        if (substr($course[3], 4) == '1') {
                            $courselist[$year][$course[2]] = 'VT' . substr($course[3], 0, 4) . ' ' . $course[4] . ' - ' . $course[1] . ' (' . 'CourseID:' . ' ' . $course[2] . ')';
                        } else {
                            $courselist[$year][$course[2]] = 'HT' . substr($course[3], 0, 4) . ' ' . $course[4] . ' - ' . $course[1] . ' (' . 'CourseID:' . ' ' . $course[2] . ')';
                        }
                        $start++;
                    } else {
                        $start = 0;
                    }

                }
            }

        } else {
            return false;
        }
        return $courselist;
    }
}
