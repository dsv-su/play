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
use App\Services\Filters\Visibility;
use App\Tag;
use App\Video;
use App\VideoCourse;
use App\VideoPermission;
use App\VideoPresenter;
use DB;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchBySemester($semester)
    {
        $visibility = new Visibility();
        //Permissionslabel
        $permissions = VideoPermission::all();

        //Search
        $term = substr($semester, 0, 2);
        $year = substr($semester, 2, 4);
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($term, $year) {
            return $query->where('year', $year)->where('semester', $term);
        })->get();

        //Visibility
        $videos = $visibility->check($videos);

        $courses = $this->extractCourses($videos);
        $presenters = $this->extractPresenters($videos);
        $tags = $this->extractTags($videos);
        $videos = $this->groupVideos($videos);

        return view('home.navigator', compact('term', 'year', 'videos', 'courses', 'presenters', 'tags', 'permissions'));
    }

    public function searchByDesignation($designation)
    {
        $visibility = new Visibility();
        //Permissionslabel
        $permissions = VideoPermission::all();
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($designation) {
            return $query->where('designation', $designation);
        })->orderBy('creation', 'desc')->get();
        $terms = $this->extractTerms($videos);
        $presenters = $this->extractPresenters($videos);
        $tags = $this->extractTags($videos);

        //Visibility
        $videos = $visibility->check($videos);

        // Here we do a simple grouping, since we don't need all course designations
        $videos = $videos->groupBy(function ($item) {
            return $item->video_course[0]->course['id'] ?? 'UU9999';
        });

        // Remove irrelevant course designations that could be added because of multiple course associations
        foreach ($videos as $courseid => $videocourse) {
            if (Course::find($courseid)->designation !== $designation) {
                $videos->forget($courseid);
            }
        }

        return view('home.navigator', compact('designation', 'videos', 'permissions', 'terms', 'presenters', 'tags'));
    }

    public function searchByCategory($category)
    {
        $visibility = new Visibility();
        //Permissionslabel
        $permissions = VideoPermission::all();
        $videos = Video::with('category', 'video_course.course')->whereHas('category', function ($query) use ($category) {
            return $query->where('category_name', $category);
        })->get();

        //Visibility
        $videos = $visibility->check($videos);

        $videos = $videos->groupBy(function ($item) {
            return $item->video_course[0]->course['year'] ?? '9999';
        });

        return view('home.navigator', compact('category', 'videos', 'permissions'));
    }

    public function searchByUser($username)
    {
        $visibility = new Visibility();
        $daisy = new DaisyIntegration();
        $courses = $daisy->getActiveStudentCourses($username);
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($courses) {
            return $query->whereIn('course_id', $courses);
        })->get();

        $data['permissions'] = VideoPermission::all();
        $data['latest'] = $visibility->check($videos);
        return view('home.index', $data);
    }

    /**
     * @throws BindingResolutionException
     */
    public function getVideos($q)
    {
        $visibility = new Visibility();

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

            return $visibility->check($videos);

        } else {
            if (app()->make('play_role') == 'Courseadmin' or app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {

                //If user is courseadmin, uploader or staff
                $videos_id = [];
                $user = Presenter::where('username', app()->make('play_username'))->first();
                $user_videos = VideoPresenter::where('presenter_id', $user->id ?? 0)->pluck('video_id');

                //Check if user is course administrator
                $courseadministrator = CourseadminPermission::where('username', app()->make('play_username'))->where('permission', 'delete')->pluck('video_id');

                //Check for individual permissions settings
                $individual_videos = IndividualPermission::where('username', app()->make('play_username'))->where('permission', 'edit')->orWhere('permission', 'delete')->pluck('video_id');

                //Check for course individual settings
                if (count($course_user_admins = CoursesettingsUsers::where('username', app()->make('play_username'))->whereIn('permission', ['edit', 'delete'])->get()) >= 1) {
                    foreach ($course_user_admins as $course_user_admin) {
                        $videos_id[] = VideoCourse::where('course_id', $course_user_admin->course_id)->pluck('video_id');
                    }
                }
                $video_course_ids = collect($videos_id)->flatten(1)->toArray();

                return $visibility->check(Video::whereIn('id', $user_videos)->orWhereIn('id', $individual_videos)->orWhereIn('id', $courseadministrator)->orWhereIn('id', $video_course_ids)->latest('creation')->get());

            } elseif (app()->make('play_role') == 'Administrator') {
                return $visibility->check(Video::with('category', 'video_course.course')->latest('creation')->get());
            }
        }

        return false;
    }

    /**
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
        $permissions = VideoPermission::all();

        // Group videos by a courseid
        $videos = $this->groupVideos($videos);

        /*
        // Group videos by course
        $videos = $videos->groupBy(function ($item) {
            if (isset($item->video_course[0])) {
                $course = $item->video_course[0]->course;
                return $course['id'] ?? '0';
            }
            return false;
        });
        */

        $coursesetlist = $individual_permissions = $playback_permissions = [];
        if ($manage) {
            list($coursesetlist, $individual_permissions, $playback_permissions) = $this->extractSettings($videos);
        }

        return view('home.search', compact('videos', 'q', 'videocourses', 'videopresenters', 'videoterms', 'videotags', 'manage', 'permissions', 'coursesetlist', 'playback_permissions', 'individual_permissions'));
    }

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

    /**
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

    public function find(Request $request)
    {
        $courses = Course::search($request->get('query'), null, true, true)->groupBy('designation')->orderBy('year', 'desc')->take(2)->get();
        $videos = Video::search($request->get('query'), null, true, true)->orderBy('creation', 'desc');
        $tags = Tag::search($request->get('query'), null, true, true)->take(3)->get();
        $presenters = Presenter::search($request->get('query'), null, true, true)->take(3)->get();
        $count = $courses->count() + $tags->count() + $presenters->count();

        return $courses->concat($tags)->concat($presenters)->concat($videos->take(15 - $count)->get());
    }

    public function showCourseVideos($courseid)
    {
        $visibility = new Visibility();
        $data['course'] = Course::find($courseid);
        $data['latest'] = Course::find($courseid)->videos()->filter(function ($video) {
            return $video;
        });
        $data['latest'] = $visibility->check($data['latest']);
        return view('home.index', $data);
    }

    public function showTagVideos($tag)
    {
        $visibility = new Visibility();
        $data['tag'] = $tag;
        $data['latest'] = Tag::where('name', $tag)->first()->videos()->filter(function ($video) {
            return $video;
        });
        $data['latest'] = $visibility->check($data['latest']);
        $data['terms'] = $this->extractTerms($data['latest']);
        $data['courses'] = $this->extractCourses($data['latest']);
        $data['presenters'] = $this->extractPresenters($data['latest']);

        return view('home.index', $data);
    }

    public function showPresenterVideos($username)
    {
        $visibility = new Visibility();
        $presenter = Presenter::where('username', $username)->first();
        $data['presenter'] = $presenter->name;
        $data['latest'] = $presenter->videos()->filter(function ($video) {
            return $video;
        });
        $data['latest'] = $visibility->check($data['latest']);
        $data['terms'] = $this->extractTerms($data['latest']);
        $data['courses'] = $this->extractCourses($data['latest']);
        $data['tags'] = $this->extractTags($data['latest']);

        return view('home.index', $data);
    }

    public function extractCourses($videos): array
    {
        $courses = array('nocourse' => __('No course association'));
        foreach ($videos as $video) {
            foreach ($video->courses() as $course) {
                if (!in_array($course->name, $courses)) {
                    $courses[$course->designation] = $course->name;
                }
            }
        }
        return $courses;
    }

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

    public function filterTagVideos($tag, Request $request): array
    {
        $data['tag'] = $tag;
        $data['latest'] = Tag::where('name', $tag)->first()->videos();
        $designations = request('course') ? explode(',', request('course')) : null;
        $semesters = request('semester') ? explode(',', request('semester')) : null;
        $presenters = request('presenter') ? explode(',', request('presenter')) : null;
        list ($html, $videocourses, $videoterms, $videopresenters, $videotags) = $this->performFiltering(
            $data['latest'], $designations, $semesters, null, $presenters
        );
        return ['html' => $html, 'courses' => $videocourses, 'presenters' => $videopresenters, 'terms' => $videoterms];
    }

    public function filterPresenterVideos($username, Request $request): array
    {
        $presenter = Presenter::where('username', $username)->first();
        $data['presenter'] = $presenter->name;
        $data['latest'] = $presenter->videos();
        $designations = request('course') ? explode(',', request('course')) : null;
        $semesters = request('semester') ? explode(',', request('semester')) : null;
        $tags = request('tag') ? explode(',', request('tag')) : null;
        list ($html, $videocourses, $videoterms, $videopresenters, $videotags) = $this->performFiltering(
            $data['latest'], $designations, $semesters, $tags
        );
        return ['html' => $html, 'courses' => $videocourses, 'tags' => $videotags, 'terms' => $videoterms];
    }

    public function performFiltering($videos, $designations = null, $semesters = null, $tags = null, $presenters = null, $manage = false): array
    {
        $visibility = new Visibility();
        $videos = $visibility->check($videos);
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
        /*
        // Group videos by course
        $videos = $videos->groupBy(function ($item) {
            if (isset($item->video_course[0])) {
                $course = $item->video_course[0]->course;
                return $course['id'] ?? '0';
            }
            return false;
        });*/

        $coursesetlist = $individual_permissions = $playback_permissions = [];
        if ($manage) {
            list($coursesetlist, $individual_permissions, $playback_permissions) = $this->extractSettings($videos);
        }

        $html = view('home.courselist', compact('videos', 'manage', 'coursesetlist', 'individual_permissions', 'playback_permissions'))->render();

        return array($html, $videocourses, $videoterms, $videopresenters, $videotags, $videos);
    }

    public function filterByDesignation($designation, Request $request): string
    {
        $visibility = new Visibility();
        //Permissionslabel
        $permissions = VideoPermission::all();
        $presenters = request('presenter') ? explode(',', request('presenter')) : null;
        $semesters = request('semester') ? explode(',', request('semester')) : null;
        $tags = request('tag') ? explode(',', request('tag')) : null;
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($designation) {
            return $query->where('designation', $designation);
        })->orderBy('creation', 'desc')->get();
        $videos = $visibility->check($videos);

        list ($html, $videocourses, $videoterms, $videopresenters, $videotags, $filteredvideos) = $this->performFiltering(
            $videos, null, $semesters, $tags, $presenters
        );

        // Rewrite html here because it doesn't fit our categorization view
        $html = '';
        foreach ($filteredvideos as $key => $coursevideos) {
            $html .= view('home.filtered_course', compact('coursevideos', 'key', 'designation', 'permissions'))->render();
        }

        return $html ?: '<h4 class="col my-3 font-weight-light">No presentations found</h4>';
    }

    public function filterBySemester($semester, Request $request): string
    {
        $visibility = new Visibility();
        //Permissionslabel
        $permissions = VideoPermission::all();
        $term = substr($semester, 0, 2);
        $year = substr($semester, 2, 4);
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($term, $year) {
            return $query->where('year', $year)->where('semester', $term);
        })->get();
        $videos = $visibility->check($videos);
        $presenters = request('presenter') ? explode(',', request('presenter')) : null;
        $designations = request('course') ? explode(',', request('course')) : null;
        $tags = request('tag') ? explode(',', request('tag')) : null;

        list ($html, $videocourses, $videoterms, $videopresenters, $videotags, $filteredvideos) = $this->performFiltering(
            $videos, $designations, null, $tags, $presenters
        );

        $groupedvideos = $filteredvideos->groupBy(function ($item, $key) {
            $item['belongs_to_course'] = $item->video_course[0]->course['name'];
            return $item->video_course[0]->course['name'] ?? '9999';
        });

        // Rewrite html here because it doesn't fit our categorization view
        $html = '';
        foreach ($groupedvideos as $key => $coursevideos) {
            $html .= view('home.filtered_course', compact('coursevideos', 'key', 'permissions'))->render();
        }

        return $html ?: '<h4 class="col my-3 font-weight-light">No presentations found</h4>';
    }
}
