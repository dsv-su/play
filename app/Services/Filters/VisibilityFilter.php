<?php

namespace App\Services\Filters;

use App\Video;

class VisibilityFilter
{
    protected $video;

    public function __construct($videos)
    {
        $this->videos = $videos;
    }

        public function filter()
        {
            $this->videos->filter(function ($video, $key)  {
                //CourseSettings
                $CourseSettings = new CoursePermissionFilter($video);
                $CourseSettings->cast();
                //CourseSettingUsers
                $CourseSettingUsers = new CourseSettingUsersFilter($video);
                $CourseSettingUsers->cast();
                //IndividualUsers
                $IndividualUsers = new IndividualPermissionsFilter($video);
                $IndividualUsers->cast();
                //CourseAdmins
                $CourseAdmins = new CourseAdminPermissionFilter($video);
                $CourseAdmins->cast();
                //Admins
                $Admins = new AdminPermissionsFilter($video);
                $Admins->cast();
                return $video->visability;
            });


        }


}
