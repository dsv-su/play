<?php

namespace App\Http\Controllers;

use App\Course;
use App\CoursesettingsUsers;
use App\Jobs\JobUploadProgressNotification;
use App\ManualPresentation;
use App\Permission;
use App\Services\Daisy\DaisyAPI;
use App\Services\Ffmpeg\DetermineDurationVideo;
use App\Services\Ldap\SukatUser;
use App\Services\Notify\PlayStoreNotify;
use App\Services\Store\SftpPlayStore;
use App\Tag;
use App\VideoPermission;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
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
            dd($request->all());
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
            $manualPresentation->base = '/data0/'. $this->storage() . '/' . $manualPresentation->local;
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
        /*$job = (new JobUploadProgressNotification($presentation));

        // Dispatch Job and continue
        dispatch($job);*/

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

        //Change manualupdate status
        $presentation->status = 'stored';
        $presentation->save();

        // Send notify
        $notify = new PlayStoreNotify($presentation);
        return $notify->sendSuccess('manual');

        return redirect('/');
    }

    /**
     * Handles the file upload
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
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

            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            $this->saveFile($save->getFile(), $request);
            return unlink($save->getFile()->getPathname());
            //return $this->saveFile($save->getFile(), $request);
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
    protected function saveFile(UploadedFile $file, Request $request) {

        $fileName = $this->createFilename($file);

        // Get file mime type
        $mime_original = $file->getMimeType();
        $mime = str_replace('/', '-', $mime_original);

        $folder  = $request->localdir . '/video/';
        $finalPath = '/' . $this->storage() . '/' . $folder;

        $fileSize = $file->getSize();
        Storage::disk('play-store')->putFileAs($finalPath, $file, $fileName);

        // Update status in model
        //$this->metadata($request);
        $this->addFilesCount($request);

        return response()->json([
            'path' => $finalPath,
            'name' => $fileName,
            'mime_type' => $mime
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

        //Generate a unique name
        //$filename = $file->hashName();

        //We use the original name
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

            //Unlink poster
            Storage::disk('play-store')->delete($finalPosterPath . $thumb_name.'.png');
            //Update file status in model
            //$this->metadata($request);
            $this->deleteFilesCount($request);
            return response()->json([
                'status' => 'ok'
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'error'
            ], 403);
        }
    }

    public function DurationVideo($filename)
    {
        $video = $filename;
        $media = FFMpeg::fromDisk('play-store')->open($video);
        return $media->getDurationInSeconds();
    }

    public function createThumb($directory, $video, $seconds, $streamduration)
    {
        $base = basename($video);
        $thumb_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $base);
        //Generate thumb
        //Create thumb and store in folder
        do {
            try {
                FFMpeg::fromDisk('play-store')
                    ->open($video)
                    ->getFrameFromSeconds($seconds)
                    ->export()
                    ->toDisk('play-store')
                    ->save($directory.'/poster/'.$thumb_name.'.png');
                $seconds++;
                if($seconds > $streamduration) {
                    break; //Stops the loop -> TODO we should add a message to say that the thumb will be generated on play-store instead
                }
            } catch (EncodingException $exception) {
                $command = $exception->getCommand();
                $errorLog = $exception->getErrorOutput();
            }

        }
        while (!\Illuminate\Support\Facades\Storage::disk('public')->exists($directory.'/poster/'.$thumb_name.'.png'));

        return Storage::disk('public')->url($directory.'/poster/'.$thumb_name.'.png');
    }

    protected function metadata(Request $request)
    {
        $finalPath = $this->storage() . '/'. $request->localdir;
        $videoPath = $finalPath . '/video/';
        //Updates the source attribute after each added/deleted video
        $presentation = ManualPresentation::where('local', $request->localdir)->first();
        $presentation->sources = [];
        //Update video source
        foreach (\Illuminate\Support\Facades\Storage::disk('play-store')->files($videoPath) as $key => $filename) {
            //Add duration
            if($key ==  0 ) {
                $presentation->duration = $this->DurationVideo($filename);
            }

            //Set time in sec for thumb generation
            if($presentation->duration < 30 ) {
                $thumbcreated_after = $presentation->duration/3;
            } else {
                //Fallback
                $thumbcreated_after = 30;
            }

            //Create thumb for uploaded video
            $this->createThumb($finalPath, $filename, $thumbcreated_after, $presentation->duration);

            //Add video source
            $this->source[$key]['video'] = 'video/'. basename($filename);

            //Add poster source
            $thumb_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($filename));
            $this->source[$key]['poster'] = 'poster/'. $thumb_name . '.png';

            //Add playAudio default setting
            if($key > 0 ) {
                $this->source[$key]['playAudio'] = false;
            } else {
                $this->source[$key]['playAudio'] = true;
            }

            $presentation->sources = $this->source;

        }
        $presentation->save();
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
