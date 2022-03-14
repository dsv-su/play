<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseadminPermission;
use App\CoursePermissions;
use App\CoursesettingsPermissions;
use App\CoursesettingsUsers;
use App\IndividualPermission;
use App\Presenter;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Filters\VisibilityFilter;
use App\Tag;
use App\Video;
use App\VideoCourse;
use App\VideoPermission;
use App\VideoPresenter;
use DB;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

/**
 *
 */
class SearchController extends Controller
{
    /** viewBy% and filterBy% methods for viewing presentations that belong to certain entity
     * (course designation, term, category, student) and filtering the output */

    /** Show presentations that belong to the given term
     * @param VisibilityFilter $visibility
     * @param $semester
     * @return Application|Factory|View
     */
    public function viewBySemester(VisibilityFilter $visibility, $semester)
    {
        if ($semester == 'all') {
            $courses = Course::all()->sortBy('created_at');
            $terms = [];
            foreach ($courses as $course) {
                if ($course->videos()->count()) {
                    if (!isset($terms[$course->year])) {
                        $terms[$course->year] = [];
                    }
                    if (!isset($terms[$course->year][$course->semester])) {
                        $terms[$course->year][$course->semester] = 0;
                    }
                    $terms[$course->year][$course->semester] += 1;
                }
            }
            krsort($terms);

            return view('home.allterms', ['terms' => $terms]);
        }
        $term = substr($semester, 0, 2);
        $year = substr($semester, 2, 4);
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($term, $year) {
            return $query->where('year', $year)->where('semester', $term);
        })->get();

        // Visibility
        $videos = $visibility->filter($videos);

        // Extract filters
        $courses = $this->extractCourses($videos);
        $presenters = $this->extractPresenters($videos);
        $tags = $this->extractTags($videos);

        // Group videos by a course
        $videos = $this->groupVideos($videos);

        // Remove irrelevant terms that could be added because of multiple course associations
        $videos = $this->removeIrrelevantTerms($videos, $term, $year);

