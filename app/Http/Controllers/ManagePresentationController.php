<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\Tag;
use App\Video;
use Illuminate\Http\Request;

class ManagePresentationController extends Controller
{
    public function manage()
    {
        return view('home.manage', ['videos' => Video::with('category', 'video_course.course')->latest('creation')->get(), 'allcourses' => Course::all(), 'categories' => Category::all(), 'alltags' => Tag::all()]);
    }
}
