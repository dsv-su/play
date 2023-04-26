<?php

namespace App\Http\Controllers;

use App\Course;
use App\Jobs\JobUploadProgressNotification;
use App\ManualPresentation;
use App\Permission;
use App\Services\Ldap\SukatUser;
use App\Services\Notify\PlayStoreNotify;
use App\Services\Store\SftpPlayStore;
use App\Services\Upload\Metadata;
use App\Tag;
use App\VideoPermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Storage;

class UploadController extends Controller
{
    protected $sourse = [];

    public function init_upload()
    {
        //Initate New upload
        $file = new ManualPresentation();
        $file->status = 'init';
        $file->user = app()->make('play_username');
        $file->user_email = app()->make('play_email');
        $file->local = Carbon::now()->toDateString('Y-m-d') . '_' . rand(1, 999);
        $file->upload_dir = '-';
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
        $file->generate_subtitles = [];
        $file->save();
        $file->local = $file->local . $file->id;
        $file->save();

        return $file;
    }

    public function upload(Request $request)
    {
        $permissions = Permission::all();

        if ($request->old('prepopulate')) {
            $presentation =  ManualPresentation::where('user', app()->make('play_username'))->latest()->first();
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

          //  if ($request->presenters) {
          //      foreach ($request->presenters as $presenter) {
                    //Retrive only username
                   // $username = preg_filter("/[^(]*\(([^)]+)\)[^()]*/", "$1", $presenter);
                   // $presenters[] = $username;
          //      }
          //  }

            //Courses
            if ($request->courses) {
                foreach ($request->courses as $course) {
                    $daisy_courses[] = (int)$course;
                    $course = Course::find($course);
                    $courses[] = \Illuminate\Support\Collection::make([
                        'designation' => $course->designation,
                        'semester' => Str::lower($course->semester) . substr($course->year, 2)
                    ]);
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

            //Set visibility
            switch($request->video_visibility) {
                case('visible'):
                    $manualPresentation->visibility = true;
                    $manualPresentation->unlisted = false;
                    break;
                case('private'):
                    $manualPresentation->visibility = false;
                    $manualPresentation->unlisted = false;
                    break;
                case('unlisted'):
                    $manualPresentation->visibility = false;
                    $manualPresentation->unlisted = true;
                    break;
            }

            //Update model
            $manualPresentation->status = 'pending';
            $manualPresentation->upload_dir = '/data0/'. $this->storage() . '/' . $manualPresentation->local;
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

        /***
         * Disabled SFTP upload to server
         */
        /*
        $upload = new SftpPlayStore($presentation);
        $upload->sftpVideo();
        $upload->sftpSubtitle();
        //$upload->sftpImage(); -> disabled
        $upload->sftpPoster();
        */

        // Moved to api -> the files are stored until upload is completed
        //Remove temp storage
        //Storage::disk('public')->deleteDirectory($presentation->local);

        //Create thumbs and metadata
        $metadata = new Metadata();
        $metadata->create($presentation);

        //Change manualupdate status
        $presentation->status = 'stored';
        $presentation->save();

        // Send notify
        $notify = new PlayStoreNotify($presentation);
        $notify->sendSuccess('default');

        return redirect('/');
    }

    /**
     * Handles the file upload
     *
     * @param Request $request
     *
     * @throws UploadMissingFileException
     * @throws UploadFailedException
     */

    public function chunkupload(Request $request)
    {
        //Create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // Check if the upload is success, throw exception or return response
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        //Receive the file
        $save = $receiver->receive();

        //Check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {

            $this->saveFile($save->getFile(), $request, 'video');
            // Update status in model
            $this->addFilesCount($request);
            //return unlink($save->getFile()->getPathname());
            return true;

        }

        //Current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    /**
     * Saves the file
     *
     * @param UploadedFile $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveFile(UploadedFile $file, Request $request, $type) {

        $fileName = $this->createFilename($file);

        // Get file mime type
        $mime_original = $file->getMimeType();
        $mime = str_replace('/', '-', $mime_original);
        switch($type) {
            case('video'):
                $folder  = $request->localdir . '/video/';
                break;
            case('thumb'):
                $folder  = $request->thumbdir . '/poster/';
                $presentation = ManualPresentation::where('local', $request->thumbdir)->first();
                $presentation->thumb = 'poster/' . $fileName;
                $presentation->save();
                break;
            case('subtitle'):
                $folder  = $request->subtitledir . '/subtitle/';
                break;
        }

        $finalPath = '/' . $this->storage() . '/' . $folder;

        $fileSize = $file->getSize();
        Storage::disk('play-store')->putFileAs($finalPath, $file, $fileName);

        return response()->json([
            'path' => $finalPath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    public function thumbupload(Request $request)
    {
        //Create the file receiver
        $receiver = new FileReceiver("thumb", $request, HandlerFactory::classFromRequest($request));

        // Check if the upload is success, throw exception or return response
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        //Receive the file
        $save = $receiver->receive();

        //Check if the upload has finished
        if ($save->isFinished()) {
            $this->saveFile($save->getFile(), $request, 'thumb');
            return unlink($save->getFile()->getPathname());
        }

        //Current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file) {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension

        //We use the original hashed name
        return $filename.".".$extension;
    }

    /**
     * Delete uploaded file WEB ROUTE
     * @param Request request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chunkdelete(Request $request){

        $file = $request->filename;
        $thumb_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);
        $dir = $request->localdir;

        $filePath = $this->storage() . "/{$dir}/video/";
        $posterPath = $this->storage() . "/{$dir}/poster/";
        $finalFilePath = $filePath;
        $finalPosterPath = $posterPath;


        if (Storage::disk('play-store')->delete($finalFilePath.$file) ){

            //Unlink related poster
            Storage::disk('play-store')->delete($finalPosterPath . $thumb_name.'.png');

            $this->deleteFilesCount($request);
            return response()->json([
                'status' => 'ok'
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'File missing'
            ], 200);
        }
    }

    public function thumbdelete(Request $request){

        $file = $request->filename;
        $dir = $request->localdir;

        $posterPath = $this->storage() . "/{$dir}/poster/";
        $finalPosterPath = $posterPath;

        if (Storage::disk('play-store')->delete($finalPosterPath . $file) ){
            return response()->json([
                'status' => 'ok'
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'Thumb removed'
            ], 200);
        }
    }

    public function subtitleupload(Request $request)
    {
        //Create the file receiver
        $receiver = new FileReceiver("subtitle", $request, HandlerFactory::classFromRequest($request));

        // Check if the upload is success, throw exception or return response
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        //Receive the file
        $save = $receiver->receive();

        //Check if the upload has finished
        if ($save->isFinished()) {
            $this->saveFile($save->getFile(), $request, 'subtitle');
            return unlink($save->getFile()->getPathname());
        }

        //Current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    public function subtitledelete(Request $request)
    {
        $file = $request->filename;
        $dir = $request->localdir;

        $posterPath = $this->storage() . "/{$dir}/subtitle/";
        $finalSubtitlePath = $posterPath;

        if (Storage::disk('play-store')->delete($finalSubtitlePath . $file) ){
            //Also delete subtitle directory
            Storage::deleteDirectory($finalSubtitlePath);

            return response()->json([
                'status' => 'ok'
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'File removed'
            ], 200);
        }
    }

    protected function addFilesCount(Request $request): void
    {
        $presentation = ManualPresentation::where('local', $request->localdir)->first();
        $presentation->files++;
        $presentation->save();
    }

    protected function deleteFilesCount(Request $request): void
    {
        $presentation = ManualPresentation::where('local', $request->localdir)->first();
        $presentation->files--;
        $presentation->save();
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

    private function storage()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['nfs']['storage'];
    }
}
