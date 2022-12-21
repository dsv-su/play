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
    public function checkifEmployee($id)
    {
        //Checks if user is employee only by a daisy lookup
        $this->array_resource = json_decode($this->getResource('employee', 'json')->getBody()->getContents(), TRUE);
        //return $this->array_resource;
        $this->employees_id = collect($this->array_resource)->map(function ($item, $key) {
            return $item['person']['id'];
        });
        foreach($this->employees_id as $this->employe_id) {
            if($id == $this->employe_id) {
                return true;
            }
        }
        return false;

    }

    public function getDaisyEmployee($username)
    {
        //Retrives user info from Daisy
        //$this->array_resource = json_decode($this->getResource('employee/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        $this->array_resource = json_decode($this->getResource('person/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        return $this->array_resource;
    }

    public function getDaisyPerson($id)
    {
        $this->array_resource = json_decode($this->getResource('person/' . $id . '/settings', 'json')->getBody()->getContents(), TRUE);
        return $this->array_resource;
    }

    public function checkCourseAdmin($id)
    {
        if (json_decode($this->getResource('employee/' . $id . '/contributions?fromSemesterId=' . $this->from_year() . '1&toSemesterId=' . $this->to_year() . '2', 'json')->getBody()->getContents(), TRUE)) {
            return true;
        } else {
            return false;
        }
    }

    //All courses where user is Responible courseadministrator
    public function getDaisyEmployeeResponsibleCourses($id)
    {
        if ($this->array_resources = json_decode($this->getResource('employee/' . $id . '/contributions?fromSemesterId=' . $this->from_year() . '1&toSemesterId=' . $this->to_year() . '2', 'json')->getBody()->getContents(), TRUE)) {
            //If user is courseadmin
            //Sort the result after id

            $this->resources = collect($this->array_resources)->sortBy(function ($course, $key) {
                return $course['courseSegmentInstance']['id'];
            });

            foreach ($this->resources->reverse() as $course) {
                $courselist[] = [
                    'name' => $course['courseSegmentInstance']['name']['swedish'],
                    'name_en' => $course['courseSegmentInstance']['name']['english'],
                    'id' => $course['courseSegmentInstance']['id'],
                    'semester' => $course['courseSegmentInstance']['semesterId'],
                    'designation' => $course['courseSegmentInstance']['designation'],
                    'responsbile' => $course['responsible']
                ];
            }
        } else {
            return false;
        }

        /*
         * Returns an array
                   * [0] Coursename swedish
                   * [1] Coursename english
                   * [2] CourseID
                   * [4] Designation
                   * [3] Semester in format year XXXX and term 1 spring(VT) 2 fall(HT) - e.g. 20212
                   * [5] Courseadmin true/false
                   */

        return $courselist;
    }

    //All courses from Daisy
    public function getDaisyCourses()
    {
        //Retrive all courses from Daisy from_year -- to_year
        $intervall = $this->to_year() - $this->from_year();
        for ($i = 0; $i <= $intervall; $i++) {
            $years[] = $this->to_year() - $i;
        }

        foreach ($years as $year) {
            // Order is reversed to get HT before VT since we're querying backwards
            for ($i = 2; $i >= 1; $i--) {
                $this->array_resources = json_decode($this->getResource('courseSegment?semester=' . $year . $i, 'json')->getBody()->getContents(), TRUE);
                /* we don't need to sort by semester, just ids
                $this->resources = collect($this->array_resources)->sortBy(function ($course, $key) {
                    return $course['semester'];
                });
                */
                $this->resources = collect($this->array_resources)->sortBy(function ($course, $key) {
                    return $course['id'];
                });
                foreach ($this->resources->reverse() as $course) {
                    $courselist[] = $course;
                }
            }
        }

        return $courselist;
    }
}
