<?php

namespace App\Services\Daisy;

use App\Services\Daisy\DaisyIntegration;

class DaisyAPI extends DaisyIntegration
{

    public function loadCourses($endpoints)
    {
       //Loader
    }
    //All courses where user is Responible courseadministrator
    public function getDaisyEmployeeResponsibleCourses($id)
    {
        $this->array_resource = json_decode($this->getResource('employee/' . $id . '/contributions?fromSemesterId=20191&toSemesterId=20211', 'json')->getBody()->getContents(), TRUE);
        return $this->array_resource;
        /*if($this->array_resource['contributors']) {
            foreach($this->array_resource['contributors'] as $contributor) {
                if($contributor['responsible'] == true) {
                    //Return responisble teachers details
                    $responsible_contributor[] = json_decode($this->getResource('/person/' . $contributor['personId'], 'json')->getBody()->getContents(), 'TRUE');
                }
            }
            return $responsible_contributor;
        }

        return [];
        */
    }
}
