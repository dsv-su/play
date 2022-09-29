<?php

namespace App\Services\Manage;

use App\IndividualPermission;
use App\Presenter;
use App\Tag;
use App\Video;
use App\VideoPresenter;
use App\VideoTag;

class UncatPresentations
{
    public static function IsNullOrEmptyString($str): bool
    {
        return ($str === '%%' || trim($str) === '% %');
    }

    public static function unfiltered_uncat_video_course($filterTerm = null)
    {
        $videos_collection = Video::doesntHave('video_course')->orderByDesc('creation')->get();

        if($filterTerm) {
            //Title
            $videos_match_title = Video::doesntHave('video_course')
                ->whereIn('id', $videos_collection->pluck('id')->toArray())
                ->where('title', 'LIKE', $filterTerm ?? '')
                ->orWhere('title_en', 'LIKE', $filterTerm ?? '')
                ->pluck('id')->toArray();

            //Presenter
            $videos_match_presenter = Video::doesntHave('video_course')
                ->whereIn('id', $videos_collection->pluck('id')->toArray())
                ->with('video_presenter.presenter')
                ->whereHas('video_presenter.presenter', function ($query) use ($filterTerm) {
                    $query->where('username', 'LIKE', $filterTerm ?? '')
                        ->orwhere('name', 'LIKE', $filterTerm ?? '');
                })->pluck('id')->toArray();

            //Tags
            $videos_match_tag = Video::doesntHave('video_course')
                ->whereIn('id', $videos_collection->pluck('id')->toArray())
                ->with('video_tag.tag')
                ->whereHas('video_tag.tag', function ($query) use ($filterTerm) {
                    $query->where('name', 'LIKE', $filterTerm ?? '');
                })->pluck('id')->toArray();

            //Combine queries

            return Video::doesntHave('video_course')
                ->whereIn('id', $videos_match_title)
                ->orWhereIn('id', $videos_match_presenter)
                ->orWhereIn('id', $videos_match_tag)
                ->latest('creation')->get();

        } else {
            return $videos_collection;
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

        $videos_collection = Video::whereDoesntHave('video_course')
                ->whereIn('id', $individual_videos)
                ->orwhereDoesntHave('video_course')->WhereIn('id', $presenter_videos)
                ->orderByDesc('creation')
                ->get();

        if($filterTerm) {

            //Title
            $videos_match_title = Video::doesntHave('video_course')
                ->whereIn('id', $videos_collection->pluck('id')->toArray())
                ->where('title', 'LIKE', $filterTerm ?? '')
                ->orWhere('title_en', 'LIKE', $filterTerm ?? '')
                ->pluck('id')->toArray();

            //Presenter
            $videos_match_presenter = Video::doesntHave('video_course')
                ->whereIn('id', $videos_collection->pluck('id')->toArray())
                ->with('video_presenter.presenter')
                ->whereHas('video_presenter.presenter', function ($query) use ($filterTerm) {
                    $query->where('username', 'LIKE', $filterTerm ?? '')
                            ->orwhere('name', 'LIKE', $filterTerm ?? '');
            })->pluck('id')->toArray();

            //Tags
            $videos_match_tag = Video::doesntHave('video_course')
                ->whereIn('id', $videos_collection->pluck('id')->toArray())
                ->with('video_tag.tag')
                ->whereHas('video_tag.tag', function ($query) use ($filterTerm) {
                    $query->where('name', 'LIKE', $filterTerm ?? '');
                })->pluck('id')->toArray();

            //Combine queries

            return Video::doesntHave('video_course')
                ->whereIn('id', $videos_collection->pluck('id')->toArray())
                ->whereIn('id', $videos_match_title)
                ->orWhereIn('id', $videos_match_presenter)
                ->orWhereIn('id', $videos_match_tag)
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

        $videos_collection = Video::whereDoesntHave('video_course')
            ->whereIn('id', $individual_videos)
            ->orwhereDoesntHave('video_course')->WhereIn('id', $presenter_videos)
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

        $videos_collection = Video::whereDoesntHave('video_course')
            ->whereIn('id', $individual_videos)
            ->orwhereDoesntHave('video_course')->WhereIn('id', $presenter_videos)
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

        $videos_collection = Video::whereDoesntHave('video_course')
            ->whereIn('id', $individual_videos)
            ->orwhereDoesntHave('video_course')->WhereIn('id', $presenter_videos)
            ->orderByDesc('creation')
            ->pluck('id')->toArray();

        $filtered = VideoTag::whereIn('video_id', $videos_collection)->whereIn('tag_id', $selected)->pluck('video_id')->toArray();
        return Video::whereIn('id', $filtered)->get();

    }

}
