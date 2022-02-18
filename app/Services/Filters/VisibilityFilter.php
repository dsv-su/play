<?php

namespace App\Services\Filters;

class VisibilityFilter
{
    public function filter($videos)
    {
         return $this->FilterDownloadable($this->Filtervisibility($videos));
    }

    public function Filtervisibility($videos)
    {
        return $videos->filter(function ($video)  {
            //PresentationPermissionsSetting - type
            $PresentationSetting = new PresentationPermissionsFilter($video);
            $PresentationSetting->cast();
            //CoursePermissionsSettings - type
            $CourseSettings = new CoursePermissionFilter($video);
            $CourseSettings->cast();
            //CourseSettings
            $CourseSettings = new CourseSettingsFilter($video);
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

            return $video->visibility;
        });
    }

    public function FilterDownloadable($videos)
    {
        return $videos->filter(function ($video) {
            //CourseDownload
            $CourseDownload = new CourseDownloadFilter($video);
            $CourseDownload->cast();
            return $video;
        });
    }
}
