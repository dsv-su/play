<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\Permission;
use App\Presenter;
use App\Services\Video\VideoResolution;
use App\Tag;
use App\Video;
use App\VideoPermission;
use App\VideoPresenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
            $videos = Cache::remember('videos', $seconds = 30, function () {
                return Video::with('category', 'video_course.course')->latest('creation')->get();
            });
        } else {
            return redirect('home');
        }
        return view('manage.manage', ['videos' => $videos, 'allcourses' => Course::all(), 'categories' => Category::all(), 'alltags' => Tag::all()]);
    }

    public function setPermission(Video $video)
    {
        $permissions = Permission::all();
        $thispermissions = VideoPermission::where('video_id', $video->id)->pluck('permission_id','type')->toArray();

        return view('manage.permission', compact('video','permissions','thispermissions'));
    }

    public function storePermission($id, Request $request): RedirectResponse
    {
        $video_permissions = VideoPermission::where('video_id', $id)->get();
        //Delete old settings
        foreach($video_permissions as $vp) {
            $vp->delete();
        }
        //Add new settings
        foreach($request->perm as $permission) {
            $vp = new VideoPermission();
            $vp->video_id = $id;
            $vp->permission_id = $permission;
            if($permission == 1) {
                $vp->type = 'public';
            }
            elseif ($permission == 4) {
                $vp->type = 'external';
            }
            else {
                $vp->type = 'private';
            }
            $vp->save();
        }

        return redirect()->route('home');
    }
}
