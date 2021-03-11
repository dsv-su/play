<?php

namespace App\Http\Controllers;

use App\Video;
use App\VideoPermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchBySemester($semester)
    {
        //Permissionslabel
        $permissions = VideoPermission::all();

        //Search
        $term = substr($semester, 0, 2);
        $year = substr($semester, 3, 4);
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function($query) use($term, $year){
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
        $videos = Video::with('video_course.course')->whereHas('video_course.course', function($query) use($designation){
            return $query->where('designation', $designation);
        })->get();
        $videos = $videos->groupBy(function ($item, $key) {
            return $item->video_course[0]->course['year'] ?? '9999';
        });

        return view('home.navigator', compact('designation','videos', 'permissions'));
    }

    public function searchByCategory($category)
    {
        //Permissionslabel
        $permissions = VideoPermission::all();
        $videos = Video::with('category', 'video_course.course')->whereHas('category', function($query) use($category){
            return $query->where('category_name', $category);
        })->get();
        $videos = $videos->groupBy(function ($item, $key) {
            return $item->video_course[0]->course['year'] ?? '9999';
        });

        return view('home.navigator', compact('category','videos', 'permissions'));
    }
}
