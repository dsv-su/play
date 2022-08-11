<?php

namespace App\Services\Daisy;

use App\Course;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\DB;

class DaisyIntegration
{
    protected $system, $res, $client, $jar;
    protected $endpoints, $endp, $xml, $json, $array, $item, $course;
    protected $resource, $array_resource;
    protected $courses, $courselist, $course_json, $course_result, $list, $designation_header;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getResource($endpoint, $type = null)
    {
        try {
            return $this->client->request('GET', $this->daisy_url() . $endpoint, [
                'auth' => [$this->daisy_username(), $this->daisy_password()],
                'headers' => ['Accept' => $type ? "application/$type" : '']
            ]);
        } catch (ClientException $e) {
            app()->make('init')->check_system();
            report($e);
            abort(510);
        }
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
        $this->array_resource = json_decode($this->getResource('/courseSegment/' . $id, 'json')->getBody()->getContents(), TRUE);

        return $this->array_resource;
    }

    //Method for retrieving course info from daisy with
    public function getCourse($designation, $semester)
    {
        $this->array_resource = json_decode($this->getResource('/courseSegment?designation=' . $designation . '&semester=' . $semester, 'json')->getBody()->getContents(), TRUE);
        // Returns false if unsuccessful call
        return $this->array_resource[0] ?? false;
    }

    //Method for retrieving employees active courses from Daisy with UserID
    public function getActiveEmployeeCourses($username)
    {
        //Filters courses from to
        $this->array_resource = json_decode($this->getResource('/employee/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        $this->courses = json_decode($this->getResource('/employee/' . $this->array_resource['person']['id'] . '/contributions?fromSemesterId=' . $this->from_year() . '1&toSemesterId=' . $this->to_year() . '2', 'json')->getBody()->getContents(), TRUE);
        foreach ($this->courses as $this->instance) {
            $this->list[] = $this->instance['courseSegmentInstance']['id'];
        }
        return $this->list;
    }

    //Method for retrieving employees active semesters from Daisy with UserID
    public function getActiveEmployeeSemesters($username)
    {
        //Filters courses from to
        $this->array_resource = json_decode($this->getResource('employee/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        $this->courses = json_decode($this->getResource('/employee/' . $this->array_resource['person']['id'] . '/contributions?fromSemesterId=' . $this->from_year() . '1&toSemesterId=' . $this->to_year() . '2', 'json')->getBody()->getContents(), TRUE);
        foreach ($this->courses as $this->instance) {
            $this->list[$this->instance['courseSegmentInstance']['id']] = $this->instance['courseSegmentInstance']['semesterId'];
        }
        if (!empty($this->list)) {
            krsort($this->list);
            return array_slice(array_unique($this->list), 0, 6);
        } else {
            return $this->list;
        }
    }

    //Method for retrieving Employees active course designations from Daisy with UserID
    public function getActiveEmployeeDesignations($username)
    {
        //Filters designations from to
        $this->array_resource = json_decode($this->getResource('employee/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        $this->courses = json_decode($this->getResource('/employee/' . $this->array_resource['person']['id'] . '/contributions?fromSemesterId=' . $this->from_year() . '1&toSemesterId=' . $this->to_year() . '2', 'json')->getBody()->getContents(), TRUE);
        foreach ($this->courses as $this->instance) {
            $this->list[$this->instance['courseSegmentInstance']['id']] = $this->instance['courseSegmentInstance']['designation'];
        }
        if (!empty($this->list)) {
            krsort($this->list);
            return array_slice(array_unique($this->list), 0, 6);
        } else {
            return $this->list;
        }
    }

    //Method for retrieving current active courses from Daisy
    public function getActiveCoursesHT()
    {
        $this->course_result = [];
        $this->courses = [];
        $this->list = [];

        //Retrive only course from this semester
        $this->course_result = $this->getResource('courseSegment?semester=' . $this->to_year() . '2', 'json');

        $this->courses = json_decode($this->course_result->getBody()->getContents(), TRUE);
        //Check if there exist active courses
        if ($this->courses) {
            foreach ($this->courses as $this->courselist) {
                $this->list[] = $this->courselist['id'];
            }
        } else {
            $this->list[] = 0;
        }

        return $this->list;
    }
    public function getActiveCoursesVT()
    {
        $this->course_result = [];
        $this->courses = [];
        $this->list = [];

        //Retrive only course from this semester
        $this->course_result = $this->getResource('courseSegment?semester=' . $this->to_year() . '1', 'json');

        $this->courses = json_decode($this->course_result->getBody()->getContents(), TRUE);
        //Check if there exist active courses
        if ($this->courses) {
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
        if (!empty($this->list)) {
            rsort($this->list);
        }
        return $this->list;
    }

    //Method for retrieving Students active course designations from Daisy with UserID
    public function getActiveStudentDesignations($username)
    {
        $this->array_resource = json_decode($this->getResource('person/username/' . $username . '@su.se', 'json')->getBody()->getContents(), TRUE);
        $this->course_json = json_decode($this->getResource('/person/' . $this->array_resource['id'] . '/courseSegmentInstances', 'json')->getBody()->getContents(), 'TRUE');
        foreach ($this->course_json as $this->courselist) {
            $this->list[$this->courselist['id']] = $this->courselist['designation'];
        }
        if (!empty($this->list)) {
            krsort($this->list);
            return array_slice(array_unique($this->list), 0, 6);
        } else {
            return $this->list;
        }
    }

    //Responible courseadministrators (as an array) for a Courssegment
    public function getDaisyCourseResponsible($id)
    {
        $this->array_resource = json_decode($this->getResource('courseSegment/' . $id, 'json')->getBody()->getContents(), TRUE);
        if ($this->array_resource['contributors']) {
            foreach ($this->array_resource['contributors'] as $contributor) {
                if ($contributor['responsible'] == true) {
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
    public function init($start_date = null)
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
                        ['name' => $this->item['name'], 'name_en' => $this->item['name_en']]
                    );
                } else {
                    Course::updateOrCreate(
                        ['id' => $this->item['id'], 'designation' => $this->item['designation'], 'semester' => 'HT', 'year' => substr($this->item['semester'], 0, 4)],
                        ['name' => $this->item['name'], 'name_en' => $this->item['name_en']]
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

    private function daisy_url()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            abort(510);
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['Daisy']['daisy_url'];
    }

    private function daisy_username()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            abort(510);
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['Daisy']['daisy_username'];
    }

    private function daisy_password()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            abort(510);
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['Daisy']['daisy_password'];
    }
}
