<?php

namespace App\Services\Daisy;

use App\Course;
use App\System;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DaisyIntegration extends Model
{
    protected $system, $res, $client;
    protected $endpoints, $endp, $xml, $json, $array, $item, $course;
    protected $resource, $array_resource;
    protected $courses, $courselist, $course_json, $course_result, $list, $designation_header;

    public function __construct()
    {
        $this->system = System::find(1);
    }

    public function getResource($endpoint, $type = null)
    {
        $this->client = new Client();
        try {
            return $this->client->request('GET', $this->system->daisy_url . $endpoint, [
                'auth' => [$this->system->daisy_username, $this->system->daisy_password],
                'headers' => ['Accept' => $type ? "application/$type" : '']
            ]);
        } catch (ClientException $e) {
            app()->make('init')->check_system();
            abort(510);
        }
        return 0;
    }

    //Method for retrieving DaisyId with UserID
    public function getDaisyPersonId($username)
    {
        $this->array_resource = json_decode($this->getResource('person/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        return $this->array_resource['id'];
    }

    //Retrieving course info from daisy with courseID
    public function getCourseSegment($id)
    {
        $this->array_resource = json_decode($this->getResource('/courseSegment/'. $id, 'json')->getBody()->getContents(), TRUE);

        return $this->array_resource;
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
        $this->courses = json_decode($this->getResource('/employee/' . $this->array_resource['person']['id'] . '/contributions?fromSemesterId='.$this->from_year().'1&toSemesterId='.$this->to_year().'2', 'json')->getBody()->getContents(), TRUE);
        foreach ($this->courses as $this->instance) {
            $this->list[] = $this->instance['courseSegmentInstance']['id'];
        }
        return $this->list;
    }

    //Method for retrieving employees active semesters from Daisy with UserID
    public function getActiveEmployeeSemesters($username)
    {
        //Filters courses from ht2019-vt2021
        $this->array_resource = json_decode($this->getResource('employee/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        $this->courses = json_decode($this->getResource('/employee/' . $this->array_resource['person']['id'] . '/contributions?fromSemesterId='.$this->from_year().'1&toSemesterId='.$this->to_year().'2', 'json')->getBody()->getContents(), TRUE);
        foreach ($this->courses as $this->instance) {
            $this->list[$this->instance['courseSegmentInstance']['id']] = $this->instance['courseSegmentInstance']['semesterId'];
        }
        return $this->list;
    }

    //Method for retrieving Employees active course designations from Daisy with UserID
    public function getActiveEmployeeDesignations($username)
    {

        //Filters designations from vt2019-vt2021
        $this->array_resource = json_decode($this->getResource('employee/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        $this->courses = json_decode($this->getResource('/employee/' . $this->array_resource['person']['id'] . '/contributions?fromSemesterId='.$this->from_year().'1&toSemesterId='.$this->to_year().'2', 'json')->getBody()->getContents(), TRUE);
        $this->courses = collect($this->courses)->take(10);
        foreach ($this->courses as $this->instance) {
            if (substr($this->instance['courseSegmentInstance']['semesterId'], 4) == '1') {
                //$this->list[$this->instance['courseSegmentInstance']['designation']] = $this->instance['courseSegmentInstance']['designation'] . ' VT ' . substr($this->instance['courseSegmentInstance']['semesterId'], 0, -1);
                //The result should only be a designation
                $this->list[$this->instance['courseSegmentInstance']['designation']] = $this->instance['courseSegmentInstance']['designation'];
            } else {
                //$this->list[$this->instance['courseSegmentInstance']['designation']] = $this->instance['courseSegmentInstance']['designation'] . ' HT ' . substr($this->instance['courseSegmentInstance']['semesterId'], 0, -1);
                //The result should only be a designation
                $this->list[$this->instance['courseSegmentInstance']['designation']] = $this->instance['courseSegmentInstance']['designation'];
            }
        }
        return $this->list;
    }

    //Method for retrieving current active courses from Daisy
    public function getActiveCourses()
    {
        $date = Carbon::now()->format('Y-m-d\TH:i:s');

        //$this->course_result = $this->getResource("courseSegment?startDateBefore=$date&endDateAfter=$date", 'json');

        //Retrive only course from this semester
        //Parameter 20221 should be dervied from date
        $this->course_result = $this->getResource("courseSegment?semester=20221", 'json');

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
                //$this->list[$this->courselist['designation']] = $this->courselist['designation'] . ' VT' . substr($this->courselist['semester'], 0, -1);
                $this->list[$this->courselist['designation']] = $this->courselist['designation'];
            } else {
                //$this->list[$this->courselist['designation']] = $this->courselist['designation'] . ' HT' . substr($this->courselist['semester'], 0, -1);
                $this->list[$this->courselist['designation']] = $this->courselist['designation'];
            }
        }
        return $this->list;
    }

    //Responible courseadministrators (as an array) for a Courssegment
    public function getDaisyCourseResponsible($id)
    {
        $this->array_resource = json_decode($this->getResource('courseSegment/' . $id, 'json')->getBody()->getContents(), TRUE);
        if($this->array_resource['contributors']) {
            foreach($this->array_resource['contributors'] as $contributor) {
                if($contributor['responsible'] == true) {
                    //Return responisble teachers details
                    $responsible_contributor[] = json_decode($this->getResource('/person/' . $contributor['personId'], 'json')->getBody()->getContents(), 'TRUE');
                }
            }
            return $responsible_contributor;
        }

        return [];
    }

    //Method for retriving the username
    public function getDaisyUsername($id)
    {
        $this->array_resource = json_decode($this->getResource('person/' . $id . '/usernames', 'json')->getBody()->getContents(), TRUE);
        return $this->array_resource;
    }


    //Method for initiating play and preloading courses from Daisy
    public function init($start_date=null)
    {
        $this->endpoints = array(
            'courseSegment?semester=20222',
            'courseSegment?semester=20221',
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


        /*
         * This is an alternative solution with a setting in the ini-file -> waiting for Daisy to prepare the endpoint
         *
        $this->array = json_decode($this->getResource('courseSegment?startDateAfter='.$start_date, 'json')->getBody()->getContents(), TRUE);
        dd(count($this->array));
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

        */

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

    public function refreshCourses()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('courses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->init($this->start_date());

    }

    private function start_date()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['Daisy']['start_date'];
    }

    public function from_year()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            abort(510);
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['Daisy']['from_year'];
    }

    public function to_year()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            abort(510);
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['Daisy']['to_year'];
    }
}
