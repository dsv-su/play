<?php

namespace App\Services\Manage;

use App\IndividualPermission;
use App\Presenter;
use App\Tag;
use App\Video;
use App\VideoPresenter;
use App\VideoTag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class UncatPresentations
{
    public static function IsNullOrEmptyString($str): bool
    {
        return ($str === '%%' || trim($str) === '% %');
    }

    /*public static function uncat_presenter_id($filterTerm): \Illuminate\Support\Collection
    {
        return Video::with('video_presenter.presenter')
            ->whereHas('video_presenter.presenter', function ($query) use ($filterTerm) {
                $query->where('name', 'LIKE', $filterTerm)
                    ->orwhere('name', 'LIKE', $filterTerm);
            })
            ->pluck('id');
    }

    public static function uncat_video_courses($presenter_id)
    {
        return Video::doesntHave('video_course')
            ->whereIn('id', $presenter_id)
            ->orderByDesc('creation')
            ->get();
    }*/

    public static function unfiltered_uncat_video_course($filterTerm = null)
    {
        $videos_collection = Video::doesntHave('video_course')->orderByDesc('creation')->get();
        if($filterTerm) {
            return $filtered_title = $videos_collection->filter(function ($video, $key) use ($filterTerm) {
                $match = preg_replace("/%+/",'$1*', $filterTerm);
                if(Str::is(strtoupper($match), strtoupper($video->title)) or Str::is(strtoupper($match), strtoupper($video->title_en))) {
                    return $video->where('title', 'LIKE', $filterTerm)->get();
                }
                return 0;
            });
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
        $presenter_videos = VideoPresenter::where('presenter_id', $presenter->id)->pluck('video_id')->toArray();

        $videos_collection = Video::whereDoesntHave('video_course')
                ->whereIn('id', $individual_videos)
                ->orwhereDoesntHave('video_course')->WhereIn('id', $presenter_videos)
                ->orderByDesc('creation')
                ->get();

        if($filterTerm) {
            return $filtered_title = $videos_collection->filter(function ($video, $key) use ($filterTerm) {
                $match = preg_replace("/%+/",'$1*', $filterTerm);
                if(Str::is(strtoupper($match), strtoupper($video->title)) or Str::is(strtoupper($match), strtoupper($video->title_en))) {
                    return $video->where('title', 'LIKE', $filterTerm)->get();
                }
                return 0;
            });
        } else {
            return $videos_collection;
        }

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
        $presenter_videos = VideoPresenter::where('presenter_id', $presenter->id)->pluck('video_id')->toArray();

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
        $presenter_videos = VideoPresenter::where('presenter_id', $presenter->id)->pluck('video_id')->toArray();

        $videos_collection = Video::whereDoesntHave('video_course')
            ->whereIn('id', $individual_videos)
            ->orwhereDoesntHave('video_course')->WhereIn('id', $presenter_videos)
            ->orderByDesc('creation')
            ->pluck('id')->toArray();

        $filtered = VideoTag::whereIn('video_id', $videos_collection)->whereIn('tag_id', $selected)->pluck('video_id')->toArray();
        return Video::whereIn('id', $filtered)->get();

    }
}
