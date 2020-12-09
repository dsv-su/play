<?php

namespace App\Http\Controllers;

use App\CategorySearchAspect;
use App\Cattura;
use App\Course;
use App\CourseSearchAspect;
use App\PlayerJson;
use App\Services\DaisyAPI;
use App\Services\DaisyIntegration;
use App\System;
use App\Video;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

    public function show(Course $course)
    {
        /*********************************
         * Check if enviroment is local or remote
         */
        if(app()->environment('local'))
        {
            $play_user = 'Förnamn Efternamn';
        }
        else {

            $play_user = $_SERVER['displayName'];
        }
        /*********************************
         * Get all categories for nav-menu
         */
        $categories = Category::all();
        $course = $course;
        $Results = Video::where('course_id', $course->id)->get();
        // Searchtype

        return view('course.index', compact('Results','categories', 'course', 'play_user'));
    }

    public function daisy()
    {
        $data['courses'] = Course::all()->sortBy('course');
        $data['categories'] = Category::all();
        return view ('home.courses', $data);
    }

    public function daisyLoadCourses()
    {
        /***********************************
        //Loads courses from Daisy API -> db
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
                $course->course = $item['designation'];
                if (substr($item['semester'], 4) == '1') {
                    $course->semester = 'VT';
                } else $course->semester = 'HT';
                $course->year = substr($item['semester'], 0, 4);
                $course->course_name = $item['name'];

                $course->save();
            }
            $course->save();
        }

        return redirect()->route('daisy');

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
                    // Searchtype
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
                        ->addSearchableAttribute('course_name'); // return results for partial matches on courses
                })
                ->perform($searchString);
            foreach ($search as $subject)
            {
                foreach ($subject as $item)
                {
                    $searchResults = Video::where('course_id', $item->id)->get();
                    // Searchtype
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
        $video = '/videos/oceans.mp4';

        FFMpeg::fromDisk('public')
            ->open($video)
            ->getFrameFromSeconds(27)
            ->export()
            ->toDisk('public')
            ->save('/images/videocovers/oceans4.png');

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
    public function storeJson()
    {

        // Store json in db
        $directory = '/videos';
        $directories = Storage::disk('public')->directories($directory);
        $new_recording = 0;
        foreach ($directories as $recording)
        {
            $presentation_json = Storage::disk('public')->get($recording.'/presentation.json');
            $data = json_decode($presentation_json, true);
            //dd($data['id']);
            if(!Video::where('presentation_id', $data['id'])->first())
            {
                $x = mt_rand(1,9);
                $video = new Video();
                $video->presentation_id = $data['id'];
                $video->title = $data['title'];
                $video->thumb = $data['thumb'] ?? 'images/videocovers/kurs'.$x.'.jpg';
                $video->presenter = $data['presenter'] ?? null;
                //Convert unix timestamps
                $video->duration = (new Carbon($data['end'] ?? null))->diff(new Carbon($data['start'] ?? null))->format('%h:%I');
                $video->subtitles = $data['subtitles'] ?? null;
                $video->tags = $data['tags'] ?? null;
                $video->presentation = $presentation_json;
                $video->course_id = 1;
                $video->category_id = 1;
                $video->save();
                $new_recording++;
            }
        }
        if($new_recording > 0) return redirect('/')->with('status', 'New recordings stored in db');
        else return redirect('/')->with('status', 'No new recordings');
    }

}
