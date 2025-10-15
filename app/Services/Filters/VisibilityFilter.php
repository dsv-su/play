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
            if(!$video->permission_type == 'dsv') {
                //Respect presentation setting - override only if not set

                //CoursePermissionsSettings - type
                $CourseSettings = new CoursePermissionFilter($video);
                $CourseSettings->cast();
            }

            /***
             * This setting has been disabled allowing presentations
             * to set visibility independent of the course setting
             * according to issue #115
             * 2022-09-08
             */
            /*
            if($video->visibility == true) {
                //Respect presentation setting - override only if not set

                //CourseSettings
                $CourseSettings = new CourseSettingsFilter($video);
                $CourseSettings->cast();
            }
            */

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
            if($Admins->cast()) {
                return $video;
            }

            //Make hidden videos show with 'hidden' features
            /*
            if($video->visibility == false) {
                $video->setAttribute('hidden', true);
                return $video;
            }
            */

            return $video->visibility;
        });
    }

    public function FilterDownloadable($videos)
    {
        return $videos->filter(function ($video) {
            /***
             * This setting has been disabled allowing presentations
             * to set visibility independent of the course setting
             * according to issue #115
             * 2022-09-08
             */
            //CourseDownload
            /*
            $CourseDownload = new CourseDownloadFilter($video);
            $CourseDownload->cast();
            */
            /***
             * Allow only visible presentations to be downloadable
             * this should really never happen, so it's a redundant feature
             */

            if($video->visibility == false) {
                $video->setAttribute('download', false);
            }
            return $video;
        });
    }
}
