<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\CourseadminPermission;
use App\IndividualPermission;
use App\MediasitePresentation;
use App\Permission;
use App\Presenter;
use App\Services\Notify\PlayStoreNotify;
use App\Stream;
use App\StreamResolution;
use App\Tag;
use App\Video;
use App\VideoCourse;
use App\VideoPermission;
use App\VideoPresenter;
use App\VideoStat;
use App\VideoTag;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ManagePresentationController extends Controller
{
    public function manage()
    {
        if (app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff') {
            //If user is uploader or staff
            $user = Presenter::where('username', app()->make('play_username'))->first();
            $user_videos = VideoPresenter::where('presenter_id', $user->id ?? 0)->pluck('video_id');
            $individual_videos = IndividualPermission::where('username', app()->make('play_username'))->where('permission', 'edit')->pluck('video_id');
            $videos = Video::whereIn('id', $user_videos)->orWhereIn('id', $individual_videos)->with('category', 'video_course.course')->latest('creation')->get();

        } elseif (app()->make('play_role') == 'Administrator') {
            //If user is Administrator
            $videos = Cache::remember('videos', $seconds = 180, function () {
                return Video::with('category', 'video_course.course')->latest('creation')->get();
            });
        } else {
            return redirect('home');
        }
        return view('manage.manage', ['videos' => $videos, 'allcourses' => Course::all(), 'categories' => Category::all(), 'alltags' => Tag::all(), 'base_uri' => $this->base_uri()]);
    }

    public function setPermission(Video $video)
    {
        $permissions = Permission::all();
        $thispermissions = VideoPermission::where('video_id', $video->id)->pluck('permission_id', 'type')->toArray();

        return view('manage.permission', compact('video', 'permissions', 'thispermissions'));
    }

    public function storePermission($id, Request $request): RedirectResponse
    {
        $video_permissions = VideoPermission::where('video_id', $id)->get();
        //Delete old settings
        foreach ($video_permissions as $vp) {
            $vp->delete();
        }
        //Add new settings
        foreach ($request->perm as $permission) {
            $vp = new VideoPermission();
            $vp->video_id = $id;
            $vp->permission_id = $permission;
            if ($permission == 1) {
                $vp->type = 'public';
            } elseif ($permission == 4) {
                $vp->type = 'external';
            } else {
                $vp->type = 'private';
            }
            $vp->save();
        }

        return redirect()->route('home');
    }

    private function base_uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['list_uri'];
    }

    /**
     * @throws \Throwable
     */
    public function delete(Request $request)
    {
        /*** This method should be refactored
         ***/

        $video = Video::find($request->video_id);

        //Start transaction
        DB::beginTransaction();

        try {
            if ($video->origin == 'mediasite') {
                foreach (MediasitePresentation::where('video_id', $video->id)->get() as $mp) {
                    $mp->status = null;
                    $mp->video_id = null;
                    $mp->save();
                }
            }
            VideoCourse::where('video_id', $video->id)->delete();
            VideoTag::where('video_id', $video->id)->delete();
            VideoPresenter::where('video_id', $video->id)->delete();
            VideoPermission::where('video_id', $request->video_id)->delete();
            VideoStat::where('video_id', $request->video_id)->delete();
            CourseadminPermission::where('video_id', $request->video_id)->delete();
            IndividualPermission::where('video_id', $request->video_id)->delete();

            $streams = Stream::where('video_id', $video->id)->get();
            foreach ($streams as $stream) {
                StreamResolution::where('stream_id', $stream->id)->delete();
                $stream->delete();
            }
            $video->delete();
        } catch (Exception $e) {
            report($e);
            DB::rollback(); // Something went wrong
            return \Redirect::back()->with('error', true)->with('message', __('The presentation has not been deleted').': '.$e->getMessage());
        }

        DB::commit();   // Successfully removed

        //Send Delete notification -> when this is active
        $notify = new PlayStoreNotify($video);
        if ($notify->sendDelete()) {
            return \Redirect::back()->with('success', true)->with('message', __('The presentation has been deleted'));
        } else {
            return \Redirect::back()->with('error', true)->with('message', __('The presentation has not been deleted'));
        }

    }
}