        return view('home.navigator', compact('term', 'year', 'videos', 'courses', 'presenters', 'tags'));
    }

    /** Filter presentations from a given term by criteria provided by a user form
     * @param $semester
     * @param Request $request
     * @return string
     */
    public function filterBySemester($semester, Request $request): string
    {
        $term = substr($semester, 0, 2);
        $year = substr($semester, 2, 4);
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($term, $year) {
            return $query->where('year', $year)->where('semester', $term);
        })->get();
        $presenters = request('presenter') ? explode(',', request('presenter')) : null;
        $designations = request('course') ? explode(',', request('course')) : null;
        $tags = request('tag') ? explode(',', request('tag')) : null;

        list ($html, $videocourses, $videoterms, $videopresenters, $videotags, $filteredvideos) = $this->performFiltering(
            $videos, $designations, null, $tags, $presenters
        );

        $videos = $this->removeIrrelevantTerms($filteredvideos, $term, $year);

        $html = view('home.courselist', compact('videos'))->render();

        return $html ?: '<h4 class="col my-3 font-weight-light">No presentations found</h4>';
    }

    /** Show presentations that belong to the given course designation
     * @param VisibilityFilter $visibility
     * @param $designation
     * @return Application|Factory|View
     */
    public function viewByDesignation(VisibilityFilter $visibility, $designation)
    {
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($designation) {
            return $query->where('designation', $designation);
        })->orderBy('creation', 'desc')->get();

        // Visibility
        $videos = $visibility->filter($videos);

        // Extract filters
        $terms = $this->extractTerms($videos);
        $presenters = $this->extractPresenters($videos);
        $tags = $this->extractTags($videos);

        // Group videos by a course
        $videos = $this->groupVideos($videos);

        // Remove irrelevant course designations that could be added because of multiple course associations
        $videos = $this->removeIrrelevantDesignations($videos, $designation);

        return view('home.navigator', compact('designation', 'videos', 'terms', 'presenters', 'tags'));
    }

    /** Filter presentations that belong to a given course designtation by criteria provided by a user form
     * @param $designation
     * @param Request $request
     * @return string
     */
    public function filterByDesignation($designation, Request $request): string
    {
        $presenters = request('presenter') ? explode(',', request('presenter')) : null;
        $semesters = request('semester') ? explode(',', request('semester')) : null;
        $tags = request('tag') ? explode(',', request('tag')) : null;
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($designation) {
            return $query->where('designation', $designation);
        })->orderBy('creation', 'desc')->get();

        list ($html, $videocourses, $videoterms, $videopresenters, $videotags, $filteredvideos) = $this->performFiltering(
            $videos, null, $semesters, $tags, $presenters
        );

        $videos = $this->removeIrrelevantDesignations($filteredvideos, $designation);

        $html = view('home.courselist', compact('videos'))->render();

        return $html ?: '<h4 class="col my-3 font-weight-light">No presentations found</h4>';
    }

    /** Show presentations that belong to the given category (currently not used)
     * This method shall be rewritten if used.
     * @param VisibilityFilter $visibility
     * @param $category
     * @return Application|Factory|View
     */
    public function viewByCategory(VisibilityFilter $visibility, $category)
    {
        $videos = Video::with('category', 'video_course.course')->whereHas('category', function ($query) use ($category) {
            return $query->where('category_name', $category);
        })->get();

        //Visibility
        $videos = $visibility->filter($videos);

        $videos = $videos->groupBy(function ($item) {
            return $item->video_course[0]->course['year'] ?? '9999';
        });

        return view('home.navigator', compact('category', 'videos'));
    }

    /** Abstract for viewByStudent filtering method
     * @param $category
     * @param Request $request
     * @return void
     */
    public function filterByCategory($category, Request $request)
    {
        // Perform filtering on /category presentations
    }

    /** Show presentations that belong to the given student
     * @param VisibilityFilter $visibility
     * @param $username
     * @return Application|Factory|View
     */
    public function viewByStudent(VisibilityFilter $visibility, $username)
    {
        $daisy = new DaisyIntegration();
        $courses = $daisy->getActiveStudentCourses($username);
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($courses) {
            return $query->whereIn('course_id', $courses);
        })->get();

        $data['permissions'] = VideoPermission::all();
        $data['latest'] = $visibility->filter($videos);
        return view('home.index', $data);
    }

    /** Abstract for viewByStudent filtering method
     * @param $username
     * @param Request $request
     * @return void
     */
    public function filterByStudent($username, Request $request)
    {
        // Perform filtering on /student presentations
    }

    /**
     * @param VisibilityFilter $visibility
     * @param $courseid
     * @return Application|Factory|View
     */
    public function viewByCourse(VisibilityFilter $visibility, $courseid)
    {
        if ($courseid == 'all') {
            $courses = Course::all()->unique('designation')->sortBy('designation');
            foreach ($courses as $ckey => $course) {
                $instances = Course::where('designation', $course->designation)->orderByDesc('created_at')->get();
                $terms = [];
                foreach ($instances as $ikey => $instance) {
                    if ($instance->videos()->count()) {
                        if ($instance->semester == 'VT') {
                            $key = $instance->year . '1';
                        } else {
                            $key = $instance->year . '2';
                        }
                        $terms[$key] = $instance->semester . $instance->year;
                    }
                    $course->name_en = $instance->name_en;
                    $course->name = $instance->name;
                }
                if (empty($terms)) {
                    unset($courses[$ckey]);
                } else {
                    krsort($terms);
                    $course->terms = $terms;
                }
            }
            return view('home.allcourses', ['courses' => $courses]);
        }
        $data['course'] = Course::find($courseid);
        $data['latest'] = Course::find($courseid)->videos()->filter(function ($video) {
            return $video;
        });
        $data['latest'] = $visibility->filter($data['latest']);
        return view('home.index', $data);
    }

    /**
     * @param VisibilityFilter $visibility
     * @param $tag
     * @return Application|Factory|View
     */
    public function viewByTag(VisibilityFilter $visibility, $tag)
    {
        $tagid = Tag::where('name', $tag)->firstOrFail()->id;
        $videos = Video::with('video_tag.tag')->whereHas('video_tag.tag', function ($query) use ($tagid) {
            return $query->where('id', $tagid);
        })->orderBy('creation', 'desc')->get();

        // Visibility
        $videos = $visibility->filter($videos);

        // Extract filters
        $terms = $this->extractTerms($videos);
        $presenters = $this->extractPresenters($videos);
        $courses = $this->extractCourses($videos);

        // Group videos by a course
        $videos = $this->groupVideos($videos);

        return view('home.navigator', compact('tag', 'videos', 'terms', 'presenters', 'courses'));
    }

    /** Filter presentations with a given tag by criteria provided by a user form
     * @param $tag
     * @param Request $request
     * @return string
     */
    public function filterByTag($tag, Request $request): string
    {
        $tagid = Tag::where('name', $tag)->firstOrFail()->id;
        $videos = Video::with('video_tag.tag')->whereHas('video_tag.tag', function ($query) use ($tagid) {
            return $query->where('id', $tagid);
        })->orderBy('creation', 'desc')->get();
        $designations = request('course') ? explode(',', request('course')) : null;
        $semesters = request('semester') ? explode(',', request('semester')) : null;
        $presenters = request('presenter') ? explode(',', request('presenter')) : null;
        list ($html, $videocourses, $videoterms, $videopresenters, $videotags, $videos) = $this->performFiltering(
            $videos, $designations, $semesters, null, $presenters
        );

        $html = view('home.courselist', compact('videos'))->render();

        return $html ?: '<h4 class="col my-3 font-weight-light">No presentations found</h4>';
    }

    /**
     * @param VisibilityFilter $visibility
     * @param $username
     * @return Application|Factory|View
     */
    public function viewByPresenter(VisibilityFilter $visibility, $username)
    {
        $presenter = Presenter::where('username', $username)->first() ?? Presenter::where('name', $username)->first();
        if (!$presenter) {
            abort(404);
        }
        $videos = Video::with('video_presenter.presenter')->whereHas('video_presenter.presenter', function ($query) use ($presenter) {
            return $query->where('id', $presenter->id);
        })->orderBy('creation', 'desc')->get();

        //Visibility
        $videos = $visibility->filter($videos);

        // Extract filters
        $terms = $this->extractTerms($videos);
        $tags = $this->extractTags($videos);
        $courses = $this->extractCourses($videos);

        // Group videos by a course
        $videos = $this->groupVideos($videos);

        return view('home.navigator', compact('presenter', 'videos', 'terms', 'tags', 'courses'));
    }

    /** Filter presentations from a given presenter by criteria provided by a user form
     * @param $username
     * @param Request $request
     * @return string
     */
    public function filterByPresenter($username, Request $request): string
    {
        $presenter = Presenter::where('username', $username)->first() ?? Presenter::where('name', $username)->first();
        $videos = Video::with('video_presenter.presenter')->whereHas('video_presenter.presenter', function ($query) use ($presenter) {
            return $query->where('id', $presenter->id);
        })->orderBy('creation', 'desc')->get();
        $designations = request('course') ? explode(',', request('course')) : null;
        $semesters = request('semester') ? explode(',', request('semester')) : null;
        $tags = request('tag') ? explode(',', request('tag')) : null;
        list ($html, $videocourses, $videoterms, $videopresenters, $videotags, $videos) = $this->performFiltering(
            $videos, $designations, $semesters, null, $tags
        );

        $html = view('home.courselist', compact('videos'))->render();

        return $html ?: '<h4 class="col my-3 font-weight-light">No presentations found</h4>';
    }

    /** Primary method that lists all videos related to the search query (or all if $q is null)
     * @throws BindingResolutionException
     */
    public function search($q = null, Request $request = null)
    {
        $videos = $this->getVideos($q);
        $videocourses = $this->extractCourses($videos);
        $videopresenters = $this->extractPresenters($videos);
        $videoterms = $this->extractTerms($videos);
        $videotags = $this->extractTags($videos);
        $manage = \Request::is('manage');

        // Group videos by a courseid
        $videos = $this->groupVideos($videos);

        $coursesetlist = $individual_permissions = $playback_permissions = [];
        if ($manage) {
            list($coursesetlist, $individual_permissions, $playback_permissions) = $this->extractSettings($videos);
        }

        return view('home.search', compact('videos', 'q', 'videocourses', 'videopresenters', 'videoterms', 'videotags', 'manage', 'coursesetlist', 'playback_permissions', 'individual_permissions'));
    }

    /** Helper method for getting all videos related to the search query (or all if query is empty)
     * @throws BindingResolutionException
     */
    public function getVideos($q)
    {
        $visibility = app(VisibilityFilter::class);
        if ($q) {
            $videos = Video::with('video_course.course', 'video_presenter.presenter', 'video_tag.tag')
                ->whereHas('video_presenter.presenter', function ($query) use ($q) {
                    return $query->where('username', 'LIKE', "%$q%")->orWhere('name', 'LIKE', "%$q%");
                })
                ->orWhereHas('video_course.course', function ($query) use ($q) {
                    return $query->where('title', 'LIKE', "%$q%")->orwhere(DB::raw('concat(semester,year)'), 'LIKE', "%$q%");
                })
                ->orWhere('title', 'LIKE', "%$q%")
                ->orwhereHas('video_tag.tag', function ($query) use ($q) {
                    return $query->where('name', 'LIKE', "%$q%");
                })
                ->orderBy('creation', 'desc')
                ->get();

            return $visibility->filter($videos);

        } else {
            if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {

                //If user is courseadmin, uploader or staff
                $videos_id = [];
                $user = Presenter::where('username', app()->make('play_username'))->first();
                $user_videos = VideoPresenter::where('presenter_id', $user->id ?? 0)->pluck('video_id');

                //Check if user is course administrator
                $courseadministrator = CourseadminPermission::where('username', app()->make('play_username'))->where('permission', 'delete')->pluck('video_id');

                //Check for individual permissions settings
                $individual_videos = IndividualPermission::where('username', app()->make('play_username'))->where(function ($query) {
                    $query->where('permission', 'edit')
                        ->orWhere('permission', 'delete');
                })->pluck('video_id');

                //Check for course individual settings
                if (count($course_user_admins = CoursesettingsUsers::where('username', app()->make('play_username'))->whereIn('permission', ['edit', 'delete'])->get()) >= 1) {
                    foreach ($course_user_admins as $course_user_admin) {
                        $videos_id[] = VideoCourse::where('course_id', $course_user_admin->course_id)->pluck('video_id');
                    }
                }
                $video_course_ids = collect($videos_id)->flatten(1)->toArray();

                return $visibility->filter(Video::whereIn('id', $user_videos)->orWhereIn('id', $individual_videos)->orWhereIn('id', $courseadministrator)->orWhereIn('id', $video_course_ids)->latest('creation')->get());

            } elseif (app()->make('play_role') == 'Administrator') {
                return $visibility->filter(Video::with('category', 'video_course.course')->latest('creation')->get());
            }
        }

        return false;
    }

    /** Group presentations by a course they belong to
     * @param $videos
     * @return Collection
     */
    public function groupVideos($videos): Collection
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
                if (!isset($groupedvideos[0])) {
                    $groupedvideos[0] = Collection::empty();
                }
                $groupedvideos[0]->add($video);
            }
        }

        return $groupedvideos;
    }

    /** Remove irrelevant terms that could be added because of multiple course associations
     * @param $videos
     * @param $term
     * @param $year
     * @return mixed
     */
    public function removeIrrelevantTerms($videos, $term, $year)
    {
        foreach ($videos as $courseid => $videocourse) {
            $course = Course::find($courseid);
            if ($course->semester !== $term || $course->year !== $year) {
                $videos->forget($courseid);
            }
        }
        return $videos;
    }

    /** Remove irrelevant course designations that could be added because of multiple course associations
     * @param $videos
     * @param $designation
     * @return mixed
     */
    public function removeIrrelevantDesignations($videos, $designation)
    {
        foreach ($videos as $courseid => $videocourse) {
            if (Course::find($courseid)->designation !== $designation) {
                $videos->forget($courseid);
            }
        }
        return $videos;
    }

    /** Generate an array with course level settings, individual permissions and playback group permissions
     * @param $videos
     * @return array[]
     */
    public function extractSettings($videos): array
    {
        $coursesetlist = $individual_permissions = $playback_permissions = [];
        foreach ($videos as $courseid => $videolist) {
            if ($courseSettings = CoursesettingsPermissions::where('course_id', $courseid)->first()) {
                //Visibility
                $coursesetlist[$courseid]['visibility'] = $courseSettings->visibility;
                //Downloadable
                $coursesetlist[$courseid]['downloadable'] = $courseSettings->downloadable;
            }
            //Individual users
            $individual_permissions[$courseid] = CoursesettingsUsers::where('course_id', $courseid)->count();
            //Group permissions
            $playback_permissions[$courseid] = CoursePermissions::where('course_id', $courseid)->first();
        }
        return array($coursesetlist, $individual_permissions, $playback_permissions);
    }

    /** Method for search autocomplete suggestions
     * @param Request $request
     * @return mixed
     */
    public function find(Request $request)
    {
        $courses = Course::search($request->get('query'), null, true, true)->groupBy('designation')->orderBy('year', 'desc')->take(2)->get();
        $videos = Video::search($request->get('query'), null, true, true)->orderBy('creation', 'desc');
        $tags = Tag::search($request->get('query'), null, true, true)->take(3)->get();
        $presenters = Presenter::search($request->get('query'), null, true, true)->take(3)->get();
        $count = $courses->count() + $tags->count() + $presenters->count();

        return $courses->concat($tags)->concat($presenters)->concat($videos->take(15 - $count)->get());
    }

    /**
     * @param $videos
     * @return array
     */
    public function extractCourses($videos): array
    {
        $courses = array('nocourse' => __('No course association'));
        foreach ($videos as $video) {
            foreach ($video->courses() as $course) {
                if (!in_array($course->name, $courses)) {
                    if (Lang::locale() == 'swe') {
                        $courses[$course->designation] = $course->name;
                    } else {
                        $courses[$course->designation] = $course->name_en;
                    }

                }
            }
        }
        return $courses;
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
        return $presenters;
    }

    /** Filter search results by criteria provided by a user form
     * @throws BindingResolutionException
     */
    public function filterSearch($q = null, Request $request): array
    {
        $html = '';
        $videos = $this->getVideos($q);
        $designations = request('course') ? explode(',', request('course')) : null;
        $semesters = request('semester') ? explode(',', request('semester')) : null;
        $presenters = request('presenter') ? explode(',', request('presenter')) : null;
        $tags = request('tag') ? explode(',', request('tag')) : null;
        $manage = \Request::is('manage');
        list ($html, $videocourses, $videoterms, $videopresenters, $videotags) = $this->performFiltering(
            $videos, $designations, $semesters, $tags, $presenters, $manage
        );
        return ['html' => $html, 'courses' => $videocourses, 'presenters' => $videopresenters, 'terms' => $videoterms, 'tags' => $videotags];
    }

    /** Perform the actual filtering of search/designation/presenter/term/tag results
     * @param $videos
     * @param $designations
     * @param $semesters
     * @param $tags
     * @param $presenters
     * @param $manage
     * @return array
     */
    public function performFiltering($videos, $designations = null, $semesters = null, $tags = null, $presenters = null, $manage = false): array
    {
        $html = '';
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
                $html .= '<div class="col my-3">' . view('home.video', ['video' => $video, 'manage' => $manage])->render() . '</div>';
            } else {
                unset($videos[$key]);
            }
        }
        if ($html) {
            $html .= '<div class="col"><div class="card video my-0 mx-auto"></div></div>
                        <div class="col"><div class="card video my-0 mx-auto"></div></div>
                        <div class="col"><div class="card video my-0 mx-auto"></div></div>';
        } else {
            $html .= '<h4 class="col my-3 font-weight-light">No presentations found</h4>';
        }


        $videocourses = $this->extractCourses($videos);
        $videoterms = $this->extractTerms($videos);
        $videotags = $this->extractTags($videos);
        $videopresenters = $this->extractPresenters($videos);

        $videos = $this->groupVideos($videos);

        $coursesetlist = $individual_permissions = $playback_permissions = [];
        if ($manage) {
            list($coursesetlist, $individual_permissions, $playback_permissions) = $this->extractSettings($videos);
        }

        $html = view('home.courselist', compact('videos', 'manage', 'coursesetlist', 'individual_permissions', 'playback_permissions'))->render();

        return array($html, $videocourses, $videoterms, $videopresenters, $videotags, $videos);
    }
}
