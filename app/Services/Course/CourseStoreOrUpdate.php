<?php

namespace App\Services\Course;

use App\Course;
use App\CourseadminPermission;
use App\Jobs\JobFailedNotification;
use App\Services\Daisy\DaisyIntegration;
use App\VideoCourse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CourseStoreOrUpdate
{
    protected $courses, $course;
    protected $db_course;
    protected $daisy, $daisy_course;

    public function __construct($request, $video)
    {
        $this->courses = $request->input('package.courses');
        $this->video = $video;
    }

    public function store()
    {
        if ($this->courses) {
            //Remove any old VideoCourse associations
            VideoCourse::where('video_id', $this->video->id)->delete();
            foreach ($this->courses as $this->course) {
                if($this->course) {
                    //$year = '20' . substr($this->course['semester'], 2);
                    $year = substr('ht2023', 2);
                    $semester = Str::upper(mb_substr($this->course['semester'], 0, 2)) ;
                    //Check if course exists
                    if ($this->db_course = Course::where('designation', $this->course['designation'])->where('semester', $semester)->where('year', $year)->first()) {
                        //Create VideoCourse relation
                        VideoCourse::updateOrCreate([
                            'video_id' => $this->video->id,
                            'course_id' => $this->db_course->id
                        ]);

                        $this->cid =  $this->db_course->id;

                    } else {
                        //Lookup course from Daisy and store in db
                        $this->daisy = new DaisyIntegration();
                        if($this->daisy_course = $this->daisy->getCourse($this->course['designation'], $year. $this->convertDaisySemester($semester)) ) {
                            $this->db_created_course = Course::updateOrCreate([
                                'id' => $this->daisy_course['id']],
                                [
                                    'name' => $this->daisy_course['name'],
                                    'name_en' => $this->daisy_course['name_en'],
                                    'designation' => $this->daisy_course['designation'],
                                    'semester' => $semester,
                                    'year' => $year
                                ]);

                            //Create VideoCourse relation
                            VideoCourse::updateOrCreate([
                                'video_id' => $this->video->id,
                                'course_id' => $this->db_created_course->id,
                            ]);

                            $this->cid =  $this->db_created_course->id;
                        } else {
                            //Course doesnot exist in Daisy lookup
                            //Log message
                            Log::notice('Failed course association. The notification package for presentation with id: '. $this->video->id.
                                ' Title: '. $this->video->title.' Failed associating the presentation with the specified course due to the following error: Designation: '.$this->course['designation'].
                                ' was unable to be found in Daisy. The presentation needs to be associated manually.');
                            // and create an error notification to admins
                            $job = (new JobFailedNotification($this->video, $this->course['designation']));
                            dispatch($job);
                        }

                    }
                } else {
                    //Remove any old VideoCourse associations
                    VideoCourse::where('video_id', $this->video->id)->delete();
                }

                //Store course administrator permissions
                if($this->cid ?? false) {
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
        }
    }

    private function convertDaisySemester($semester)
    {
        switch($semester) {
            case('VT'):
                return 1;
                break;
            case('HT'):
                return 2;
                break;
        }
        return 0;
    }

}
