<?php

namespace App\Services\Daisy;

use App\Course;
use App\System;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class DaisyIntegration extends Model
{
    protected $system, $res, $client;
    protected $endpoints, $endp, $xml, $json, $array, $item, $course;

    public function __construct()
    {
        $this->system = System::find(1);
    }

    public function getResource($endpoint)
    {
        $this->client = new Client();
        return $this->client->request('GET', $this->system->daisy_url.$endpoint, [
            'auth' => [$this->system->daisy_username, $this->system->daisy_password]
        ]);

    }


    public function init()
    {
        $this->endpoints = array(
            'courseSegment?semester=20211',
            'courseSegment?semester=20201',
            'courseSegment?semester=20202',
            'courseSegment?semester=20191',
            'courseSegment?semester=20192',
            /*'courseSegment?semester=20181',
            'courseSegment?semester=20182',
            'courseSegment?semester=20171',
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
            $this->res = $this->getResource($this->endp);

            //Convert xml to an array
            $this->xml = simplexml_load_string($this->res->getBody()->getContents());
            $this->json = json_encode($this->xml);
            $this->array = json_decode($this->json, TRUE);

            //Store id db table
            foreach ($this->array['courseSegmentInstance'] as $this->item) {
                if (substr($this->item['semester'], 4) == '1') {
                    Course::updateOrCreate(
                        ['designation' => $this->item['designation'], 'semester' => 'VT', 'year' => substr($this->item['semester'], 0, 4)],
                        ['name' => $this->item['name']]
                );
                    }
                else {
                    Course::updateOrCreate(
                        ['designation' => $this->item['designation'], 'semester' => 'HT', 'year' => substr($this->item['semester'], 0, 4)],
                        ['name' => $this->item['name']]
                    );
                }
                /*$this->course = new Course();
                $this->course->name = $this->item['name'];
                $this->course->designation = $this->item['designation'];
                if (substr($this->item['semester'], 4) == '1') {
                    $this->course->semester = 'VT';
                } else $this->course->semester = 'HT';
                $this->course->year = substr($this->item['semester'], 0, 4);

                $this->course->save();*/
            }
            //$this->course->save();
        }
    }
}
