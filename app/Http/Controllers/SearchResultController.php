<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Services\Filters\VisibilityFilter;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchResultController extends Controller
{
    public function tags(VisibilityFilter $visibility, $tag)
    {
        $videos = Video::with([
            'tags:id,name',
            'courses:id,name',
            'presenters:id,username,name',
            'videoCourse:id,video_id,course_id',
        ])
            ->whereHas('tags', fn ($q) => $q->where('name', $tag))
            ->orderByDesc('created_at')
            ->get();


        $videos = $visibility->filter($videos);

        return view('search.navigator', ['videos' => $videos, 'tag' => $tag]);
    }

    public function courses(VisibilityFilter $visibility, $designation)
    {
        $videos = Video::with([
            'tags:id,name',
            'courses:id,name',
            'presenters:id,username,name',
            'videoCourse:id,video_id,course_id',
        ])
            ->whereHas('courses', fn ($q) => $q->where('designation', $designation))
            ->orderByDesc('created_at')
            ->get();


        $videos = $visibility->filter($videos);

        return view('search.navigator', ['videos' => $videos, 'designation' => $designation]);
    }

    public function presenters(VisibilityFilter $visibility, $presenter)
    {
        $videos = Video::with([
            'tags:id,name',
            'courses:id,name',
            'presenters:id,username,name',
            'videoCourse:id,video_id,course_id',
        ])
            ->whereHas('presenters', fn ($q) => $q->where('username', $presenter))
            ->orderByDesc('created_at')
            ->get();


        $videos = $visibility->filter($videos);

        return view('search.navigator', ['videos' => $videos, 'presenter_search' => $presenter]);
    }
}
