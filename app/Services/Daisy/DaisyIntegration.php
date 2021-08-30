<?php

namespace App\Services\Daisy;

use App\Course;
use App\System;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class DaisyIntegration extends Model
{
    protected $system, $res, $client;
    protected $endpoints, $endp, $xml, $json, $array, $item, $course;
    protected $resource, $array_resource;
    protected $courses, $courselist, $course_json, $course_result, $list;

    public function __construct()
    {
        $this->system = System::find(1);
    }

    public function getResource($endpoint, $type = null)
    {
        $this->client = new Client();
        return $this->client->request('GET', $this->system->daisy_url . $endpoint, [
            'auth' => [$this->system->daisy_username, $this->system->daisy_password],
            'headers' => ['Accept' => $type ? "application/$type" : '']
        ]);

    }

    //Method for retrieving DaisyId with UserID
    public function getDaisyPersonId($username)
    {
        $this->array_resource = json_decode($this->getResource('person/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        return $this->array_resource['id'];
    }

    //Method for retrieving course info from daisy with
    public function getCourse($designation, $semester)
    {
        $this->array_resource = json_decode($this->getResource('/courseSegment?designation=' . $designation . '&semester=' . $semester, 'json')->getBody()->getContents(), TRUE);
        // I hope no courses are given two times within the given term...
        return $this->array_resource[0];
    }

    //Method for retrieving employees active courses from Daisy with UserID
    public function getActiveEmployeeCourses($username)
    {
        //Filters courses from ht2019-vt2021
        $this->array_resource = json_decode($this->getResource('/employee/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        $this->courses = json_decode($this->getResource('/employee/' . $this->array_resource['person']['id'] . '/contributions?fromSemesterId=20192&toSemesterId=20211', 'json')->getBody()->getContents(), TRUE);
        foreach ($this->courses as $this->instance) {
            $this->list[] = $this->instance['courseSegmentInstance']['id'];
        }
        return $this->list;
    }

    //Method for retrieving employees active semesters from Daisy with UserID
    public function getActiveEmployeeSemesters($username)
    {
        //Filters courses from ht2019-vt2021
        $this->array_resource = json_decode($this->getResource('/employee/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        $this->courses = json_decode($this->getResource('/employee/' . $this->array_resource['person']['id'] . '/contributions?fromSemesterId=20192&toSemesterId=20211', 'json')->getBody()->getContents(), TRUE);
        foreach ($this->courses as $this->instance) {
            $this->list[$this->instance['courseSegmentInstance']['id']] = $this->instance['courseSegmentInstance']['semesterId'];
        }
        return $this->list;
    }

    //Method for retrieving Employees active course designations from Daisy with UserID
    public function getActiveEmployeeDesignations($username)
    {
        //Filters designations from vt2019-vt2021
        $this->array_resource = json_decode($this->getResource('/employee/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        $this->courses = json_decode($this->getResource('/employee/' . $this->array_resource['person']['id'] . '/contributions?fromSemesterId=20191&toSemesterId=20211', 'json')->getBody()->getContents(), TRUE);
        foreach ($this->courses as $this->instance) {
            if (substr($this->instance['courseSegmentInstance']['semesterId'], 4) == '1') {
                $this->list[$this->instance['courseSegmentInstance']['designation']] = $this->instance['courseSegmentInstance']['designation'] . ' VT ' . substr($this->instance['courseSegmentInstance']['semesterId'], 0, -1);
            } else {
                $this->list[$this->instance['courseSegmentInstance']['designation']] = $this->instance['courseSegmentInstance']['designation'] . ' HT ' . substr($this->instance['courseSegmentInstance']['semesterId'], 0, -1);
            }
        }
        return $this->list;
    }

    //Method for retrieving current active courses from Daisy
    public function getActiveCourses()
    {
        $date = Carbon::now()->format('Y-m-d\TH:i:s');
        //return $date;
        $this->course_result = $this->getResource("courseSegment?startDateBefore=$date&endDateAfter=$date", 'json');
        $this->courses = json_decode($this->course_result->getBody()->getContents(), TRUE);
        //Check if there exist active courses
        if($this->courses) {
            foreach ($this->courses as $this->courselist) {
                $this->list[] = $this->courselist['id'];
            }
        } else {
            $this->list[] = 0;
        }

        return $this->list;
    }

    //Method for retrieving Students active courses from Daisy with UserID
    public function getActiveStudentCourses($username)
    {
        $this->array_resource = json_decode($this->getResource('person/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        $this->courses = json_decode($this->getResource('/person/' . $this->array_resource['id'] . '/courseSegmentInstances', 'json')->getBody()->getContents(), TRUE);
        foreach ($this->courses as $this->courselist) {
            $this->list[] = $this->courselist['id'];
        }
        return $this->list;
    }

    //Method for retrieving Students active course designations from Daisy with UserID
    public function getActiveStudentDesignations($username)
    {
        $this->array_resource = json_decode($this->getResource('person/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        $this->course_json = json_decode($this->getResource('/person/' . $this->array_resource['id'] . '/courseSegmentInstances', 'json')->getBody()->getContents(), 'TRUE');
        foreach ($this->course_json as $this->courselist) {
            if (substr($this->courselist['semester'], 4) == '1') {
                $this->list[$this->courselist['designation']] = $this->courselist['designation'] . ' VT' . substr($this->courselist['semester'], 0, -1);
            } else {
                $this->list[$this->courselist['designation']] = $this->courselist['designation'] . ' HT' . substr($this->courselist['semester'], 0, -1);
            }
        }
        return $this->list;
    }

    //Method for initiating play and preloading courses from Daisy
    public function init()
    {
        $this->endpoints = array(
            'courseSegment?semester=20212',
            'courseSegment?semester=20211',
            'courseSegment?semester=20201',
            'courseSegment?semester=20202',
            'courseSegment?semester=20191',
            'courseSegment?semester=20192',
            'courseSegment?semester=20181',
            'courseSegment?semester=20182',
            /*'courseSegment?semester=20171',
            'courseSegment?semester=20172',
            'courseSegment?semester=20161',
            'courseSegment?semester=20162',
            'courseSegment?semester=20151',
            'courseSegment?semester=20152',
            'courseSegment?semester=20141',
            'courseSegment?semester=20142',
            'courseSegment?semester=20131',
            'courseSegment?semester=20132',
            'courseSegment?semester=20121',
            'courseSegment?semester=20122',
            'courseSegment?semester=20111',
            'courseSegment?semester=20112',
            'courseSegment?semester=20101',
            'courseSegment?semester=20102',*/
        );


        //$daisy = new DaisyIntegration($this->system);
        foreach ($this->endpoints as $this->endp) {
            $this->array = json_decode($this->getResource($this->endp, 'json')->getBody()->getContents(), TRUE);

            //Store id db table
            foreach ($this->array as $this->item) {
                if (substr($this->item['semester'], 4) == '1') {
                    Course::updateOrCreate(
                        ['id' => $this->item['id'], 'designation' => $this->item['designation'], 'semester' => 'VT', 'year' => substr($this->item['semester'], 0, 4)],
                        ['name' => $this->item['name']]
                    );
                } else {
                    Course::updateOrCreate(
                        ['id' => $this->item['id'], 'designation' => $this->item['designation'], 'semester' => 'HT', 'year' => substr($this->item['semester'], 0, 4)],
                        ['name' => $this->item['name']]
                    );
                }
            }
        }
    }
}
