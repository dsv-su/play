<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategorySearchAspect;
use App\Course;
use App\CourseSearchAspect;
use App\Presenter;
use App\Services\Notify\PlayStoreNotify;
use App\Video;
use Illuminate\Http\Request;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class TestController extends Controller
{

    public function test()
    {
        $video = Video::find('d02a567f-735d-47df-8118-cace07a52fe5');
        dd($video->ipermissions);
    }

    public function search(Request $request)
    {
        /*****************************
         * In working progress --> This is all for testing - will be rewritten!!
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

            return view('home.search', compact('searchResults', 'search'));

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

    public function del(Video $video)
    {
        //Send Delete notification
        $notify = new PlayStoreNotify($video);
        $notify->sendDelete();
        return back()->with(['message' => 'Presentationen har raderats']);
    }

    public function php()
    {
        return phpinfo();
    }

    public function server()
    {
        dd($_SERVER);
    }


}
