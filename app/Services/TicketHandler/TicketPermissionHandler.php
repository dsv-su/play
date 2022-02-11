<?php

namespace App\Services\TicketHandler;

use App\Video;

class TicketPermissionHandler
{
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function issue()
    {
        //Entitlement validation
        $user_entitlement = new Entitlement();

        //PresentationSetting (2)
        $presentationSetting = new PresentationTicket($this->video);
        $presentationSetting->cast();

        //CourseSetting (1)
        $coursesettings = new CourseSettingTicket($this->video);
        $coursesettings->cast();

        //Check if presentation is public or enviroment is local dev
        if($user_entitlement->validate($this->video->permission_ticket_id)) {
            //Return Token
            $this->video = $this->video->fresh();
            $token = new TokenIssuer($this->video);
            return $token->issue();
        } else {
            //Presentation is not Public
            //Check exceptions and entitlements

            //PresentationIndividualUsers (5)
            $presentationIndividual = new PresentationIndividualTicket($this->video);
            $presentationIndividual->cast();

            //CourseSetting (4)
            $coursesettings = new CourseSettingTicket($this->video);
            $coursesettings->cast();

            //CourseIndividualUsers (3)
            $courseIndividual = new CourseIndividualTicket($this->video);
            $courseIndividual->cast();

            //CourseAdmin (2)
            $courseAdmin = new CourseAdminTicket($this->video);
            $courseAdmin->cast();

            //Admin (1)
            $admin = new AdminTicket($this->video);
            $admin->cast();
        }

        if($this->video->ticket or $user_entitlement->validate($this->video->permission_ticket_id)) {
            $this->video = $this->video->fresh();
            $token = new TokenIssuer($this->video);
            return $token->issue();
        } else {
            return '';
        }

    }
}
