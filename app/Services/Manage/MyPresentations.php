<?php

namespace App\Services\Manage;

use App\Course;
use App\IndividualPermission;
use App\Presenter;
use App\Tag;
use App\Video;
use App\VideoCourse;
use App\VideoPresenter;
use App\VideoTag;
use Illuminate\Support\Facades\DB;

class MyPresentations
{
    public static function IsNullOrEmptyString($str): bool
    {
        return ($str === '%%' || trim($str) === '% %' || $str == null);
    }

    public static function unfiltered_uncat_video_course($dropdownfilter = null, $filterTerm = null)
    {
        /***
         * Administrator Manage
         **/

        $videos_collection = [];

        if($videos_collection = self::filterHandler($dropdownfilter)) {
            $videos_collection = $videos_collection->pluck('id')->toArray();
        }

        if(self::IsNullOrEmptyString($filterTerm)) {

            return Video::orderByDesc('creation')
                ->take(10)->get();

        } else {

            if($videos_collection) {
                //Dropdown collection exist
                //Id and Title
                $videos_match_title = Video::whereIn('id', $videos_collection)
                    ->where('id', 'LIKE', $filterTerm ?? '')
                    ->orwhere('title', 'LIKE', $filterTerm ?? '')
                    ->orWhere('title_en', 'LIKE', $filterTerm ?? '')
                    ->pluck('id')->toArray();

                //Presenter
                $videos_match_presenter = Video::whereIn('id', $videos_collection)
                    ->with('video_presenter.presenter')
                    ->whereHas('video_presenter.presenter', function ($query) use ($filterTerm) {
                        $query->where('username', 'LIKE', $filterTerm ?? '')
                            ->orwhere('name', 'LIKE', $filterTerm ?? '');
                    })->pluck('id')->toArray();

                //Tags
                $videos_match_tag = Video::whereIn('id', $videos_collection)
                    ->with('video_tag.tag')
                    ->whereHas('video_tag.tag', function ($query) use ($filterTerm) {
                        $query->where('name', 'LIKE', $filterTerm ?? '');
                    })->pluck('id')->toArray();

                //Description
                $videos_match_description = Video::whereIn('id', $videos_collection)
                    ->where('description', 'LIKE', $filterTerm ?? '')
                    ->pluck('id')->toArray();

                //Combine queries

                return Video::whereIn('id', $videos_collection)
                    ->whereIn('id', $videos_match_title)
                    ->orWhereIn('id', $videos_match_presenter)
                    ->orWhereIn('id', $videos_match_tag)
                    ->orWhereIn('id', $videos_match_description)
                    ->latest('creation')->get();

            } else {

                //Id and Title
                $videos_match_title = Video::where('id', 'LIKE', $filterTerm ?? '')
                    ->orwhere('title', 'LIKE', $filterTerm ?? '')
                    ->orWhere('title_en', 'LIKE', $filterTerm ?? '')
                    ->pluck('id')->toArray();

                //Presenter
                $videos_match_presenter = Video::with('video_presenter.presenter')
                    ->whereHas('video_presenter.presenter', function ($query) use ($filterTerm) {
                        $query->where('username', 'LIKE', $filterTerm ?? '')
                            ->orwhere('name', 'LIKE', $filterTerm ?? '');
                    })->pluck('id')->toArray();

                //Tags
                $videos_match_tag = Video::with('video_tag.tag')
                    ->whereHas('video_tag.tag', function ($query) use ($filterTerm) {
                        $query->where('name', 'LIKE', $filterTerm ?? '');
                    })->pluck('id')->toArray();

                //Description
                $videos_match_description = Video::where('description', 'LIKE', $filterTerm ?? '')
                    ->pluck('id')->toArray();

                //Combine queries

                return Video::whereIn('id', $videos_match_title)
                    ->orWhereIn('id', $videos_match_presenter)
                    ->orWhereIn('id', $videos_match_tag)
                    ->orWhereIn('id', $videos_match_description)
                    ->latest('creation')->get();
            }

        }

    }

    public static function my_uncat_video_course($user, $filterTerm = null)
    {
        /**
         * CourseAdmin Manage
         */

        //Retrive presentations with individual permissions set
        $individual_videos = IndividualPermission::where('username', $user)->pluck('video_id')->toArray();

        //Retrive presentations where user is presenter
        $presenter = Presenter::where('username', $user)->first();
        $presenter_videos = VideoPresenter::where('presenter_id', $presenter->id ?? 0)->pluck('video_id')->toArray();

        $videos_collection = Video::with('video_course')
            ->whereIn('id', $individual_videos)
            ->orWhereIn('id', $presenter_videos)
            ->orderByDesc('creation')
            ->get();

        if(!self::IsNullOrEmptyString($filterTerm)) {

            //Title
            $videos_match_title = Video::with('video_course')
                ->whereIn('id', $videos_collection->pluck('id')->toArray())
                ->where('id', 'LIKE', $filterTerm ?? '')
                ->orwhere('title', 'LIKE', $filterTerm ?? '')
                ->orWhere('title_en', 'LIKE', $filterTerm ?? '')
                ->pluck('id')->toArray();

            //Presenter
            $videos_match_presenter = Video::with('video_course')
                ->whereIn('id', $videos_collection->pluck('id')->toArray())
                ->with('video_presenter.presenter')
                ->whereHas('video_presenter.presenter', function ($query) use ($filterTerm) {
                    $query->where('username', 'LIKE', $filterTerm ?? '')
                        ->orwhere('name', 'LIKE', $filterTerm ?? '');
                })->pluck('id')->toArray();

            //Tags
            $videos_match_tag = Video::with('video_course')
                ->whereIn('id', $videos_collection->pluck('id')->toArray())
                ->with('video_tag.tag')
                ->whereHas('video_tag.tag', function ($query) use ($filterTerm) {
                    $query->where('name', 'LIKE', $filterTerm ?? '');
                })->pluck('id')->toArray();

            //Description
            $videos_match_description = Video::with('video_course')
                ->whereIn('id', $videos_collection->pluck('id')->toArray())
                ->where('description', 'LIKE', $filterTerm ?? '')
                ->pluck('id')->toArray();

            //Combine queries

            return Video::with('video_course')
                ->whereIn('id', $videos_collection->pluck('id')->toArray())
                ->whereIn('id', $videos_match_title)
                ->orWhereIn('id', $videos_match_presenter)
                ->orWhereIn('id', $videos_match_tag)
                ->orWhereIn('id', $videos_match_description)
                ->latest('creation')->get();

        } else {
            return $videos_collection;
        }
    }

