<?php

namespace App\Services\Manage;

use App\CourseadminPermission;
use App\CoursesettingsUsers;
use App\IndividualPermission;
use App\Presenter;
use App\Services\Filters\VisibilityFilter;
use App\Video;
use App\VideoCourse;
use App\VideoPresenter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Lang;

class DropdownFilters
{
    protected $user_videos, $courseadministrator, $individual_videos, $video_course_ids;


    /** Reads GET parameters from the url.
     * @return null[]
     */
    public function handleUrlParams(): array
    {
        return [
            'course' => request('course') ? request('course') : null,
            'presenter' => request('presenter') ? request('presenter') : null,
            'term' => request('term') ? request('term') : null,
            'tag' => request('tag') ? request('tag') : null,
            'filterTerm' => request('filterTerm') ? request('filterTerm') : null
        ];
    }

    /** Perform the actual filtering of search/designation/presenter/term/tag results
     * @param $videos
     * @param $designations
     * @param $semesters
     * @param $tags
     * @param $presenters
     * @return array
     */
    public function performFiltering($videos = null, $unfiltered_videos = null, $designations = null, $semesters = null, $tags = null, $presenters = null, $filterTerm = null): array
    {
        if($videos) {
            foreach ($videos as $key => $video) {
                $found = false;
                $tagfound = true;
                $presenterfound = false;
                if ($designations || $semesters) {
                    foreach ($video->courses() as $course) {
                        if ((!$semesters || in_array($course->semester . $course->year, $semesters)) && (!$designations || in_array($course->designation, $designations))) {
                            $found = true;
                        }
                    }
                    if ($designations && in_array('nocourse', $designations) && $video->courses()->isEmpty()) {
                        $found = true;
                    }
                } else {
                    $found = true;
                }
                if ($tags) {
                    foreach ($tags as $tag) {
                        if (!in_array($tag, array_map(function ($t) {
                            return $t['name'];
                        }, $video->tags()->toArray()))) {
                            $tagfound = false;
                        }
                    }
                }
                if ($presenters) {
                    foreach ($video->presenters() as $presenter) {
                        if (in_array($presenter->username, $presenters)) {
                            $presenterfound = true;
                        }
                    }
                } else {
                    $presenterfound = true;
                }
                if ($found && $tagfound && $presenterfound) {
                } else {
                    unset($videos[$key]);
                }
            }
        }


        $videoterms = $this->extractTerms($videos);
        $videotags = $this->extractTags($videos);
        $videopresenters = $this->extractPresenters($videos);
        if($videos) {
            $video_courses = $this->extractVideoCourses($videos , $unfiltered_videos, $filterTerm);
            $videos_by_course = $this->groupVideos($videos);
        } else {
            $video_courses = [];
            $videos_by_course = [];
        }




        return array($videoterms, $videopresenters, $videotags, $video_courses, $videos, $videos_by_course);
    }

    /**
     * @param $videos
     * @return array
     */
    public function extractTerms($videos): array
    {
        $terms = array();
        if($videos) {
            foreach ($videos as $video) {
                foreach ($video->video_course as $vc) {
                    if (!in_array($vc->course->semester . $vc->course->year, $terms)) {
                        $terms[] = $vc->course->semester . $vc->course->year;
                    }
                }
            }
        }

        /*Sorting
         * $terms = collect($terms)->sortByDesc(function($item){
            return $item;
        })->values()->toArray();*/
        return $terms;
    }

    /**
     * @param $videos
     * @return array
     */
    public function extractTags($videos): array
    {
        $tags = array();
        if($videos) {
            foreach ($videos as $video) {
                foreach ($video->video_tag as $vt) {
                    if (!in_array($vt->tag->name, $tags)) {
                        $tags[] = $vt->tag->name;
                    }
                }
            }
            sort($tags);
        }

        return $tags;
    }

    /**
     * @param $videos
     * @return array
     */
    public function extractPresenters($videos): array
    {
        $presenters = array();
        if($videos) {
            foreach ($videos as $video) {
                foreach ($video->video_presenter as $vp) {
                    if (!key_exists($vp->presenter->username, $presenters)) {
                        $presenters[$vp->presenter->username] = $vp->presenter->name;
                    }
                }
            }
            array_multisort($presenters);
        }

        return $presenters;
    }

    public function extractVideoCourses(\Illuminate\Support\Collection $videos_collection, $unfiltered_videos = [], $filterTerm)
    {
        $filterTerm = implode($filterTerm);
        $filterTerm = '%' . $filterTerm . '%';

        //Extract ids from collection
        $video_ids = $videos_collection->pluck('id')->toArray();

        //Extract and filter Video_Courses
        $video_course_ids = VideoCourse::select('course_id')->distinct()->whereIn('video_id', $video_ids)->pluck('course_id');

        //Filter and query course specific attributes
        return VideoCourse::with('course')
            ->whereIn('course_id', $video_course_ids)
            ->orwhereIn('video_id', $unfiltered_videos)
            ->whereHas('course', function ($query) use ($filterTerm) {
                $query->where('id', 'LIKE', $filterTerm)
                    ->orWhere('name', 'LIKE', $filterTerm)
                    ->orWhere('name_en', 'like', $filterTerm)
                    ->orWhere('designation', 'LIKE', $filterTerm)
                    ->orWhere('semester', 'LIKE', $filterTerm)
                    ->orWhere('year', 'LIKE', $filterTerm);
            })
            ->groupBy('course_id')->orderBy('course_id', 'desc')
            ->get();

    }

    /** Group presentations by a course they belong to
     * @param $videos
     * @return \Illuminate\Support\Collection|\Tightenco\Collect\Support\Collection
     */
    public function groupVideos($videos): \Illuminate\Support\Collection
    {
        $groupedvideos = Collection::empty();
        foreach ($videos as $video) {
            if ($video->video_course->count()) {
                foreach ($video->video_course as $vc) {
                    if (!isset($groupedvideos[$vc->course_id])) {
                        $groupedvideos[$vc->course_id] = Collection::empty();
                    }
                    $groupedvideos[$vc->course_id]->add($video);
                }
            } else {
                if (!isset($groupedvideos[999999])) {
                    $groupedvideos[999999] = Collection::empty();
                }
                $groupedvideos[999999]->add($video);
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

    public function loadVideos($videos, $course_id): \Illuminate\Support\Collection
    {
        return $videos->filter(function ($video, $key) use($course_id) {
            foreach($video->courses() as $course) {
                if($course->id === $course_id) {
                    return $video;
                }
            }
            return 0;
        });
    }
}
