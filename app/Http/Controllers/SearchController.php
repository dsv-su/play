<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseadminPermission;
use App\CoursePermissions;
use App\CoursesettingsPermissions;
use App\CoursesettingsUsers;
use App\CourseTag;
use App\IndividualPermission;
use App\Presenter;
use App\Services\Daisy\DaisyAPI;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Filters\VisibilityFilter;
use App\Services\Ldap\SukatUser;
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
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Lang;
use stdClass;

/**
 *
 */
class SearchController extends Controller
{
    /** viewBy% and filterBy% methods for viewing presentations that belong to certain entity
     * (course designation, term, category, student) and filtering the output */

    /*public function __construct()
    {
        //For session history
        $this->middleware('redirect-links');
    }*/

    /**
     * @param VisibilityFilter $visibility
     * @param $semester
     * @param Request $request
     * @return Application|Factory|View|string
     */
    public function viewBySemester(VisibilityFilter $visibility, $semester, Request $request)
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

        $videos = $visibility->filter(Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($term, $year) {
            return $query->where('year', $year)->where('semester', $term);
        })->get());

        $filters = $this->handleUrlParams();

        list ($courses, $terms, $presenters, $tags, $videos) = $this->performFiltering(
            $videos, $filters['courses'], $filters['terms'], $filters['tags'], $filters['presenters']
        );

        // Remove irrelevant terms that could be added because of multiple course associations
        $videos = $this->removeIrrelevantTerms($videos, $term, $year);
        $videoformat = Cookie::get('videoformat') ?? 'grid';

        $tagged = [];
        foreach ($videos as $courseid => $coursevideos) {
            $coursetags = CourseTag::where('course_id', $courseid)->get();
            if (count($coursetags)) {
                $tagged[$courseid] = $this->groupByTags($coursetags, $coursevideos);
            }
        }

        if ($request->isMethod('get')) {
            return view('home.navigator', compact('term', 'year', 'videos', 'courses', 'presenters', 'tags', 'filters', 'tagged', 'videoformat'));
        } else {
            return view('home.courselist', compact('videos', 'tagged', 'videoformat'))->render();
        }
    }

    /** Show presentations that belong to the given course designation
     * @param VisibilityFilter $visibility
     * @param $designation
     * @param Request $request
     * @return Application|Factory|View|string
     */
    public function viewByDesignation(VisibilityFilter $visibility, $designation, Request $request)
    {
        $videos = $visibility->filter(Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($designation) {
            return $query->where('designation', $designation);
        })->get());

        $filters = $this->handleUrlParams();
        list($courses, $terms, $presenters, $tags, $videos) = $this->performFiltering(
            $videos, $filters['courses'], $filters['terms'], $filters['tags'], $filters['presenters']
        );

        // Remove irrelevant course designations that could be added because of multiple course associations
        $videos = $this->removeIrrelevantDesignations($videos, $designation);
        $videoformat = Cookie::get('videoformat') ?? 'grid';
        $tagged = [];
        foreach ($videos as $courseid => $coursevideos) {
            $coursetags = CourseTag::where('course_id', $courseid)->get();
            if (count($coursetags)) {
                $tagged[$courseid] = $this->groupByTags($coursetags, $coursevideos);
            }
        }

        if ($request->isMethod('get')) {
            return view('home.navigator', compact('designation', 'videos', 'terms', 'presenters', 'tags', 'filters', 'tagged', 'videoformat'));
        } else {
            return view('home.courselist', compact('videos', 'tagged', 'videoformat'))->render();
        }
    }


    /** Show presentations that belong to the given category (currently not used)
     * This method shall be rewritten if used.
     * @param VisibilityFilter $visibility
     * @param $category
     * @return Application|Factory|View
     */
    public function viewByCategory(VisibilityFilter $visibility, $category)
    {
        $videos = $visibility->filter(Video::with('category', 'video_course.course')->whereHas('category', function ($query) use ($category) {
            return $query->where('category_name', $category);
        })->get());

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
        if (!$data['course']) {
            abort(404);
        }
        $tags = CourseTag::where('course_id', $courseid)->get();
        $data['latest'] = $visibility->filter(Course::find($courseid)->videos()->filter(function ($video) {
            return $video;
        }));

        if (count($tags)) {
            $data['tagged'] = $this->groupByTags($tags, $data['latest']);
        }

        return view('home.index', $data);
    }

    /**
     * @param $tags
     * @param $videos
     * @return array
     */
    public function groupByTags($tags, $videos): array
    {
        $tagged = [];
        foreach ($tags as $tag) {
            $tagname = Tag::find($tag->tag_id)->name;
            foreach ($videos as $video) {
                if ($video->has_tag($tag->tag_id)) {
                    $tagged[$tagname][] = $video;
                }
            }
        }
        $temparr = array_reduce($tagged, 'array_merge', array());
        foreach ($videos as $video) {
            if (!in_array($video, $temparr)) {
                $tagged['0'][] = $video;
            }
        }
        return $tagged;
    }

    /**
     * @param VisibilityFilter $visibility
     * @param $tag
     * @param Request $request
     * @return Application|Factory|View|string
     */
    public
    function viewByTag(VisibilityFilter $visibility, $tag, Request $request)
    {
        $tagid = Tag::where('name', $tag)->firstOrFail()->id;
        $videos = $visibility->filter(Video::with('video_tag.tag')->whereHas('video_tag.tag', function ($query) use ($tagid) {
            return $query->where('id', $tagid);
        })->orderBy('creation', 'desc')->get());

        $filters = $this->handleUrlParams();
        list ($courses, $terms, $presenters, $tags, $videos) = $this->performFiltering(
            $videos, $filters['courses'], $filters['terms'], $filters['tags'], $filters['presenters']
        );

        $videoformat = Cookie::get('videoformat') ?? 'grid';

        if ($request->isMethod('get')) {
            return view('home.navigator', compact('tag', 'videos', 'terms', 'presenters', 'courses', 'filters', 'videoformat'));
        } else {
            return view('home.courselist', compact('videos', 'videoformat'))->render();
        }
    }

    /**
     * @param VisibilityFilter $visibility
     * @param $username
     * @param Request $request
     * @return Application|Factory|View|string
     */
    public
    function viewByPresenter(VisibilityFilter $visibility, $username, Request $request)
    {
        $presenter = Presenter::where('username', $username)->first() ?? Presenter::where('name', $username)->first();
        if (!$presenter) {
            abort(404);
        }
        $videos = $visibility->filter(Video::with('video_presenter.presenter')->whereHas('video_presenter.presenter', function ($query) use ($presenter) {
            return $query->where('id', $presenter->id);
        })->orderBy('creation', 'desc')->get());

        $filters = $this->handleUrlParams();

        list ($courses, $terms, $presenters, $tags, $videos) = $this->performFiltering(
            $videos, $filters['courses'], $filters['terms'], $filters['tags'], $filters['presenters']
        );

        $videoformat = Cookie::get('videoformat') ?? 'grid';
        $tagged = [];
        foreach ($videos as $courseid => $coursevideos) {
            $coursetags = CourseTag::where('course_id', $courseid)->get();
            if (count($coursetags)) {
                $tagged[$courseid] = $this->groupByTags($coursetags, $coursevideos);
            }
        }

        if ($request->isMethod('get')) {
            return view('home.navigator', compact('presenter', 'videos', 'terms', 'tags', 'courses', 'filters', 'tagged', 'videoformat'));
        } else {
            return view('home.courselist', compact('videos', 'tagged', 'videoformat'))->render();
        }
    }


    /** Primary method that lists all videos related to the search query (or all if $q is null)
     * @throws BindingResolutionException
     */
    public
    function search($q = null)
    {
        $videos = $this->getVideos($q) ?? Collection::empty();

        $manage = \Request::is('manage');

        $filters = $this->handleUrlParams();

        list ($videocourses, $videoterms, $videopresenters, $videotags, $videos) = $this->performFiltering(
            $videos, $filters['courses'], $filters['terms'], $filters['tags'], $filters['presenters']
        );

        list($coursesetlist, $individual_permissions, $playback_permissions) = $this->extractSettings($videos);

        $videoformat = Cookie::get('videoformat') ?? 'grid';

        if (\Request::isMethod('get')) {
            return view('home.search', compact('videos', 'q', 'videocourses', 'videopresenters', 'videoterms', 'videotags', 'manage', 'filters', 'coursesetlist', 'individual_permissions', 'playback_permissions', 'videoformat'));
        } else {
            return ['html' => view('home.courselist', compact('videos', 'manage', 'coursesetlist', 'individual_permissions', 'playback_permissions', 'videoformat'))->render(), 'courses' => $videocourses, 'presenters' => $videopresenters, 'terms' => $videoterms, 'tags' => $videotags];
        }
    }


    /** Helper method for getting all videos related to the search query (or all if query is empty)
     * @throws BindingResolutionException
     */
    public
    function getVideos($q)
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
            /** Moved to new manage controller */
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
     * @return \Illuminate\Support\Collection|\Tightenco\Collect\Support\Collection
     */
    public
    function groupVideos($videos): \Illuminate\Support\Collection
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

    /** Remove irrelevant terms that could be added because of multiple course associations
     * @param $videos
     * @param $term
     * @param $year
     * @return mixed
     */
    public
    function removeIrrelevantTerms($videos, $term, $year)
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
    public
    function removeIrrelevantDesignations($videos, $designation)
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
    public
    function extractSettings($videos): array
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
    public
    function find(Request $request)
    {
        $courses = Course::search($request->get('query'), null, true, true)->groupBy('designation')->orderBy('year', 'desc')->take(2)->get();
        $videos = Video::search($request->get('query'), null, true, true)->where('visibility', 1)->orderBy('creation', 'desc');
        $tags = Tag::search($request->get('query'), null, true, true)->take(3)->get();
        $presenters = Presenter::search($request->get('query'), null, true, true)->take(3)->get();
        $count = $courses->count() + $tags->count() + $presenters->count();

        return $courses->concat($tags)->concat($presenters)->concat($videos->take(15 - $count)->get());
    }

    /** Method for tag search autocomplete suggestions
     * @param Request $request
     * @return mixed
     */
    public
    function findTag(Request $request)
    {
        $tags = Tag::search($request->get('query'), null, true, true)->get();
        if (!$tags->filter(function ($item) use ($request) {
            return strtolower($item->name) == strtolower($request->get('query'));
        })->count()) {
            $input = new stdClass();
            $input->name = $request->get('query');
            $input->type = 'input';
            $tags->prepend($input);
        }

        return $tags;
    }

    /** Method for user search autocomplete suggestions
     * @param Request $request
     * @return Collection
     */
    public
    function findPerson(Request $request): Collection
    {
        $searchterms = preg_split('/\s+/', $request->q);
        $search = '(&';
        foreach ($searchterms as $term) {
            $search .= "(|(givenName=$term*)(sn=$term*))";
        }
        $search .= ')';


        $sukatusersdsv = SukatUser::rawFilter($search)->whereContains('edupersonentitlement', 'urn:mace:swami.se:gmai:dsv-user:staff')->get();
        $sukatusersstudents = SukatUser::rawFilter($search)
            ->whereContains('edupersonentitlement', 'urn:mace:swami.se:gmai:dsv-user:student')
            ->whereNotContains('edupersonentitlement', 'urn:mace:swami.se:gmai:dsv-user:staff')
            ->get();
        $sukatusersother = SukatUser::rawFilter($search)
            ->whereNotContains('edupersonentitlement', 'urn:mace:swami.se:gmai:dsv-user:staff')
            ->whereNotContains('edupersonentitlement', 'urn:mace:swami.se:gmai:dsv-user:student')
            ->get();

        foreach ($sukatusersdsv as $su) {
            $su->role = 'DSV';

        }
        foreach ($sukatusersstudents as $su) {
            $su->role = 'Student';
        }

        $users = new Collection();
        foreach ($sukatusersdsv->merge($sukatusersstudents)->merge($sukatusersother) as $su) {
            $user = new stdClass();
            if (!$su->uid) {
                continue;
            }
            $user->uid = $su->uid[0];
            $user->name = $su->displayName[0];
            $user->role = $su->role;
            $users->add($user);
        }

        //Also let's add all local external presenters to be able to find them
        $presenters = Presenter::query();
        foreach ($searchterms as $term) {
            $presenters = $presenters->where('name', 'LIKE', '%' . $term . '%');
        }
        foreach ($presenters->where('description', 'external')->get() as $local) {
            $user = new stdClass();
            $user->uid = 0;
            $user->local = true;
            $user->name = $local->name;
            $users->prepend($user);
        }

        // We only add 'New external' if it's not already there
        if (!$users->filter(function ($item) use ($request) {
            return strtolower($item->name) == strtolower($request->get('q'));
        })->count()) {
            $input = new stdClass();
            $input->uid = 0;
            $input->name = ucwords($request->q);
            $users->prepend($input);
        }
        return $users->take(20);
    }

    /** Method for course search autocomplete suggestions
     * @param Request $request
     * @return mixed
     * @throws BindingResolutionException
     */
    public
    function findCourse(Request $request)
    {
        if ($request->get('onlydesignation') !== null && $request->get('onlydesignation')) {
            // This is not used anymore though working
            $designations = Course::where('designation', 'like', '%'.$request->get('query').'%')->groupBy('designation')->pluck('designation');
            $courses = Course::whereIn('designation', $designations)->orderBy('id', 'desc')->get();
        } else {
            $courses = Course::search($request->get('query'), null, true)->get();
        }

        // For non-admins show only courses that a user has permission to
        if (app()->make('play_role') !== 'Administrator') {
            $daisy = new DaisyAPI();
            $daisyPersonID = $daisy->getDaisyPersonId(app()->make('play_username'));
            // Get all courses where user is courseadmin
            $daisy_courses_ids = [];
            if ($daisy_courses = $daisy->getDaisyEmployeeResponsibleCourses($daisyPersonID)) {
                $daisy_courses_ids = array_map(function ($d) {
                    return $d['id'];
                }, $daisy_courses);
            }
            foreach ($courses as $key => $course) {
                $username = app()->make('play_username');
                $haspermission = CoursesettingsUsers::where('course_id', $course->id)->where('username', $username)->whereIn('permission', ['upload', 'delete', 'edit'])->count() || in_array($course->id, $daisy_courses_ids);
                if (!$haspermission) {
                    unset($courses[$key]);
                }
            }
        }

        // This first groups the search result by a designation, then sorts each groups and returns plain collection
        $grouped = $courses->groupBy('designation');
        $sortedcourses = collect();
        foreach ($grouped as $group) {
            foreach ($group->sortByDesc('id') as $sorteditem) {
                $sortedcourses->add($sorteditem);
            }
        }

        return $sortedcourses;
    }

    /**
     * @param $videos
     * @return array
     */
    public
    function extractCourses($videos): array
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
    public
    function extractTerms($videos): array
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
    public
    function extractTags($videos): array
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
    public
    function extractPresenters($videos): array
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

    /** Perform the actual filtering of search/designation/presenter/term/tag results
     * @param $videos
     * @param $designations
     * @param $semesters
     * @param $tags
     * @param $presenters
     * @return array
     */
    public
    function performFiltering($videos, $designations = null, $semesters = null, $tags = null, $presenters = null): array
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

        $videocourses = $this->extractCourses($videos);
        $videoterms = $this->extractTerms($videos);
        $videotags = $this->extractTags($videos);
        $videopresenters = $this->extractPresenters($videos);

        $videos = $this->groupVideos($videos);

        return array($videocourses, $videoterms, $videopresenters, $videotags, $videos);
    }

    /** Reads GET parameters from the url.
     * @return null[]
     */
    public
    function handleUrlParams(): array
    {
        return [
            'courses' => request('course') ? explode(',', request('course')) : null,
            'presenters' => request('presenter') ? explode(',', request('presenter')) : null,
            'terms' => request('semester') ? explode(',', request('semester')) : null,
            'tags' => request('tag') ? explode(',', request('tag')) : null
        ];
    }
}
