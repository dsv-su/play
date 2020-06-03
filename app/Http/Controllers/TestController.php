<?php

namespace App\Http\Controllers;

use App\Course;
use App\Video;
use App\Category;
use Illuminate\Http\Request;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class TestController extends Controller
{
    public function index()
    {
        $videos = Video::with('category', 'course')->get();

        return view('home.list', compact('videos'));
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
        $search = 1;
        /*
        $searchResults = (new Search())
            ->registerModel(Video::class, 'name')
            ->registerModel(Category::class, 'name')
            ->perform($request->input('query'));
        */
        $searchResults = (new Search())
            ->registerModel(Video::class, function(ModelSearchAspect $modelSearchAspect) {
                $modelSearchAspect
                    ->addSearchableAttribute('title') // return results for partial matches on titles
                    ->addExactSearchableAttribute('title', 'name');
                })
            //->registerModel(Category::class, 'category_name')
            ->registerModel(Course::class, 'course_name')
             ->perform($request->input('query'));
            //->perform($request->input('query'));
        dd($searchResults);

        return view('home.index', compact('searchResults', 'search', 'play_user'));
    }
}
