<?php

namespace App\Services\Course;

use App\Course;
use App\CourseadminPermission;
use App\Jobs\JobFailedNotification;
use App\ManualPresentation;
use App\Services\Daisy\DaisyIntegration;
use App\VideoCourse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class CourseStore extends Model
{
    protected $courses, $creation, $timestamp;
    protected $daisy;
    protected $cid, $firstnames, $lastnames;

    public function __construct($request, $video)
    {
        $this->courses = $request->courses;
        $this->timestamp = $request->creation;
        $this->video = $video;
    }

    public function course()
    {
        if ($this->courses) {
            $this->daisy = new DaisyIntegration();

            //Manual upload
            if($this->video->origin == 'manual') {

                //Retrive manual_presentation
                $presentation = ManualPresentation::find($this->video->notification_id);

                foreach ($presentation->daisy_courses as $key => $this->item) {
                    if ($this->item) {

                        //Daisy lookup
                        $this->retrieved_course = $this->daisy->getCourseSegment($this->item);

                        //Update or Create Course
                        if (substr($this->retrieved_course['semester'], 4) == '1') {
                            $this->course = Course::updateOrCreate(
                                ['id' => $this->retrieved_course['id'], 'designation' => $this->retrieved_course['designation'], 'semester' => 'VT', 'year' => substr($this->retrieved_course['semester'], 0, 4)],
                                ['name' => $this->retrieved_course['name'], 'name_en' => $this->retrieved_course['name_en']]
                            );
                        } else {
                            $this->course = Course::updateOrCreate(
                                ['id' => $this->retrieved_course['id'], 'designation' => $this->retrieved_course['designation'], 'semester' => 'HT', 'year' => substr($this->retrieved_course['semester'], 0, 4)],
                                ['name' => $this->retrieved_course['name'], 'name_en' => $this->retrieved_course['name_en']]
                            );
                        }
                        //Create relation video-course
                        VideoCourse::create([
                            'video_id' => $this->video->id,
                            'course_id' => $this->course->id,
                        ]);
                        $this->cid = $this->course->id;

                        //Store course administrator permissions
                        if($this->cid) {
                            if($this->daisy) {
                                $this->course_responsible = $this->daisy->getDaisyCourseResponsible($this->cid);
                            } else {
                                $this->daisy = new DaisyIntegration();
                                $this->course_responsible = $this->daisy->getDaisyCourseResponsible($this->cid);
                            }

                            //This is for retriving the username -> until the endpoint in daisy has been revised
                            foreach($this->course_responsible as $resonsible) {
                                $usernames = $this->daisy->getDaisyUsername($resonsible['id']);
                                foreach($usernames as $username) {
                                    if($username['realm'] == 'SU.SE') {
                                        $course_resp_username[] = $username['username'];
                                    }
                                }
                                $this->firstnames[] = $resonsible['firstName'];
                                $this->lastnames[] = $resonsible['lastName'];
                            }

                            //Update coursePermissions

                            //First delete old courseadmins
                            CourseadminPermission::where('video_id', $this->video->id)->delete();

                            //Update CourseadminPersmission with new courseadmins
                            foreach($course_resp_username as $key => $usrn) {
                                CourseadminPermission::updateOrCreate([
                                    'video_id' => $this->video->id,
                                    'username' => $usrn
                                ],[
                                    'name' => $this->firstnames[$key].' '.$this->lastnames[$key],
                                    'permission' => 'delete'
                                ]);
                            }
                        }
                    }


                    else {
                        //Remove any old associations
                        VideoCourse::where('video_id', $this->video->id)->delete();
                    }

                }

            } else {
                //Cattura/Mediasite recordings
                foreach ($this->courses as $key => $this->item) {
                    if ($this->item) {

                        //Check if course exists calculate semester
                        if (!$this->db_course = Course::where('designation', $this->item)->where('semester', $this->convertSemester($this->timestamp))->where('year', $this->convertYear($this->timestamp))->first()) {

                            //Retrive course information from Daisy
                            if($this->retrieved_course = $this->daisy->getCourse($this->item, $this->convertYear($this->timestamp) . $this->convertDaisySemester($this->timestamp))) {
                                $this->course = Course::create([
                                    'id' => $this->retrieved_course['id'],
                                    'name' => $this->retrieved_course['name'],
                                    'name_en' => $this->retrieved_course['name_en'],
                                    'designation' => $this->retrieved_course['designation'],
                                    'semester' => $this->convertSemester($this->timestamp),
                                    'year' => $this->convertYear($this->timestamp),
                                ]);

                                VideoCourse::create([
                                    'video_id' => $this->video->id,
                                    'course_id' => $this->course->id,
                                ]);

                                $this->cid = $this->course->id;
                            } else {
                                //Log message
                                Log::notice('Failed course association. The notification package for presentation with id: '. $this->video->id.
                                    ' Title: '. $this->video->title.' Failed associating the presentation with the specified course due to the following error: Designation: '.$this->item.
                                    ' was unable to be found in Daisy. The presentation needs to be associated manually.');
                                // and create an error notification to admins
                                $job = (new JobFailedNotification($this->video, $this->item));
                                dispatch($job);
                            }

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
                            $this->cid = $this->db_course->id;
                        }


                        //Store course administrator permissions
                        if($this->cid) {
                            if($this->daisy) {
                                $this->course_responsible = $this->daisy->getDaisyCourseResponsible($this->cid);
                            } else {
                                $this->daisy = new DaisyIntegration();
                                $this->course_responsible = $this->daisy->getDaisyCourseResponsible($this->cid);
                            }

                            //This is for retriving the username -> until the endpoint in daisy has been revised
                            foreach($this->course_responsible as $resonsible) {
                                $usernames = $this->daisy->getDaisyUsername($resonsible['id']);
                                foreach($usernames as $username) {
                                    if($username['realm'] == 'SU.SE') {
                                        $course_resp_username[] = $username['username'];
                                    }
                                }
                                $this->firstnames[] = $resonsible['firstName'];
                                $this->lastnames[] = $resonsible['lastName'];
                            }

                            //Update coursePermissions

                            //First delete old courseadmins
                            CourseadminPermission::where('video_id', $this->video->id)->delete();

                            //Update CourseadminPersmission with new courseadmins
                            foreach($course_resp_username as $key => $usrn) {
                                CourseadminPermission::updateOrCreate([
                                    'video_id' => $this->video->id,
                                    'username' => $usrn
                                ],[
                                    'name' => $this->firstnames[$key].' '.$this->lastnames[$key],
                                    'permission' => 'delete'
                                ]);
                            }
                        }


                    }
                    else {
                        //Remove any old associations
                        VideoCourse::where('video_id', $this->video->id)->delete();
                    }

                } //end foreach

            }

            //Make presentation visibility and downloadability follow default coursesettings
            $set = new DefaultCourseSettings($this->video);
            $set->setCourseDefaultSettings();
        }

    }

    public function convertYear($timestamp)
    {
        $this->creation = Carbon::createFromTimestamp($timestamp)->toObject();
        if($this->creation->month == 1 && $this->creation->day < 16) {
            $this->creation->year = $this->creation->year - 1;
        }
        return $this->creation->year;
    }

    public function convertSemester($timestamp)
    {
        $this->creation = Carbon::createFromTimestamp($timestamp)->toObject();
        if (in_array($this->creation->month, [1, 2, 3, 4, 5, 6])) {
            if($this->creation->month == 1 && $this->creation->day < 16 ) {
                return 'HT';
            } else {
                return 'VT';
            }

        } else {
            return 'HT';
        }
    }

    public function convertDaisySemester($timestamp)
    {
        $this->creation = Carbon::createFromTimestamp($timestamp)->toObject();
        if (in_array($this->creation->month, [1, 2, 3, 4, 5, 6])) {
            if($this->creation->month == 1 && $this->creation->day < 16 ) {
                return '2';
            } else {
                return '1';
            }
        } else {
            return '2';
        }
    }

}
