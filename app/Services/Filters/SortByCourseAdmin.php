<?php

namespace App\Services\Filters;

use App\Services\Daisy\DaisyAPI;
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

            foreach ($courses as $course) {
                if ($start == 0) {
                    $year = substr($course['semester'], 0, 4);
                }
                if ($year == substr($course['semester'], 0, 4)) {
                    if (substr($course['semester'], 4) == '1') {
                        $courselist[$year][$course['id']] = 'VT' . substr($course['semester'], 0, 4) . ' ' . $course['designation'] . ' - ' . $course['name'] . ' (' . __('Course id') . ' ' . $course['id'] . ')';
                    } else {
                        $courselist[$year][$course['id']] = 'HT' . substr($course['semester'], 0, 4) . ' ' . $course['designation'] . ' - ' . $course['name'] . ' (' . __('Course id') . ' ' . $course['id'] . ')';
                    }
                    $start++;
                } else {
                    $start = 0;
                }
            }
        } else {
            return false;
        }
        return $courselist;
    }
}
