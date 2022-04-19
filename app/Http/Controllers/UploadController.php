<?php

namespace App\Http\Controllers;

use App\Course;
use App\CoursesettingsUsers;
use App\Jobs\JobUploadProgressNotification;
use App\ManualPresentation;
use App\Permission;
use App\Services\Daisy\DaisyAPI;
use App\Services\Ldap\SukatUser;
use App\Services\Notify\PlayStoreNotify;
use App\Services\Store\SftpPlayStore;
use App\Tag;
use App\VideoPermission;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Monolog\DateTimeImmutable;
use Storage;

class UploadController extends Controller
{

    public function init_upload()
    {
        //Initate New upload
        $file = new ManualPresentation();
        $file->status = 'init';
        $file->user = app()->make('play_username');
        $file->user_email = app()->make('play_email');
        $file->local = Carbon::now()->toDateString('Y-m-d') . '_' . rand(1, 999);
        $file->base = '-';
        $file->title = '';
        $file->title_en = '';
        $file->presenters = [];
        $file->tags = [];
        $file->courses = [];
        $file->daisy_courses = [];
        $file->thumb = '';
        $file->created = now()->format('Y-m-d');
        $file->duration = 0;
        $file->sources = [];
        $file->save();
        $file->local = $file->local . $file->id;
        $file->save();

        return $file;
    }

    public function upload(Request $request)
    {
        $permissions = Permission::all();

        if ($request->old('prepopulate')) {
            $presentation = ManualPresentation::where('user', app()->make('play_username'))->latest()->first();
        } else {
            $presentation = $this->init_upload();
        }

        return view('upload.index', compact('presentation', 'permissions'));
    }

    public function pending_uploads()
    {
        $pending = ManualPresentation::where('user', app()->make('play_username'))->where('status', 'sent')->get();
        if ($pending->count()) {
            return view('upload.pending', ['pending' => $pending]);
        } else {
            return redirect()->route('home');
        }
    }

    public function step1($id, Request $request)
    {
        if ($request->isMethod('post')) {

            //Second validation
            $this->validate($request, [
                'title' => 'required',
                'title_en' => 'required',
                'created' => 'required',
                //Disabled for now
                //'disclaimer' => 'required',
            ]);

            //Retrived the upload
            $manualPresentation = ManualPresentation::find($id);

            //Presenters
            //Add current user in array
            $presenters[] = app()->make('play_username');

            if ($request->presenters) {
                foreach ($request->presenters as $presenter) {
                    //Retrive only username
                    $username = preg_filter("/[^(]*\(([^)]+)\)[^()]*/", "$1", $presenter);
                    $presenters[] = $username;
                }
            } else {
                $presenters = [];
            }

            //Courses
            if ($request->courses) {
                foreach ($request->courses as $course) {
                    //$courses[] = $course;
                    //Switching to courseID. To be enabled after play-store api has been modified
                    $daisy_courses[] = (int)$course;
                    $courses[] = Course::find($course)->designation;

                }
            } else {
                $courses = [];
                $daisy_courses = [];
            }

            //Tags
            if ($request->tags) {
                foreach ($request->tags as $tag) {
                    $tags[] = $tag;
                }
            } else $tags = [];

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
            $manualPresentation->title_en = $request->title_en;
            $manualPresentation->description = $request->description ?? '';
            $manualPresentation->presenters = $presenters;
            $manualPresentation->tags = $tags;
            $manualPresentation->courses = $courses;
            $manualPresentation->daisy_courses = $daisy_courses;
            $manualPresentation->created = Carbon::createFromFormat('d/m/Y', $request->created)->timestamp;
            $id = $manualPresentation->save();

            return redirect()->action([UploadController::class, 'store'], ['id' => $manualPresentation->id]);
        }

        return back()->withInput();
    }

    public function store($id)
    {
        $presentation = ManualPresentation::find($id);

        //Send email to uploader
        $job = (new JobUploadProgressNotification($presentation));

        // Dispatch Job and continue
        dispatch($job);

        $upload = new SftpPlayStore($presentation);
        $upload->sftpVideo();
        $upload->sftpSubtitle();
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

        return redirect('/');
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
