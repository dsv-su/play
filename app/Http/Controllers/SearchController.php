<?php

namespace App\Http\Controllers;

use App\Course;
use App\Presenter;
use App\Services\Daisy\DaisyIntegration;
use App\Tag;
use App\Video;
use App\VideoPermission;
use App\VideoPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    public function searchBySemester($semester)
    {
        //Permissionslabel
        $permissions = VideoPermission::all();

        //Search
        $term = substr($semester, 0, 2);
        $year = substr($semester, 2, 4);
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($term, $year) {
            return $query->where('year', $year)->where('semester', $term);
        })->get();
        $videos = $videos->groupBy(function ($item, $key) {
            $item['belongs_to_course'] = $item->video_course[0]->course['name'];
            return $item->video_course[0]->course['name'] ?? '9999';
        });

        return view('home.navigator', compact('term', 'year', 'videos', 'permissions'));
    }

    public function searchByDesignation($designation)
    {
        //Permissionslabel
        $permissions = VideoPermission::all();
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($designation) {
            return $query->where('designation', $designation);
        })->orderBy('creation', 'desc')->get();
        $terms = $this->extractTerms($videos);
        $presenters = $this->extractPresenters($videos);
        $videos = $videos->groupBy(function ($item, $key) {
            return $item->video_course[0]->course['semester'] . $item->video_course[0]->course['year'] ?? 'UU9999';
        });

        return view('home.navigator', compact('designation', 'videos', 'permissions', 'terms', 'presenters'));
    }

    public function searchByCategory($category)
    {
        //Permissionslabel
        $permissions = VideoPermission::all();
        $videos = Video::with('category', 'video_course.course')->whereHas('category', function ($query) use ($category) {
            return $query->where('category_name', $category);
        })->get();
        $videos = $videos->groupBy(function ($item, $key) {
            return $item->video_course[0]->course['year'] ?? '9999';
        });

        return view('home.navigator', compact('category', 'videos', 'permissions'));
    }

    public function searchByUser($username)
    {
        $daisy = new DaisyIntegration();
        $courses = $daisy->getActiveStudentCourses($username);
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($courses) {
            return $query->whereIn('course_id', $courses);
        })->get();

        $data['permissions'] = VideoPermission::all();
        $data['latest'] = $videos;
        return view('home.index', $data);
    }

    public function getVideos($q)
    {
        if ($q) {
            return Video::with('video_course.course', 'video_presenter.presenter', 'video_tag.tag')
                ->whereHas('video_presenter.presenter', function ($query) use ($q) {
                    return $query->where('username', 'LIKE', "%$q%")->orWhere('name', 'LIKE', "%$q%");
                })
                ->orWhereHas('video_course.course', function ($query) use ($q) {
                    return $query->where('title', 'LIKE', "%$q%")->orwhere(\DB::raw('concat(semester,year)'), 'LIKE', "%$q%");
                })
                ->orWhere('title', 'LIKE', "%$q%")
                ->orwhereHas('video_tag.tag', function ($query) use ($q) {
                    return $query->where('name', 'LIKE', "%$q%");
                })
                ->orderBy('creation', 'desc')
                ->get();
        } else {
            if(app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
                //If user is uploader or staff
                $user = Presenter::where('username', app()->make('play_username'))->first();
                $user_videos = VideoPresenter::where('presenter_id', $user->id ?? 0)->pluck('video_id');
                return Video::whereIn('id', $user_videos)->with('category', 'video_course.course')->latest('creation')->get();

            } elseif (app()->make('play_role') == 'Administrator') {
                //If user is Administrator
                return Cache::remember('videos', $seconds = 180, function () {
                    return Video::with('category', 'video_course.course')->latest('creation')->get();
                });
            }
        }
    }

    public function search($q = null, Request $request = null)
    {

        $videos = $this->getVideos($q);
        $videocourses = $this->extractCourses($videos);
        $videopresenters = $this->extractPresenters($videos);
        $videoterms = $this->extractTerms($videos);
        $videotags = $this->extractTags($videos);

        $manage = \Request::is('manage');

        return view('home.search', compact('videos', 'q', 'videocourses', 'videopresenters', 'videoterms', 'videotags', 'manage'));
    }

    public function filterSearch($q = null, Request $request)
    {
        $html = '';
        $videos = $this->getVideos($q);
        $designations = request('course') ? explode(',', request('course')) : null;
        $semesters = request('semester') ? explode(',', request('semester')) : null;
        $presenters = request('presenter') ? explode(',', request('presenter')) : null;
        $tags = request('tag') ? explode(',', request('tag')) : null;
        $manage = \Request::is('manage');
        foreach ($videos as $key => $video) {
            $found = false;
            $presenterfound = false;
            $tagfound = false;
            if ($designations || $semesters) {
                foreach ($video->courses() as $course) {
                    if ((!$semesters || in_array($course->semester . $course->year, $semesters)) && (!$designations || in_array($course->designation, $designations))) {
                        $found = true;
                    }
                }
                if (in_array('nocourse', $designations) && $video->courses()->isEmpty()) {
                    $found = true;
                }
            } else {
                $found = true;
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
            if ($tags) {
                foreach ($video->tags() as $tag) {
                    if (in_array($tag->name, $tags)) {
                        $tagfound = true;
                    }
                }
            } else {
                $tagfound = true;
            }
            if ($found && $presenterfound && $tagfound) {
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
            $html .= '<h3 class="col my-3 font-weight-light">No presentations found</h3>';
        }
        $videocourses = $this->extractCourses($videos);
        $videopresenters = $this->extractPresenters($videos);
        $videoterms = $this->extractTerms($videos);
        $videotags = $this->extractTags($videos);
        return ['html' => $html, 'tags' => $videotags, 'courses' => $videocourses, 'presenters' => $videopresenters, 'terms' => $videoterms];
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
        $data['course'] = Course::find($courseid);
        $data['latest'] = Course::find($courseid)->videos();

        return view('home.index', $data);
    }

    public function showTagVideos($tag)
    {
        $data['tag'] = $tag;
        $data['latest'] = Tag::where('name', $tag)->first()->videos();

        return view('home.index', $data);
    }

    public function extractCourses($videos)
    {
        $courses = array('nocourse' => 'No course association');

        foreach ($videos as $video) {
            foreach ($video->courses() as $course) {
                if (!in_array($course->name, $courses)) {
                    $courses[$course->designation] = $course->name;
                }
            }
        }
        return $courses;
    }

    public function extractTerms($videos)
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

    public function extractTags($videos)
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

    public function extractPresenters($videos)
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

    public function showPresenterVideos($username)
    {
        $presenter = Presenter::where('username', $username)->first();
        $data['presenter'] = $presenter->name;
        $data['latest'] = $presenter->videos();
        $data['terms'] = $this->extractTerms($data['latest']);
        $data['courses'] = $this->extractCourses($data['latest']);

        return view('home.index', $data);
    }

    public function filterPresenterVideos($username, Request $request)
    {
        $presenter = Presenter::where('username', $username)->first();
        $data['presenter'] = $presenter->name;
        $data['latest'] = $presenter->videos();
        $designations = request('course') ? explode(',', request('course')) : null;
        $semesters = request('semester') ? explode(',', request('semester')) : null;
        $html = '';
        foreach ($data['latest'] as $video) {
            foreach ($video->courses() as $course) {
                $found = false;
                if ((!$semesters || in_array($course->semester . $course->year, $semesters)) && (!$designations || in_array($course->designation, $designations))) {
                    $found = true;
                }
            }
            if ($found) {
                $html .= '<div class="col my-3">' . view('home.video', ['video' => $video])->render() . '</div>';
            }
        }
        $html .= '<div class="col"><div class="card video my-0 mx-auto"></div></div>
                        <div class="col"><div class="card video my-0 mx-auto"></div></div>
                        <div class="col"><div class="card video my-0 mx-auto"></div></div>';

        return $html;
    }

    public function filterOnDesignation($designation, Request $request)
    {
        //Permissionslabel
        $permissions = VideoPermission::all();
        $presenters = request('presenter') ? explode(',', request('presenter')) : null;
        $semesters = request('semester') ? explode(',', request('semester')) : null;
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($designation) {
            return $query->where('designation', $designation);
        })->orderBy('creation', 'desc')->get();
        foreach ($videos as $key => $video) {
            $presenterfound = false;
            $semesterfound = false;
            if ($presenters) {
                foreach ($video->presenters() as $presenter) {
                    if (in_array($presenter->username, $presenters)) {
                        $presenterfound = true;
                    }
                }
            } else {
                $presenterfound = true;
            }
            if ($semesters) {
                foreach ($video->courses() as $course) {
                    if (in_array($course->semester . $course->year, $semesters)) {
                        $semesterfound = true;
                    }
                }
            } else {
                $semesterfound = true;
            }
            if (!$presenterfound || !$semesterfound) {
                unset($videos[$key]);
            }
        }
        $videos = $videos->groupBy(function ($item, $key) {
            return $item->video_course[0]->course['semester'] . $item->video_course[0]->course['year'] ?? 'UU9999';
        });

        $html = '';
        foreach ($videos as $key => $videocourse) {
            $html .= view('home.filtered_course', compact('videos', 'videocourse', 'key', 'designation', 'permissions'))->render();
        }

        return $html;
    }
}
