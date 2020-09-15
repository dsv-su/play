<?php

namespace App\Http\Controllers;

use App\CategorySearchAspect;
use App\Course;
use App\CourseSearchAspect;
use App\Services\DaisyIntegration;
use App\System;
use App\Video;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

    public function find(Request $request)
    {
        return Video::search($request->get('query'))->with('category')->get();
        //return Video::search($request->get('query'))->with('course')->get();
    }

    public function daisy()
    {
        //Loads courses from Daisy API -> db
        $endp = 'courseSegment?semester=20201'; //Get courses from vt 2020

        $system = System::find(1);
        $daisy = new DaisyIntegration($system);
        $res = $daisy->getResource($endp);

        //Convert xml to an array
        $xml = simplexml_load_string($res->getBody()->getContents());
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        // Delete Table courses
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('courses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        //Store id db table
        foreach ($array['courseSegmentInstance'] as $item)
        {
            $course = new Course();
            $course->course_name = $item['name'];
            $course->semester = $item['semester'];
            $course->save();
        }
        $course->save();


        dd($array);
        //dd($daisys);

    }

    public function search(Request $request)
    {
        /*****************************
         * In working progress
         */

        // If the environment is local
        if(app()->environment('local'))
        {
            $play_user = 'Förnamn Efternamn';
        }
        else {

            $play_user = $_SERVER['displayName'];
        }


        /**************************
         * Check if searchstring is empty
         */

        if($request->input('query'))
        {
            $searchString = $request->input('query');
        }
        else $searchString = 'Inget angivet';

        /*********************************
         * Get all categories for nav-menu
         */

        $categories = Category::all();

        /*********************************
         * Fulltext search
         */

        $search = 1;
        if($request->input('type') == null)
        {
            /*****************************
             * Search model Video
             */
            $searchResults = (new Search())
                ->registerModel(Video::class, function(ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('title') // return results for partial matches on titles
                        ->addSearchableAttribute('tags'); // return results for partial matches on tags
                })
                ->perform($searchString);

            /*****************************
             * Search Video in relation to Category
             */
            $cat = 0;
            $searchCategoryRelations = (new Search())
                ->registerAspect(CategorySearchAspect::class)
                ->perform($searchString);

            if($searchCategoryRelations->count() > 0)
            {
                foreach ($searchCategoryRelations as $relations)
                {
                    $category_videos = Video::where('category_id', $relations->url)->get();
                }
                $search = 2;
                //return view('home.index', compact('searchResults','searchCategoryRelations','data', 'search', 'play_user'));
            }
            else $cat = 1;

            /******************************
             * Search Video in relation to Course
             */
            $searchCourseRelations = (new Search())
                ->registerAspect(CourseSearchAspect::class)
                ->perform($searchString);

            if($searchCourseRelations->count() > 0)
            {
                foreach ($searchCourseRelations as $relations)
                {
                    $course_videos = Video::where('course_id', $relations->url)->get();
                }
                $search = 2;
                if($cat == 1)
                {
                    return view('home.index', compact('searchResults','categories', 'searchCategoryRelations', 'searchCourseRelations','course_videos','search', 'play_user'));
                }
                else
                {
                    return view('home.index', compact('searchResults','categories', 'searchCategoryRelations', 'searchCourseRelations', 'category_videos','course_videos','search', 'play_user'));
                }

            }
            elseif ($cat == 0)
            {
                return view('home.index', compact('searchResults','categories','searchCategoryRelations','category_videos', 'search', 'play_user'));
            }


            return view('home.index', compact('searchResults','categories', 'search', 'play_user'));
        }

        elseif ($request->input('type') == 'type-lectures')
        {
            dd('Sorry, LECTURES search has not been implemented');
        }
        elseif ($request->input('type') == 'type-category')
        {
            $search = (new Search())
                ->registerModel(Category::class, function(ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('category_name'); // return results for partial matches on categories
                })
                ->perform($searchString);
            foreach ($search as $subject)
            {
                foreach ($subject as $item)
                {
                    $searchResults = Video::where('category_id', $item->id)->get();
                    // Searchtype 2
                    $search = 3;
                    return view('home.index', compact('searchResults','categories', 'search', 'play_user'));
                }
            }
            $searchResults = $search;
            // Searchtype 1
            $search = 1;
            return view('home.index', compact('searchResults','categories', 'search', 'play_user'));

            //dd($searchResults);
            return view('home.index', compact('searchResults','categories', 'search', 'play_user'));
        }
        elseif ($request->input('type') == 'type-course')
        {
            $search = (new Search())
                ->registerModel(Course::class, function(ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('course_name'); // return results for partial matches on categories
                })
                ->perform($searchString);
            foreach ($search as $subject)
            {
                foreach ($subject as $item)
                {
                    $searchResults = Video::where('course_id', $item->id)->get();
                    // Searchtype 2
                    $search = 3;
                    return view('home.index', compact('searchResults','categories', 'search', 'play_user'));
                }
            }
            $searchResults = $search;
            // Searchtype 1
            $search = 1;
            return view('home.index', compact('searchResults','categories', 'search', 'play_user'));
        }
        elseif ($request->input('type') == 'type-latest')
        {
            dd('Sorry, LATEST search has not been implemented');
        }

    }

    /*************************************************************************************
     * Methods for testing purposes
    /*************************************************************************************
    */
    public function thumb()
    {

        //Video
        $video = './mediasite/KM - Kunskapsnätverk/KM HT2015 Lecture 1/cf6ebf54-4887-4207-935a-f20422390f63.mp4';
        //$video = './mediasite/KM - Kunskapsnätverk/KM HT2015 Seminar 1/f3cfa8f5-3ef5-4781-b350-7d88140212c9.mp4';
        //$video ='https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/fabefa3e-6758-468b-aae1-b7b512d084fa.mp4?playbackTicket=&site=play2.dsv.su.se';

        FFMpeg::fromDisk('public')
            ->open($video)
            ->getFrameFromSeconds(3)
            ->export()
            ->toDisk('public')
            ->save('frame1.png');
        $updatevideo = Video::find(14);
        $updatevideo->image = Storage::url('frame1.png');
        $updatevideo->save();
        return 'Done';
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
