<?php

namespace App\Http\Controllers;

use App\Course;
use App\ManualPresentation;
use App\Permission;
use App\Services\Ldap\SukatUser;
use App\Services\Notify\PlayStoreNotify;
use App\Services\Store\SftpPlayStore;
use App\Tag;
use App\VideoPermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;

class UploadController extends Controller
{

    public function init_upload()
    {
        //Initate New upload
        $file = new ManualPresentation();
        $file->status = 'init';
        $file->user = app()->make('play_username');
        $file->local = Carbon::now()->toDateString('Y-m-d') . '_' . rand(1, 999);
        $file->base = '-';
        $file->title = '';
        $file->presenters = [];
        $file->tags = [];
        $file->courses = [];
        $file->thumb = '';
        $file->created = now()->format('Y-m-d');
        $file->duration = 0;
        $file->sources = [];
        $file->save();

        return $file;
    }

    public function upload()
    {
        $permissions = Permission::all();
        $presentation = $this->init_upload();
        $courses = Course::all();
        $tags = Tag::all();

        return view('upload.index', compact('presentation', 'permissions', 'courses', 'tags'));
    }

    public function step1($id, Request $request)
    {
        if ($request->isMethod('post')) {

            //Second validation
            $this->validate($request, [
                'title' => 'required',
                'created' => 'required',
                'disclaimer' => 'required',
            ]);

            //Retrived the upload
            $manualPresentation = ManualPresentation::find($id);

            //Presenters
            //Add current user in array
            $presenters[] = app()->make('play_username');

            if ($request->presenters) {
                foreach ($request->presenters as $presenter) {
                    $presenters[] = $presenter;
                }
            }

            //Courses
            if ($request->courses) {
                foreach ($request->courses as $course) {
                    $courses[] = $course;
                }
            } else $courses[] = '';

            //Tags
            if ($request->tags) {
                foreach ($request->tags as $tag) {
                    $tags[] = $tag;
                }
            } else $tags[] = '';

            //Set video permissions
            $video_permissions = new VideoPermission();
            if ($request->permission == 'false') {
                $video_permissions->notification_id = $manualPresentation->id;
                $video_permissions->permission_id = $request->video_permission;
                $video_permissions->type = 'public';
                $video_permissions->save();
            } else {
                $video_permissions->notification_id = $manualPresentation->id;
                $video_permissions->permission_id = $request->video_permission;
                $video_permissions->type = 'private';
                $video_permissions->save();
            }

            //Update model
            $manualPresentation->status = 'pending';
            $manualPresentation->base = '/data0/incoming/' . $manualPresentation->local;
            $manualPresentation->title = $request->title;
            $manualPresentation->description = $request->description ?? '';
            $manualPresentation->presenters = $presenters;
            $manualPresentation->tags = $tags;
            $manualPresentation->courses = $courses;
            $manualPresentation->created = strtotime($request->created);
            $id = $manualPresentation->save();

            return redirect()->action([UploadController::class, 'store'], ['id' => $manualPresentation->id]);
        }

        return back()->withInput();
    }

    public function store($id)
    {
        $presentation = ManualPresentation::find($id);

        $upload = new SftpPlayStore($presentation);
        $upload->sftpVideo();
        //$upload->sftpImage(); -> disabled
        $upload->sftpPoster();

        //Remove temp storage
        Storage::disk('public')->deleteDirectory($presentation->local);

        //Change manualupdate status
        $presentation->status = 'stored';
        $presentation->save();

        // Send notify
        $notify = new PlayStoreNotify($presentation);
        $notify->sendSuccess('manual');

        return redirect('/')->with(['message' => 'Presentationen har laddats upp!']);
    }

    public function ldap_search(Request $request)
    {
        return SukatUser::whereStartsWith('cn', $request->q)->limit(5)->get();
    }

    public function course_search(Request $request)
    {
        return Course::where('name', 'LIKE', '%' . $request->course . '%')->orWhere('designation', 'LIKE', '%' . $request->course . '%')->get();
    }

    public function tag_search(Request $request)
    {
        return Tag::where('name', 'LIKE', $request->tag . '%')->get();
    }
}
