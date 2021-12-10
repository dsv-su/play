<?php

namespace App\Services\Daisy;

use App\Services\Daisy\DaisyIntegration;
use Illuminate\Support\Arr;

class DaisyAPI extends DaisyIntegration
{

    public function loadCourses($endpoints)
    {
       //Loader
    }

    public function checkCourseAdmin($id)
    {
        if(json_decode($this->getResource('employee/' . $id . '/contributions?fromSemesterId=20191&toSemesterId=20212', 'json')->getBody()->getContents(), TRUE)) {
            return true;
        }
        else
        {
            return false;
        }
    }

    //All courses where user is Responible courseadministrator
    public function getDaisyEmployeeResponsibleCourses($id)
    {
        if($this->array_resources = json_decode($this->getResource('employee/' . $id . '/contributions?fromSemesterId=20191&toSemesterId=20212', 'json')->getBody()->getContents(), TRUE)) {
            //If user is courseadmin
            //Sort the result after year

            $this->resources = collect($this->array_resources)->sortBy(function($course, $key) {
                return $course['courseSegmentInstance']['semesterId'];
            });
            $this->resources = collect($this->resources)->sortBy(function($course, $key) {
                return $course['courseSegmentInstance']['id'];
            });

            foreach ($this->resources->reverse() as $course) {
                $courselist[] = Arr::flatten($course);
            }
        }
        else {
            return false;
        }
        /*
         * Returns an array
                   * [0] Coursename swedish
                   * [1] Coursename english
                   * [2] CourseID
                   * [3] Semester in format year XXXX and term 1 spring(VT) 2 fall(HT) - e.g. 20212
                   * [4] Designation
                   * [5] Courseadmin true/false
                   */

        return $courselist;

    }

    //All courses from Daisy
    public function getDaisyCourses()
    {
        //Retrive all courses from Daisy from_year -- to_year
        $intervall = $this->to_year() - $this->from_year();
        for($i=0; $i<=$intervall;$i++){
            $years[] = $this->to_year() - $i;

        }

        foreach($years as $year) {
            for($i=1;$i<=2;$i++) {
                $this->array_resources = json_decode($this->getResource('courseSegment?semester='.$year.$i, 'json')->getBody()->getContents(), TRUE);

                $this->resources = collect($this->array_resources)->sortBy(function($course, $key) {
                    return $course['semester'];
                });
                $this->resources = collect($this->resources)->sortBy(function($course, $key) {
                    return $course['id'];
                });
                //return $this->resources;
                foreach ($this->resources->reverse() as $course) {
                    $courselist[] = $course;
                }
            }
        }



        return $courselist;

    }
    private function from_year()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['Daisy']['from_year'];
    }

    private function to_year()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['Daisy']['to_year'];
    }
}
