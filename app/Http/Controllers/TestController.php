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
        if($request->input('type') == null)
        {
            $searchResults = (new Search())
                ->registerModel(Video::class, function(ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('title') // return results for partial matches on titles
                        ->addSearchableAttribute('tags'); // return results for partial matches on tags
                })
                ->perform($request->input('query'));

            return view('home.index', compact('searchResults', 'search', 'play_user'));
        }
        elseif ($request->input('type') == 'type-lectures')
        {
            dd('Sorry, LECTURES search has not been implemented');
        }
        elseif ($request->input('type') == 'type-category')
        {
            dd('Sorry, CATEGORY search has not been implemented');
            $search = (new Search())
                ->registerModel(Category::class, function(ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('category_name'); // return results for partial matches on name
                })
                ->perform($request->input('query'));
            dd($modelSearchAspect);

            //dd($searchResults);
            return view('home.index', compact('searchResults', 'search', 'play_user'));
        }
        elseif ($request->input('type') == 'type-course')
        {
            dd('Sorry, COURSE search has not been implemented');
        }
        elseif ($request->input('type') == 'type-latest')
        {
            dd('Sorry, LATEST search has not been implemented');
        }

    }
}
