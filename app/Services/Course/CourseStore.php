<?php

namespace App\Services\Course;

use App\Course;
use App\VideoCourse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class CourseStore extends Model
{
    protected $creation, $timestamp;

    public function __construct($request, $video)
    {
        $this->courses = $request->courses;
        $this->timestamp = $request->creation;
        $this->video = $video;
    }

    public function course()
    {
        //If there is no course association
        if(!count($this->courses)>0) {
            VideoCourse::updateOrCreate([
                'video_id' => $this->video->id,
                'course_id' => 1,
            ]);
        }

        foreach ($this->courses as $this->item)
        {
            if($this->item) {
                //Check if course exists
                if(!$this->db_course = Course::where('designation', $this->item)->first()) {
                    $this->course = Course::create([
                        'name' => $this->item,
                        'designation' => $this->item,
                        'semester' => $this->convertSemester($this->timestamp),
                        'year' => $this->convertYear($this->timestamp),

                    ]);

                    VideoCourse::create([
                        'video_id' => $this->video->id,
                        'course_id' => $this->course->id,
                    ]);
                }
                else{
                    $this->db_course::updateOrCreate([
                        'designation' => $this->item],
                        [
                        'name' => $this->item,
                        'semester' => $this->convertSemester($this->timestamp),
                        'year' => $this->convertYear($this->timestamp),
                    ]);

                    VideoCourse::updateOrCreate([
                        'video_id' => $this->video->id,
                        'course_id' => $this->db_course->id,
                    ]);
                }
            }

        } //end foreach
    }

    public function convertYear($timestamp)
    {
        $this->creation = Carbon::createFromTimestamp($timestamp)->toObject();
        return $this->creation->year;
    }

    public function convertSemester($timestamp)
    {
        $this->creation = Carbon::createFromTimestamp($timestamp)->toObject();
        if(in_array($this->creation->month,[1,2,3,4,5,6])) {
            return 'VT';
        }
        else {
            return 'HT';
        }
    }

}
