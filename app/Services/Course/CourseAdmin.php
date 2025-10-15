<?php

namespace App\Services\Course;

use App\Services\Daisy\DaisyAPI;

class CourseAdmin
{
    protected $daisy, $daisyPersonID;

    public function check($user, $video)
    {
        return array_intersect($this->courses($user),$video->courses()->pluck('id')->toArray());
    }

    public function courses($id)
    {
        $this->daisy = new DaisyAPI();
        //Get user DaisyID
        $this->daisyPersonID = $this->daisy->getDaisyPersonId(substr($id, 0, strpos($id, "@")));
        //Get CourseAdmin courses
        if($courses = $this->daisy->getDaisyEmployeeResponsibleCourses($this->daisyPersonID)) {
            $courselist = collect($courses);
            return $courselist->map(function ($item, $key) {
                return $item['id'];
            })->toArray();
        } else {
            return [];
        }

    }
}
