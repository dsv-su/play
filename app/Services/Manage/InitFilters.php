<?php

namespace App\Services\Manage;

use App\Video;
use Illuminate\Database\Eloquent\Collection;

class InitFilters
{
    public function performFiltering($videocourses, $designations = null, $semesters = null, $tags = null, $presenters = null): array
    {

        $videoterms = $this->extractTerms($videocourses);
        $videotags = $this->extractTags($videocourses);
        $videopresenters = $this->extractPresenters($videocourses);
        $videos_by_course = $this->groupVideos($videocourses);

        return array($videoterms, $videopresenters, $videotags, $videos_by_course);
    }

    public function groupVideos($videocourses): \Illuminate\Support\Collection
    {
        $groupedvideos = Collection::empty();
        foreach ($videocourses as $vc) {
            if ($vc->count()) {

                if (!isset($groupedvideos[$vc->course_id])) {
                    $groupedvideos[$vc->course_id] = Collection::empty();
                }
                $groupedvideos[$vc->course_id]->add(Video::find($vc->video_id));

            } else {
                if (!isset($groupedvideos[999999])) {
                    $groupedvideos[999999] = Collection::empty();
                }
                $groupedvideos[999999]->add(Video::find($vc->video_id));
            }
        }

        // Sort the array of videos, also sort the keys (=course ids)
        foreach ($groupedvideos as $courseid => $videos) {
            $groupedvideos[$courseid] = $videos->sortByDesc('creation');
        }
        $items = $groupedvideos->all();
        krsort($items);
        return collect($items);
    }

    public function extractTags($videocourses): array
    {
        $tags = array();
        foreach ($videocourses as $vc) {
            foreach (Video::find($vc->video_id)->tags() as $tag) {
                if (!in_array($tag->name, $tags)) {
                    $tags[] = $tag->name;
                }
            }
        }
        sort($tags);
        return $tags;
    }

    public function extractTerms($videocourses): array
    {
        $terms = array();
        foreach ($videocourses as $vc) {
            if (!in_array($vc->course->semester . $vc->course->year, $terms)) {
                $terms[] = $vc->course->semester . $vc->course->year;
            }
        }
        /*Sorting
         * $terms = collect($terms)->sortByDesc(function($item){
            return $item;
        })->values()->toArray();*/
        return $terms;
    }

    public function extractPresenters($videocourses): array
    {
        $presenters = array();
        foreach ($videocourses as $vc) {
            foreach (Video::find($vc->video_id)->presenters() as $presenter) {
                if (!key_exists($presenter->username, $presenters)) {
                    $presenters[$presenter->username] = $presenter->name;
                }
            }
        }
        array_multisort($presenters);

        return $presenters;
    }
}
