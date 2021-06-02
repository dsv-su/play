<?php

namespace App\Http\Controllers;

use App\Course;
use App\Presenter;
use App\Services\Daisy\DaisyIntegration;
use App\Tag;
use App\Video;
use App\VideoPermission;
use Illuminate\Http\Request;

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

    public function search(Request $request)
    {
        $q = request('q');

        $videos = Video::with('video_course.course', 'video_presenter.presenter', 'video_tag.tag')
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

     //   $courses = Course::search($q, null, true, true)->groupBy('designation')->orderBy('year', 'desc')->get();
      //  $videos = Video::search($q, null, true, true)->orderBy('creation', 'desc')->get();
     //   $tags = Tag::search($q, null, true, true)->orderBy('name')->get();
     //   $presenters = Presenter::search($q, null, true, true)->get();
        $videocourses = $this->extractCourses($videos);
        $videopresenters = $this->extractPresenters($videos);
        $videoterms = $this->extractTerms($videos);
        $videotags = $this->extractTags($videos);

        if (request('filtered')) {
            $html = '';
            $designations = request('course') ? explode(',', request('course')) : null;
            $semesters = request('semester') ? explode(',', request('semester')) : null;
            $presenters = request('presenter') ? explode(',', request('presenter')) : null;
            $tags = request('tag') ? explode(',', request('tag')) : null;
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
                    $html .= '<div class="col my-3">' . view('home.video', ['video' => $video])->render() . '</div>';
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

        } else {
            return view('home.search', compact('videos', 'q', 'videocourses', 'videopresenters', 'videoterms', 'videotags'));
        }
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
        $courses = array();
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
