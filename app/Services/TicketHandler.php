<?php

namespace App\Services;

use App\CoursePermissions;
use App\CoursesettingsUsers;
use App\Permission;
use App\Video;
use App\VideoPermission;
use Illuminate\Database\Eloquent\Model;

class TicketHandler extends Model
{
    protected $credentials, $video, $entitlements, $entitlement, $server, $server_entitlement;
    protected $individuals, $iper, $courseadmins, $cper;
    protected $coursepermission, $cindividuals, $ciper;

    public function __construct(Video $video)
    {
        $this->video = $video;

    }

    public function issue()
    {
        $this->credentials = [
            'email'=> $this->ticket_user(),
            'password' => $this->ticket_pass()
        ];

        //Check permission for requested video
        if($this->check_course_permission($this->video)) {
            if($this->check_presentation_permission($this->video)) {
                //Issue a valid ticket for requester
                if (!$this->token = auth()->claims(['id' => $this->video->id])->attempt($this->credentials)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            } else {
                $this->token = '';
            }
        }
        else {
            $this->token = '';
            }


        return $this->token;

    }

    private function check_course_permission($video)
    {
        if(count($belongs_to_course = $video->courses()) > 0) {
            $course_id = $belongs_to_course[0]['id'];
            if(count($this->coursepermission = CoursePermissions::where('course_id', $course_id)->pluck('permission_id'))){
                //If the external permission setting is set (overriding shibboleth SSO)
                if(in_array(4, $this->coursepermission->toArray()) or app()->environment('local')) {
                    return true;
                }
                //Check individual permissions
                elseif ($this->course_iperm($course_id)) {
                    return true;
                }
                //Check group permissions
                else {
                    $this->entitlement = Permission::where('id', $this->coursepermission[0])->pluck('entitlement');
                    $this->explicit_entitlements = explode(";", $this->entitlement[0]);
                    $this->server = explode(";", $_SERVER['entitlement']);
                    foreach ($this->explicit_entitlements as $this->explicit_entitlement) {
                        foreach ($this->server as $this->server_entitlement) {
                            if ($this->explicit_entitlement == $this->server_entitlement) return true;
                        }
                    }
                }
            } else {
                //Default callback permission setting
                return true;
            }

        }
        else {
            return true;
        }
    }

    private function check_presentation_permission($video)
    {
        //Get all permissions for the video
        $this->permissions = VideoPermission::where('video_id', $video->id)->pluck('permission_id');

        foreach($video->courses() as $course) {
            $coursepersmission = CoursePermissions::where('course_id', $course->id)->pluck('permission_id');
            if(in_array(4, $this->permissions->toArray()) or $coursepersmission[0] == 4) {
                //If the external permission setting is set (overriding shibboleth SSO)
                return true;
            }
        }

        if($this->cperm($video)) {
            //Check if user is course administrator
            return true;
        }

        elseif($this->iperm()) {
            //Check if individual permissions have been set for this presentation
            return true;
        }
        else {
            //Check group permissions

            //Get all permission entitlements
            foreach($this->permissions as $this->permission) {

                $this->entitlements = Permission::where('id', $this->permission)->pluck('entitlement');

                //Check if user entitlement exists in permission entitlement
                if (!app()->environment('local') && $this->permission != 4) {
                    foreach ($this->entitlements as $this->entitlement) {
                        $this->explicit_entitlements = explode(";", $this->entitlement);
                        $this->server = explode(";", $_SERVER['entitlement']);
                        foreach ($this->explicit_entitlements as $this->explicit_entitlement) {
                            foreach ($this->server as $this->server_entitlement) {
                                if ($this->explicit_entitlement == $this->server_entitlement) return true;
                            }
                        }

                    }
                    //
                } else {
                    return true;
                }
            }
        }



    }

    //Check if user is a course administrator
    private function cperm($video)
    {
        //If app is local override
        if (app()->environment('local')) {
            return true;
        }
        else {
            //Check if user is courseadmin
            if($this->courseadmins = $video->coursepermissions ?? false) {
                foreach($this->courseadmins as $this->cper) {
                    //Check if user is listed
                    if($this->cper->username . '@su.se' == $_SERVER['eppn']) {
                        //Check if user has set permissions
                        if(in_array($this->cper->permission, ['read', 'edit', 'delete'])) {
                            return true;
                        }
                    }

                }
            }
            return false;
        }
    }

    //Check if indivdual course permissions have been set
    private function course_iperm($course_id)
    {
        if($this->cindividuals = CoursesettingsUsers::where('course_id', $course_id)->get()) {
            foreach($this->cindividuals as $this->ciper) {
                //Check if user is listed
                if($this->ciper->username . '@su.se' == $_SERVER['eppn']) {
                    //Check if user has set permissions
                    if(in_array($this->ciper->permission, ['read', 'edit', 'delete'])) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    //Check if individual permissions settings have been applied for this presentation
    private function iperm()
    {
        //If app is local override
        if (app()->environment('local')) {
            return true;
        }
        else {
            //Check if individual permissions has been set for presentation
            if($this->individuals = $this->video->ipermissions ?? false) {
                foreach($this->individuals as $this->iper) {
                    //Check if user is listed
                    if($this->iper->username . '@su.se' == $_SERVER['eppn']) {
                        //Check if user has set permissions
                        if(in_array($this->iper->permission, ['read', 'edit', 'delete'])) {
                            return true;
                        }
                    }

                }
            }
            return false;
        }
    }

    private function ticket_user()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path().'/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['ticket']['email'];
    }

    private function ticket_pass()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path().'/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['ticket']['password'];
    }

}
