<?php

namespace App\Services\Course;

use App\Course;
use App\Services\Daisy\DaisyIntegration;
use App\VideoCourse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class CourseStore extends Model
{
    protected $creation, $timestamp;
    protected $daisy;

    public function __construct($request, $video)
    {
        $this->courses = $request->courses;
        $this->timestamp = $request->creation;
        $this->video = $video;
    }

    public function course()
    {
        //If there is no course association
        /*
        if (!count($this->courses) > 0) {
             Do not save course association when there's no course
            VideoCourse::updateOrCreate([
                'video_id' => $this->video->id,
                'course_id' => 1,
            ]);

        }
        */
        if ($this->courses) {
            foreach ($this->courses as $key => $this->item) {
                if ($this->item) {
                    //Check if course exists

                    if (!$this->db_course = Course::where('designation', $this->item)->where('semester', $this->convertSemester($this->timestamp))->where('year', $this->convertYear($this->timestamp))->first()) {
                        //Retrive course information from Daisy
                        $this->daisy = new DaisyIntegration();
                        $this->retrieved_course = $this->daisy->getCourse($this->item, $this->convertYear($this->timestamp) . $this->convertDaisySemester($this->timestamp));
                        $this->course = Course::create([
                            'id' => $this->retrieved_course['id'],
                            'name' => $this->retrieved_course['name'],
                            'designation' => $this->retrieved_course['designation'],
                            'semester' => $this->convertSemester($this->timestamp),
                            'year' => $this->convertYear($this->timestamp),
                        ]);

                        VideoCourse::create([
                            'video_id' => $this->video->id,
                            'course_id' => $this->course->id,
                        ]);
                    } else {
                        //The course exists
                        if ($key == 0) {
                            //Remove any old associations
                            VideoCourse::where('video_id', $this->video->id)->delete();
                        }
                        //Create new associations
                        VideoCourse::Create([
                            'video_id' => $this->video->id,
                            'course_id' => $this->db_course->id,
                        ]);
                    }
                } else {
                    //Remove any old associations
                    VideoCourse::where('video_id', $this->video->id)->delete();
                }

            } //end foreach
        }

    }

    public function convertYear($timestamp)
    {
        $this->creation = Carbon::createFromTimestamp($timestamp)->toObject();
        return $this->creation->year;
    }

    public function convertSemester($timestamp)
    {
        $this->creation = Carbon::createFromTimestamp($timestamp)->toObject();
        if (in_array($this->creation->month, [1, 2, 3, 4, 5, 6])) {
            return 'VT';
        } else {
            return 'HT';
        }
    }

    public function convertDaisySemester($timestamp)
    {
        $this->creation = Carbon::createFromTimestamp($timestamp)->toObject();
        if (in_array($this->creation->month, [1, 2, 3, 4, 5, 6])) {
            return '1';
        } else {
            return '2';
        }
    }

}
