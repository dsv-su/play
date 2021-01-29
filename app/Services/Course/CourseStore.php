<?php

namespace App\Services\Course;

use App\Course;
use App\VideoCourse;
use Illuminate\Database\Eloquent\Model;


class CourseStore extends Model
{
    public function __construct($request, $video)
    {
        $this->courses = $request->courses;
        $this->video = $video;
    }

    public function course()
    {
        foreach ($this->courses as $this->item)
        {
            if($this->item) {
                //Check if course exists
                if(!$this->db_course = Course::where('name', $this->item)->first()) {
                    $this->course = Course::create([
                        'name' => $this->item,
                    ]);

                    VideoCourse::create([
                        'video_id' => $this->video->id,
                        'course_id' => $this->course->id,
                    ]);
                }
                else{
                    VideoCourse::updateOrCreate([
                        'video_id' => $this->video->id,
                        'course_id' => $this->db_course->id,
                    ]);
                }
            }

        }
    }

}
