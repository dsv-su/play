<?php

namespace App\Http\Controllers;

use App\Course;
use App\ManualPresentation;
use App\Services\Ffmpeg\DetermineDurationVideo;
use App\Services\Ldap\SukatUser;
use App\Services\Notify\PlayStoreNotify;
use App\Services\Store\SftpPlayStore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Storage;

class UploadController extends Controller
{

    public function init_upload()
    {
        //Initate New upload
        $file = new ManualPresentation();
        $file->status = 'init';
        $file->user = app()->make('play_username');
        $file->local = '-';
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
        $final = 0;
        $durationInSeconds = 0;
        return view('upload.index', $this->init_upload(), compact('final', 'durationInSeconds'));
    }

    public function step1($id, Request $request)
    {
        if ($request->isMethod('post')) {

            //First validation
            $this->validate($request, [
                'title' => 'required',
                'created' => 'required',
                'filenames' => 'required',
                'filenames.*' => 'required|mimes:mp4,mov,avi,webm,mpg,mpeg,wmv,qt,avchd'
            ]);

            //Retrived the upload
            $manualPresentation = ManualPresentation::find($id);

            //Store uploaded videofiles
            $files = [];
            if ($request->hasfile('filenames')) {
                //Make unique directory
                $dirname = Carbon::now()->toDateString('Y-m-d') . '_' . rand(1, 999);
                Storage::disk('public')->makeDirectory($dirname . '/video');
                //Files
                $audio = 0;
                foreach ($request->file('filenames') as $file) {
                    $name = 'media' . ($audio + 1) . '.' . $file->extension();
                    $file->move(storage_path('/app/public/' . $dirname . '/video'), $name);
                    $files[$audio]['video'] = 'video/' . $name;
                    $files[$audio]['poster'] = 'poster/poster_' . ($audio + 1) . '.png';
                    if ($audio == 0) {
                        $files[$audio]['playAudio'] = true;
                    } else {
                        $files[$audio]['playAudio'] = false;
                    }
                    $audio++;
                }
            }

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

            //Determine duration of primary media
            $primary_video_name = substr($files[0]['video'], strrpos($files[0]['video'], '/') + 1);
            $media = new DetermineDurationVideo($dirname);
            $durationInSeconds = $media->duration($primary_video_name);

            //Check media diffs (+- 3 sec)
            if(!$media->check()) {
                return back()->withInput()->with(['error' => 'Mediafilerna har olika längd och skiljer åt mer än +/- 3 sek. Kontrollera och ladda upp på nytt!']);
            }

            //Default entitlement
            if($request->permission == 'false') {
                $default_entitlement = 'urn:mace:swami.se:gmai:dsv-user:staff;urn:mace:swami.se:gmai:dsv-user:student';
            }

            //Update model
            $manualPresentation->status = 'pending';
            $manualPresentation->local = $dirname;
            $manualPresentation->base = '/data0/incoming/' . $dirname;
            $manualPresentation->title = $request->title;
            $manualPresentation->presenters = $presenters;
            $manualPresentation->tags = $tags;
            $manualPresentation->courses = $courses;
            //$manualPresentation->thumb = 'image/'.$request->thumb; //TODO
            $manualPresentation->created = strtotime($request->created);
            $manualPresentation->duration = $durationInSeconds;
            $manualPresentation->sources = $files;
            $manualPresentation->permission = $request->permission;
            $manualPresentation->entitlement = $request->entitlement ?? $default_entitlement;
            //$id = $manualPresentation->save();
            $manualPresentation->thumb = $this->gen_thumb_poster($manualPresentation, $durationInSeconds/3);
            $id =$manualPresentation->save();

            $final = 1;

            return view('upload.index', $manualPresentation, compact('durationInSeconds', 'final'));
        }

        return back()->withInput();
    }

    private function gen_thumb_poster(ManualPresentation $manualPresentation, $seconds)
    {
        //Create thumb and store in folder
        FFMpeg::fromDisk('public')
            ->open('/' . $manualPresentation->local . '/video/media1.mp4')
            ->getFrameFromSeconds($seconds)
            ->export()
            ->toDisk('public')
            ->save('/' . $manualPresentation->local . '/image/primary_thumb.png');

        //Create posters
        $poster = 1;
        foreach ($manualPresentation->sources as $source) {
            FFMpeg::fromDisk('public')
                ->open('/' . $manualPresentation->local . '/video/media' . $poster . '.mp4')
                ->getFrameFromSeconds($seconds)
                ->export()
                ->toDisk('public')
                ->save('/' . $manualPresentation->local . '/poster/poster_' . $poster . '.png');
            $poster++;
        }

        return 'image/primary_thumb.png';
    }

    public function thumb($id, Request $request)
    {
        $presentation = ManualPresentation::find($id);

        //Create thumb and store in folder
        FFMpeg::fromDisk('public')
            ->open('/' . $presentation->local . '/video/media1.mp4')
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save('/' . $presentation->local . '/image/primary_thumb' . $id . '.png');
        //Store thumb in model
        $presentation->thumb = 'image/primary_thumb' . $id . '.png';
        $presentation->save();
        $durationInSeconds = $presentation->duration;
        $final = 1;

        return view('upload.index', $presentation, compact('durationInSeconds', 'final'));
    }

    public function poster($id, Request $request)
    {
        $presentation = ManualPresentation::find($id);
        $durationInSeconds = $presentation->duration;

        FFMpeg::fromDisk('public')
            ->open('/' . $presentation->local . '/video/media' . $request->poster . '.mp4')
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save('/' . $presentation->local . '/poster/poster_' . $request->poster . '.png');
        $final = 1;

        return view('upload.index', $presentation, compact('durationInSeconds', 'final'));
    }

    public function store($id)
    {
        $presentation = ManualPresentation::find($id);

        $upload = new SftpPlayStore($presentation);
        $upload->sftpVideo();
        $upload->sftpImage();
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
        return SukatUser::whereStartsWith('cn', $request->q)->get();
    }

    public function course_search(Request $request)
    {
        return Course::where('name', 'LIKE', $request->course.'%')->get();
    }
}
