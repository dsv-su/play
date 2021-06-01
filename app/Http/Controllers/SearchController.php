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
        $videos = $videos->groupBy(function ($item, $key) {
            return $item->video_course[0]->course['semester'] . $item->video_course[0]->course['year'] ?? 'UU9999';
        });

        return view('home.navigator', compact('designation', 'videos', 'permissions'));
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
        $courses = Course::search($q, null, true, true)->groupBy('designation')->orderBy('year', 'desc')->get();
        $videos = Video::search($q, null, true, true)->orderBy('creation', 'desc')->get();
        $tags = Tag::search($q, null, true, true)->orderBy('name')->get();
        $presenters = Presenter::search($q, null, true, true)->get();
        return view('home.search', compact('courses', 'videos', 'tags', 'presenters', 'q'));
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
}
