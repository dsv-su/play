<?php

namespace App\Http\Controllers;

use App\Video;
use App\Category;
use Illuminate\Http\Request;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class TestController extends Controller
{
    public function index()
    {
        $videos = Video::with('category')->get();
        return view('home.list', compact('videos'));
    }

    public function search(Request $request)
    {
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
                    ->addSearchableAttribute('name') // return results for partial matches on usernames
                    ->addExactSearchableAttribute('title', 'name');
                })
            ->registerModel(Category::class, 'name')
             ->perform($request->input('query'));
            //->perform($request->input('query'));
        //dd($searchResults);
        return view('home.index', compact('searchResults', 'search'));
    }
}
