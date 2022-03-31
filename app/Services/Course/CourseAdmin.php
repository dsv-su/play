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
        $id = $id . '@su.se';
        $this->daisyPersonID = $this->daisy->getDaisyPersonId(substr($id, 0, strpos($id, "@")));
        //Get CourseAdmin courses
        $courselist = collect($this->daisy->getDaisyEmployeeResponsibleCourses($this->daisyPersonID));
        return $courselist->map(function ($item, $key) {
            return $item[2];
        })->toArray();
    }
}
