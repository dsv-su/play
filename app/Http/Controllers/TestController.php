<?php

namespace App\Http\Controllers;

use App\CategorySearchAspect;
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
        // Searchtype 1
        $search = 1;
        if($request->input('query'))
        {
            $searchString = $request->input('query');
        }
        else $searchString = 'Inget angivet';


        if($request->input('type') == null)
        {
            $searchResults = (new Search())
                ->registerModel(Video::class, function(ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('title') // return results for partial matches on titles
                        ->addSearchableAttribute('tags'); // return results for partial matches on tags

                })
                ->perform($searchString);


            //Search in relations
            $searchRelations = (new Search())
                ->registerAspect(CategorySearchAspect::class)
                ->perform($searchString);
            if($searchRelations->count() > 0)
            {
                foreach ($searchRelations as $relations)
                {
                    $data = Video::where('category_id', $relations->url)->get();
                }
                $search = 2;
                return view('home.index', compact('searchResults','searchRelations','data', 'search', 'play_user'));
            }


            return view('home.index', compact('searchResults', 'search', 'play_user'));
        }

        elseif ($request->input('type') == 'type-lectures')
        {
            dd('Sorry, LECTURES search has not been implemented');
        }
        elseif ($request->input('type') == 'type-category')
        {
            //dd('Sorry, CATEGORY search has not been implemented');
            $search = (new Search())
                ->registerModel(Category::class, function(ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('category_name'); // return results for partial matches on name
                })
                ->perform($searchString);
            foreach ($search as $subject)
            {
                foreach ($subject as $item)
                {
                    $searchResults = Video::where('category_id', $item->id)->get();
                    // Searchtype 2
                    $search = 3;
                    return view('home.index', compact('searchResults', 'search', 'play_user'));
                }
            }
            $searchResults = $search;
            // Searchtype 1
            $search = 1;
            return view('home.index', compact('searchResults', 'search', 'play_user'));

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
