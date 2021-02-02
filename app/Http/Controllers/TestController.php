<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategorySearchAspect;
use App\Cattura;
use App\Course;
use App\CourseSearchAspect;
use App\PlayerJson;
use App\Presenter;
use App\Services\CheckPlayStoreApi;
use App\Services\CountPresentations;
use App\Services\DaisyIntegration;
use App\System;
use App\Video;
use App\VideoCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class TestController extends Controller
{
    public function index()
    {
        $videos = Video::with('category', 'course')->get();
        $data['categories'] = Category::all();
        return view('home.list', compact('videos'), $data);
    }

    public function show(Course $course)
    {
        /*********************************
         * Check if enviroment is local or remote
         */
        if (app()->environment('local')) {
            $play_user = 'Förnamn Efternamn';
        } else {

            $play_user = $_SERVER['displayName'];
        }
        /*********************************
         * Get all categories for nav-menu
         */
        $categories = Category::all();
        $results = Video::with('category', 'video_course.course')->latest('id')->take(8)->get();
        // Searchtype

        return view('course.index', compact('results', 'categories', 'course', 'play_user'));
    }

    public function daisy(Video $video)
    {
        /*$data['courses'] = Course::all()->sortBy('course');
        $data['categories'] = Category::all();
        return view('home.courses', $data);*/
    }

    public function daisyLoadCourses()
    {
        /***********************************
         * //Loads courses from Daisy API -> db
         * from 2010 - 2020
         * ********************************/

        $endpoints = array(
            'courseSegment?semester=20201',
            'courseSegment?semester=20202',
            'courseSegment?semester=20191',
            'courseSegment?semester=20192',
            'courseSegment?semester=20181',
            'courseSegment?semester=20182',
            'courseSegment?semester=20171',
            'courseSegment?semester=20172',
            'courseSegment?semester=20161',
            'courseSegment?semester=20162',
            'courseSegment?semester=20151',
            'courseSegment?semester=20152',
            'courseSegment?semester=20141',
            'courseSegment?semester=20142',
            'courseSegment?semester=20131',
            'courseSegment?semester=20132',
            'courseSegment?semester=20121',
            'courseSegment?semester=20122',
            'courseSegment?semester=20111',
            'courseSegment?semester=20112',
            'courseSegment?semester=20101',
            'courseSegment?semester=20102',
        );


        $system = System::find(1);
        $daisy = new DaisyIntegration($system);

        // Delete Table courses
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('courses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($endpoints as $endp) {
            $res = $daisy->getResource($endp);

            //Convert xml to an array
            $xml = simplexml_load_string($res->getBody()->getContents());
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);


            //Store id db table
            foreach ($array['courseSegmentInstance'] as $item) {
                $course = new Course();
                $course->designation = $item['designation'];
                // if (substr($item['semester'], 4) == '1') {
                //   $course->semester = 'VT';
                // } else $course->semester = 'HT';
                // $course->year = substr($item['semester'], 0, 4);
                $course->name = $item['name'];

                $course->save();
            }
            $course->save();
        }

        return redirect()->route('daisy');

    }

    public function search(Request $request)
    {
        /*****************************
         * In working progress --> This is all for testing - will be rewritten!!
         */

        // If the environment is local
        /*
        if (app()->environment('local')) {
            $play_user = 'Förnamn Efternamn';
        } else {

            $play_user = $_SERVER['displayName'];
        }
        */

        /**************************
         * Check if searchstring is empty
         */

        if ($request->input('query')) {
            $searchString = $request->input('query');
        } else $searchString = 'Inget angivet';

        /*********************************
         * Get all categories for nav-menu
         */

        $categories = Category::all();

        /*********************************
         * Fulltext search
         */

        $search = 1;
        if ($request->input('type') == null) {
            /*****************************
             * Search model Video
             */
            $searchResults = (new Search())
                ->registerModel(Video::class, function (ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('title'); // return results for partial matches on titles
                })
                ->perform($searchString);

            /*****************************
             * Search Video in relation to Category
             */
            $cat = 0;
            $searchCategoryRelations = (new Search())
                ->registerAspect(CategorySearchAspect::class)
                ->perform($searchString);

            if ($searchCategoryRelations->count() > 0) {
                foreach ($searchCategoryRelations as $relations) {
                    $category_videos = Video::where('category_id', $relations->url)->get();
                }
                $search = 2;
                //return view('home.index', compact('searchResults','searchCategoryRelations','data', 'search', 'play_user'));
            } else $cat = 1;

            /******************************
             * Search Video in relation to Course
             */
            $searchCourseRelations = (new Search())
                ->registerAspect(CourseSearchAspect::class)
                ->perform($searchString);

            if ($searchCourseRelations->count() > 0) {
                foreach ($searchCourseRelations as $relations) {
                    $course_videos = Video::where('course_id', $relations->url)->get();
                }
                $search = 2;
                if ($cat == 1) {
                    return view('home.index', compact('searchResults', 'categories', 'searchCategoryRelations', 'searchCourseRelations', 'course_videos', 'search', 'play_user'));
                } else {
                    return view('home.index', compact('searchResults', 'categories', 'searchCategoryRelations', 'searchCourseRelations', 'category_videos', 'course_videos', 'search', 'play_user'));
                }

            } elseif ($cat == 0) {
                return view('home.index', compact('searchResults', 'categories', 'searchCategoryRelations', 'category_videos', 'search', 'play_user'));
            }


            return view('home.index', compact('searchResults', 'categories', 'search', 'play_user'));
        } elseif ($request->input('type') == 'type-lectures') {
            dd('Sorry, PRESENTATORS search has not been implemented');
            $search = (new Search())
                ->registerModel(Presenter::class, function (ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('name'); // return results for partial matches on presenters
                })
                ->perform($searchString);
            foreach ($search as $subject) {
                foreach ($subject as $item) {
                    $searchResults = Video::with('video_presenter')->where('video_presenter.presenter_id', $item->id)->get();
                    // Searchtype
                    $search = 3;
                    return view('home.index', compact('searchResults', 'categories', 'search', 'play_user'));
                }
            }
            $searchResults = $search;
            // Searchtype 1
            $search = 1;
            return view('home.index', compact('searchResults', 'categories', 'search', 'play_user'));

        } elseif ($request->input('type') == 'type-category') {
            $search = (new Search())
                ->registerModel(Category::class, function (ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('category_name'); // return results for partial matches on categories
                })
                ->perform($searchString);
            foreach ($search as $subject) {
                foreach ($subject as $item) {
                    $searchResults = Video::where('category_id', $item->id)->get();
                    // Searchtype
                    $search = 3;
                    return view('home.index', compact('searchResults', 'categories', 'search', 'play_user'));
                }
            }
            $searchResults = $search;
            // Searchtype 1
            $search = 1;
            return view('home.index', compact('searchResults', 'categories', 'search', 'play_user'));

            //dd($searchResults);
            return view('home.index', compact('searchResults', 'categories', 'search', 'play_user'));
        } elseif ($request->input('type') == 'type-course') {
            $search = (new Search())
                ->registerModel(Course::class, function (ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('name'); // return results for partial matches on courses
                })
                ->perform($searchString);
            foreach ($search as $subject) {
                foreach ($subject as $item) {
                    $searchResults = Video::where('course_id', $item->id)->get();
                    // Searchtype
                    $search = 3;
                    return view('home.index', compact('searchResults', 'categories', 'search', 'play_user'));
                }
            }
            $searchResults = $search;
            // Searchtype 1
            $search = 1;
            return view('home.index', compact('searchResults', 'categories', 'search', 'play_user'));
        } elseif ($request->input('type') == 'type-latest') {
            dd('Sorry, LATEST search has not been implemented');
        }

    }

    /*************************************************************************************
     */

    public function php()
    {
        return phpinfo();
    }

    public function server()
    {
        dd($_SERVER);
    }


}