    public static function videopresenters($user)
    {
        //Retrive presentations with individual permissions set
        $individual_videos = IndividualPermission::where('username', $user)->pluck('video_id')->toArray();

        //Retrive presentations where user is presenter
        $presenter = Presenter::where('username', $user)->first();
        $presenter_videos = VideoPresenter::where('presenter_id', $presenter->id ?? 0)->pluck('video_id')->toArray();

        $videos_collection = Video::with('video_course')
            ->whereIn('id', $individual_videos)
            ->orWhereIn('id', $presenter_videos)
            ->orderByDesc('creation')
            ->get();
        return $videos_collection;
    }

    public static function my_uncat_video_course_presenter($user, $selected_presenter = [])
    {
        /**
         * CourseAdmin Manage filter selected presenter
         */

        //Retrive presentations with individual permissions set
        $individual_videos = IndividualPermission::where('username', $user)->pluck('video_id')->toArray();

        //Retrive presentations where user is presenter
        $presenter = Presenter::where('username', $user)->first();
        $selected = Presenter::whereIn('username', $selected_presenter)->pluck('id')->toArray();
        $presenter_videos = VideoPresenter::where('presenter_id', $presenter->id ?? 0)->pluck('video_id')->toArray();

        $videos_collection = Video::with('video_course')
            ->whereIn('id', $individual_videos)
            ->orWhereIn('id', $presenter_videos)
            ->orderByDesc('creation')
            ->pluck('id')->toArray();

        $filtered = VideoPresenter::whereIn('video_id', $videos_collection)->whereIn('presenter_id', $selected)->pluck('video_id')->toArray();
        return Video::whereIn('id', $filtered)->get();
    }

    public static function my_uncat_video_course_tag($user, $selected_tag = [])
    {
        /**
         * CourseAdmin Manage filter selected presenter
         */

        //Retrive presentations with individual permissions set
        $individual_videos = IndividualPermission::where('username', $user)->pluck('video_id')->toArray();

        //Retrive presentations where user is presenter
        $presenter = Presenter::where('username', $user)->first();
        $selected = Tag::whereIn('name', $selected_tag)->pluck('id')->toArray();

        $presenter_videos = VideoPresenter::where('presenter_id', $presenter->id ?? 0)->pluck('video_id')->toArray();

        $videos_collection = Video::with('video_course')
            ->whereIn('id', $individual_videos)
            ->orWhereIn('id', $presenter_videos)
            ->orderByDesc('creation')
            ->pluck('id')->toArray();

        $filtered = VideoTag::whereIn('video_id', $videos_collection)->whereIn('tag_id', $selected)->pluck('video_id')->toArray();

        return Video::whereIn('id', $filtered)->get();

    }

    public static function adminPresenter($selected_presenter = [])
    {
        $selected = Presenter::whereIn('username', $selected_presenter)->pluck('id')->toArray();
        $filtered = VideoPresenter::whereIn('presenter_id', $selected)->pluck('video_id')->toArray();
        return Video::whereIn('id', $filtered)->get();

    }

    public static function adminTerm($selected_term = [])
    {
        $term = array_map(function($semester) { return substr($semester, 0, 2); }, $selected_term );
        $year = array_map(function($year) { return substr($year, 2, 4); }, $selected_term );

        $selected = Course::whereIn('semester', $term)->whereIn('year', $year)->pluck('id')->toArray();
        $filtered = VideoCourse::whereIn('course_id', $selected)->pluck('video_id')->toArray();
        return Video::whereIn('id', $filtered)->get();

    }

    public static function adminTag($selected_tag = [])
    {
        $selected = Tag::whereIn('name', $selected_tag)->pluck('id')->toArray();
        $filtered = VideoTag::whereIn('tag_id', $selected)->pluck('video_id')->toArray();
        return Video::whereIn('id', $filtered)->get();

    }

    public static function filterHandler($filters)
    {
        if($filters) {
            foreach(array_filter($filters) as $key => $filter) {
                if($filter) {
                    switch($key) {
                        case('presenter'):
                            return self::adminPresenter($filter);
                            break;

                        case('tag'):
                            return self::adminTag($filter);
                            break;

                        case('term');
                            return self::adminTerm($filter);
                            break;
                    }

                }
            }
        }
        return false;
    }

}
