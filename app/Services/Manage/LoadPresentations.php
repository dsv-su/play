<?php

namespace App\Services\Manage;

use App\Video;
use Illuminate\Database\Eloquent\Collection;

class LoadPresentations
{
    public function queryTitle($courseid, $term = null)
    {
        /***
         * Loads presentations for a specific courseId
         * Filters after title, presenters and tags
         * Returns a video collection
         */

        //Retrive presentations matching courseId
        $videos_in_course = Video::with('video_course.course')
            ->whereHas('video_course.course', function ($query) use ($courseid) {
                $query->where('course_id', $courseid);
            })
            ->pluck('id')->toArray();


        //If a search term exists
        if($term) {
            //Match with title
            $videos_match_title = Video::whereIn('id', $videos_in_course)
                                    ->where('title', 'LIKE', $term)
                                    ->pluck('id')->toArray();

            //Match with presenters
            $videos_with_presenters = Video::whereIn('id', $videos_in_course)
                ->whereHas('video_presenter.presenter', function ($query) use ($term) {
                    $query->where('username', 'LIKE', $term)
                        ->orwhere('name', 'LIKE', $term);
                })
                ->pluck('id')->toArray();

            //Match with tags
            $videos_with_tags = Video::whereIn('id', $videos_in_course)
                ->whereHas('video_tag.tag', function ($query) use ($term) {
                    $query->where('name', 'LIKE', $term);
                })
                ->pluck('id')->toArray();

            //Create collection
            $videos_collection = Video::with('video_course.course', 'video_presenter.presenter')
                ->whereIn('id', $videos_in_course)
                ->whereIn('id', $videos_with_presenters)
                ->orWhereIn('id', $videos_match_title)
                ->orWhereIn('id', $videos_with_tags)
                ->latest('creation')->get();

        } else {
            //If a search term doesnt exist
            //Create collection
            $videos_collection = Video::with('video_course.course', 'video_presenter.presenter')
                ->whereIn('id', $videos_in_course)
                ->latest('creation')->get();
        }

        return $videos_collection;
    }

    public function queryCollection(Collection $collection, $courseid, $term = null)
    {
        /***
         * Loads presentations for a specific courseId
         * Filters after title, presenters and tags
         * Returns a video collection
         */

        //Retrive presentations matching courseId
        $collection->pluck('id')->toArray();


        //If a search term exists
        if($term) {
            //Match with title
            $videos_match_title = Video::whereIn('id', $videos_in_course)
                ->where('title', 'LIKE', $term)
                ->pluck('id')->toArray();

            //Match with presenters
            $videos_with_presenters = Video::whereIn('id', $videos_in_course)
                ->whereHas('video_presenter.presenter', function ($query) use ($term) {
                    $query->where('username', 'LIKE', $term)
                        ->orwhere('name', 'LIKE', $term);
                })
                ->pluck('id')->toArray();

            //Match with tags
            $videos_with_tags = Video::whereIn('id', $videos_in_course)
                ->whereHas('video_tag.tag', function ($query) use ($term) {
                    $query->where('name', 'LIKE', $term);
                })
                ->pluck('id')->toArray();

            //Create collection
            $videos_collection = Video::with('video_course.course', 'video_presenter.presenter')
                ->whereIn('id', $videos_in_course)
                ->whereIn('id', $videos_with_presenters)
                ->orWhereIn('id', $videos_match_title)
                ->orWhereIn('id', $videos_with_tags)
                ->latest('creation')->get();

        } else {
            //If a search term doesnt exist
            //Create collection
            $videos_collection = Video::with('video_course.course', 'video_presenter.presenter')
                ->whereIn('id', $videos_in_course)
                ->latest('creation')->get();
        }

        return $videos_collection;
    }
}
