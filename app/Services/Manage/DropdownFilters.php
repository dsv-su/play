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
    public function performFiltering($videos, $designations = null, $semesters = null, $tags = null, $presenters = null): array
    {
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

        $videoterms = $this->extractTerms($videos);
        $videotags = $this->extractTags($videos);
        $videopresenters = $this->extractPresenters($videos);
        $video_courses = $this->extractVideoCourses($videos);
        $videos_by_course = $this->groupVideos($videos);

        return array($videoterms, $videopresenters, $videotags, $video_courses, $videos, $videos_by_course);
    }

    /**
     * @param $videos
     * @return array
     */
    public function extractTerms($videos): array
    {
        $terms = array();
        foreach ($videos as $video) {
            foreach ($video->courses() as $course) {
                if (!in_array($course->semester . $course->year, $terms)) {
                    $terms[] = $course->semester . $course->year;
                }
            }
        }
        return $terms;
    }

    /**
     * @param $videos
     * @return array
     */
    public function extractTags($videos): array
    {
        $tags = array();
        foreach ($videos as $video) {
            foreach ($video->tags() as $tag) {
                if (!in_array($tag->name, $tags)) {
                    $tags[] = $tag->name;
                }
            }
        }
        sort($tags);
        return $tags;
    }

    /**
     * @param $videos
     * @return array
     */
    public function extractPresenters($videos): array
    {
        $presenters = array();
        foreach ($videos as $video) {
            foreach ($video->presenters() as $presenter) {
                if (!key_exists($presenter->username, $presenters)) {
                    $presenters[$presenter->username] = $presenter->name;
                }
            }
        }
        array_multisort($presenters);

        return $presenters;
    }

    public function extractVideoCourses(\Illuminate\Support\Collection $videos_collection)
    {
        /***
         * Returns a collection of Video Courses from a collection of Videos
         * the returned collection is returned in the public variable
         * $this->video_courses
         */

        $this->courseAdminFilter();
        $video_ids = $videos_collection->pluck('id')->toArray();
        $v_course_ids = VideoCourse::whereIn('video_id', $video_ids)->pluck('course_id');

        $courseids = [];
        foreach ($v_course_ids as $course_id) {
            if (!key_exists($course_id, $courseids)) {
                $courseids[$course_id] = $course_id;
            }
        }

        $this->video_courses = [];
        //Query depending on user
        if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            return VideoCourse::with('course')
                ->whereHas('video', function ($query) {
                    $query->whereIn('video_id', $this->user_videos)
                        ->orWhereIn('video_id', $this->individual_videos)
                        ->orWhereIn('video_id', $this->courseadministrator)
                        ->orWhereIn('video_id', $this->video_course_ids);
                })
                ->whereIn('course_id', $courseids)
                ->groupBy('course_id')->orderBy('course_id', 'desc')->get();
        } else {
            return VideoCourse::with('course')
                ->whereIn('course_id', $courseids)
                ->groupBy('course_id')->orderBy('course_id', 'desc')->get();
        }
    }

    public function courseAdminFilter()
    {
        $videos_id = [];
        $user = Presenter::where('username', app()->make('play_username'))->first();
        $this->user_videos = VideoPresenter::where('presenter_id', $user->id ?? 0)->pluck('video_id')->toArray();

        //Check if user is course administrator
        $this->courseadministrator = CourseadminPermission::where('username', app()->make('play_username'))
            ->where('permission', 'delete')
            ->pluck('video_id')
            ->toArray();

        //Check for individual permissions settings
        $this->individual_videos = IndividualPermission::where('username', app()->make('play_username'))->where(function ($query) {
            $query->where('permission', 'edit')
                ->orWhere('permission', 'delete');
        })->pluck('video_id')->toArray();

        //Check for course individual settings
        if (count($course_user_admins = CoursesettingsUsers::where('username', app()->make('play_username'))->whereIn('permission', ['edit', 'delete'])->get()) >= 1) {
            foreach ($course_user_admins as $course_user_admin) {
                $videos_id[] = VideoCourse::where('course_id', $course_user_admin->course_id)->pluck('video_id');
            }
        }
        $this->video_course_ids = collect($videos_id)->flatten(1)->toArray();
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
