<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\Permission;
use App\Presenter;
use App\Tag;
use App\Video;
use App\VideoPermission;
use App\VideoPresenter;
use Illuminate\Http\Request;

class ManagePresentationController extends Controller
{
    public function manage()
    {
        if(app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            //If user is uploader or staff
            $user = Presenter::where('username', app()->make('play_username'))->first();
            $user_videos = VideoPresenter::where('presenter_id', $user->id ?? 0)->pluck('video_id');
            $videos = Video::whereIn('id', $user_videos)->with('category', 'video_course.course')->latest('creation')->get();
        } elseif (app()->make('play_role') == 'Administrator') {
            //If user is Administrator
            $videos = Video::with('category', 'video_course.course')->latest('creation')->get();
        }
        return view('home.manage', ['videos' => $videos, 'allcourses' => Course::all(), 'categories' => Category::all(), 'alltags' => Tag::all()]);
    }

    public function setPermission(Video $video)
    {
        $permissions = Permission::all();
        $thispermissions = VideoPermission::where('video_id', $video->id)->pluck('permission_id','type')->toArray();

        return view('manage.permission', $video, compact('permissions','thispermissions'));
    }
}
