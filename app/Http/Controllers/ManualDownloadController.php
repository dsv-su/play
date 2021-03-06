<?php

namespace App\Http\Controllers;

use App\ManualPresentation;
use App\Permission;
use App\Presentation;
use App\Services\DownloadZip;
use App\Services\Ffmpeg\DetermineDurationVideo;
use App\Services\Notify\PlayStoreNotify;
use App\Services\Store\DownloadResource;
use App\Services\Store\SftpPlayStore;
use App\Services\TicketHandler;
use App\Services\Video\VideoResolution;
use App\Video;
use App\VideoStat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Storage;


class ManualDownloadController extends Controller
{
    /**
     * Downloads media from storage server.
     *
     *
     */

    protected $directory, $contents, $file;
    protected $video_name;
    protected  $download_dir;
    protected $store_server;
    private $download;

    public function __construct()
    {
        $this->store_server = 'https://play-store.dsv.su.se/presentation/';
    }
    public function initDownload(Video $video, $resolution)
    {
        //Initiates and starts the download/edit process
        //if(!$presentation = Presentation::find($video->id)) {
        if(! Presentation::where('id', $video->id)->where('resolution', $resolution)->first()) {
                if(! $presentation = Presentation::find($video->id)) {
                    $presentation = new Presentation();
                }
                $download_dir = $this->setDownloaddir();
                $presentation->id = $video->id;
                $presentation->status = 'request download';
                $presentation->resolution = $resolution;
                $presentation->user = app()->make('play_user');
                $presentation->local = $download_dir;
                $presentation->base = '/data0/incoming/' . $download_dir;
                $presentation->title = $video->title;
                $presentation->presenters = '[]';
                $presentation->tags = '[]';
                $presentation->courses = '[]';
                $presentation->thumb = '';//$video->thumb;
                $presentation->created = $video->creation;
                $presentation->duration = $video->duration;
                $presentation->sources = json_decode($video->sources, true);
                $presentation->save();

                return true;

            }
        else {
                //Returns false if there already exist a download/edit
                return false;
            }
    }

    public function step1(Video $video, Request $request)
    {
        if($this->initDownload($video, $request->res)) {
            if ($this->checkDownload($video)) {
                return redirect()->action([ManualDownloadController::class, 'step2'], ['video' => $video]);
            } else {
                return view('download.download_index', compact('video'));
            }
        }
        else {
            if ($this->checkDownload($video)) {
                return redirect()->action([ManualDownloadController::class, 'step2'], ['video' => $video]);
            }
            return view('download.download_index', compact('video'));
        }

    }

    public function step2(Video $video)
    {
        $presentation = Presentation::find($video->id);
        $path = $presentation->local.'/';

        if (Storage::disk('public')->exists($path.$video->id.'.zip')) {
            //Register stats
            $stats = VideoStat::firstOrNew(['video_id' => $video->id]);
            $stats->download = $stats->download + 1;
            $stats->save();

            return Storage::disk('public')->download($path.$video->id.'.zip');
        }
        else {
            return redirect('/')->with(['message' => 'Ett fel har inträffat. Error: File not found!', 'alert' => 'alert-danger']);
        }
    }

    public function download(Video $video)
    {
        $presentation = Presentation::latest()->first();

        //Download directories to use
        $dir_thumb = $presentation->local.'/image/';
        $dir_video = $presentation->local.'/video/';
        $dir_poster = $presentation->local.'/poster/';

        //Download Files

        //Image
        $thumb_url = $video->thumb;
        $thumb_name = substr($video->thumb, strrpos($video->thumb, '/') + 1);
        // Download thumb
        \Storage::disk('public')->makeDirectory($dir_thumb);
        $file = new DownloadResource($video, new TicketHandler($video));
        $file->getFile($dir_thumb.$thumb_name,$thumb_url);

        //Video and poster files
        foreach (json_decode($video->sources, true) as $source) {
            // Support videos that havent been converted in multiple resolutions
            if($presentation->resolution == '999') {
                $video_name = substr($source['video'], strrpos($source['video'], '/') + 1);
            } else {
                $video_name = substr($source['video'][$presentation->resolution], strrpos($source['video'][$presentation->resolution], '/') + 1);
            }

            $poster_name = substr($source['poster'], strrpos($source['poster'], '/') + 1);

            // Download video
            \Storage::disk('public')->makeDirectory($dir_video);

            // Support videos that havent been converted in multiple resolutions
            if($presentation->resolution == '999') {
                $file->getFile($dir_video.$video_name, $source['video']);
            } else {
                $file->getFile($dir_video.$video_name, $source['video'][$presentation->resolution]);
            }

            // Download posters
            \Storage::disk('public')->makeDirectory($dir_poster);

            $file->getFile($dir_poster.$poster_name, $source['poster']);

        }

        //Make zipfolder of presentation
        $file = new DownloadZip($video, $presentation->local);
        $file->makezip();
    }

    public function step3(Video $video)
    {
        /* This method should be refactored or removed */

        dd($video);

        if($presentation = Presentation::find($video->id)) {

            $final = 0;
            //Form input
            if(count($owners = $video->presenters()) > 0) {

            } else {
                $owners = [];
            }
            $coursebindings = $video->courses();

            $tags = $video->tags();
            $permissions = Permission::all();
            $durationInSeconds = 0;
            //Convert unixtimestamp to date
            $creationdate = $this->getDateAttribute($video->creation);
            //Get downloaded files names
            $download_files = $this->getDownloadedVideoFiles($presentation->local);

            return view('download.index',  $presentation, compact('final', 'owners', 'creationdate', 'coursebindings', 'tags', 'permissions', 'durationInSeconds', 'download_files','video'));

        } else {
            return redirect()->action([ManualDownloadController::class, 'step1'], ['video' => $video]);
        }

    }

    public function step4($id)
    {
        $presentation = Presentation::find($id);

        //Make remote folders and send all files
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
        $notify->sendSuccess('update');

        //Remove presentation
        Presentation::destroy($id);

        return redirect('/')->with(['message' => 'Presentationen har redigerats och laddats upp!']);
    }

    public function store(Request $request, Video $video)
    {

        $presentation = Presentation::find($video->id);

        //Existing presentation files
        if($request->media == 'existing_media') {

            if($request->isMethod('post')) {
                //First validation
                $this->validate($request, [
                    'title' => 'required',
                    'created' => 'required',
                    'validate' => 'required'
                ]);

                //Get existing files
                $files = [];
                $audio = 0;
                $downloaded_files = $this->getDownloadedVideoFiles($presentation->local);
                foreach ($downloaded_files as $file) {
                    $files[$audio]['video'] = 'video/'.$file;
                    $files[$audio]['poster'] = 'poster/poster_'.($audio+1).'.png';
                    if($audio == 0){
                        $files[$audio]['playAudio'] = true;
                    } else {
                        $files[$audio]['playAudio'] = false;
                    }
                    $audio++;
                }

                //Store metadata

                //Dirname
                $dirname = $presentation->local;

                //Presenters
                if ($request->presenters) {
                    foreach ($request->presenters as $presenter) {
                        $presenters[] = $presenter;
                    }
                } else $presenters[] = '';

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

                //Default entitlement _> has to be refactored
                if ($request->permission == 'false') {
                    $default_entitlement = 'urn:mace:swami.se:gmai:dsv-user:staff;urn:mace:swami.se:gmai:dsv-user:student';
                }

                //Determine duration of primary media
                $primary_video_name = substr($files[0]['video'], strrpos($files[0]['video'], '/') + 1);
                $media = new DetermineDurationVideo($dirname);
                $durationInSeconds = $media->duration($primary_video_name);

                //Update Presentation
                $presentation->status = 'update';
                $presentation->title = $request->title;
                $presentation->presenters = $presenters;
                $presentation->tags = $tags;
                $presentation->courses = $courses;
                $presentation->thumb = 'image/'.$this->getDownloadedThumbfile($dirname);
                $presentation->created = strtotime($request->created);
                $presentation->duration = $durationInSeconds;
                $presentation->sources = $files; //json_decode($video->sources, true);

                $presentation->save();

            }
            //Get downloaded files names
            $data['files'] = $downloaded_files;

        }
        //New media
        elseif ($request->media == 'new_media'){
            //New upload
            if($request->isMethod('post')) {
                //First validation
                $this->validate($request, [
                    'title' => 'required',
                    'created' => 'required',
                    'filenames' => 'required',
                    'filenames.*' => 'required|mimes:mp4,mov,avi,webm,mpg,mpeg,wmv,qt,avchd',
                    'validate' => 'required'
                ]);

                //Remove old files except zip
                Storage::disk('public')->deleteDirectory($presentation->local.'/image');
                Storage::disk('public')->deleteDirectory($presentation->local.'/poster');
                Storage::disk('public')->deleteDirectory($presentation->local.'/video');

                //Store uploaded videofiles
                $files = [];
                if($request->hasfile('filenames'))
                {
                    //Dirname
                    $dirname = $presentation->local;

                    //Replace Files
                    $audio = 0;
                    foreach($request->file('filenames') as $file)
                    {
                        $name = 'media'.($audio+1).'.'.$file->extension();
                        $file->move(storage_path('/app/public/'.$dirname.'/video/'), $name);
                        $files[$audio]['video'] = 'video/'.$name;
                        $files[$audio]['poster'] = 'image/poster_'.($audio+1).'.png';
                        if($audio == 0){
                            $files[$audio]['playAudio'] = true;
                        } else {
                            $files[$audio]['playAudio'] = false;
                        }
                        $audio++;
                    }
                }

                //Presenters

                if($request->presenters){
                    foreach($request->presenters as $presenter)
                    {
                        $presenters[] = $presenter;
                    }
                } else {
                    $presenters[] = '';
                }

                //Courses
                if($request->courses) {
                    foreach ($request->courses as $course) {
                        $courses[] = $course;
                    }
                }
                else $courses[] = '';

                //Tags
                if($request->tags) {
                    foreach ($request->tags as $tag) {
                        $tags[] = $tag;
                    }
                }
                else $tags[] = '';

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

                //Generate default thumb and posters
                $thumb = $this->gen_default_thumb_posters($presentation, $durationInSeconds/3);

                //Update Presentation
                $presentation->status = 'newmedia';
                $presentation->presenters = $presenters;
                $presentation->tags = $tags;
                $presentation->courses = $courses;
                $presentation->thumb = $thumb;
                $presentation->created = strtotime($request->created);
                $presentation->duration = $durationInSeconds;
                $presentation->sources = $files;
                $presentation->save();

                $final = 1;
                return view('download.index', $presentation, compact('durationInSeconds', 'final'));
            }
        }

        $final = 1;
        return view('download.index', $presentation, compact('durationInSeconds', 'final'));
    }

    private function gen_default_thumb_posters(Presentation $presentation, $seconds)
    {
        $this->files = $this->getDownloadedVideoFiles($presentation->local);

        //Create posters
        $x = 1;
        foreach($this->files as $this->file) {
            FFMpeg::fromDisk('public')
                ->open($presentation->local.'/video/'.$this->file)
                ->getFrameFromSeconds($seconds)
                ->export()
                ->toDisk('public')
                ->save($presentation->local.'/poster/poster_'.$x.'.png');
            $x++;
        }
        //Create thumb
        // -> Note this assumes the thumb url is image/....
        FFMpeg::fromDisk('public')
            ->open($presentation->local.'/video/'.$this->files[0])
            ->getFrameFromSeconds($seconds)
            ->export()
            ->toDisk('public')
            ->save($presentation->local.'/'.$presentation->thumb);
        return $presentation->thumb;
    }

    public function gen_thumb_download($id, Request $request)
    {
        $presentation = Presentation::find($id);
        $data['files'] = $this->getDownloadedVideoFiles($presentation->local);

        //Create thumb and store in folder
        FFMpeg::fromDisk('public')
            ->open($presentation->local.'/video/'.$data['files'][0])
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save($presentation->local.'/'.$presentation->thumb);

        //Get downloaded files names
        $final = 1;

        $durationInSeconds = $presentation->duration;

        return view('download.index', $presentation, compact('durationInSeconds', 'final'));
    }

    public function gen_poster_download($id, Request $request)
    {
        $presentation = Presentation::find($id);
        $data['files'] = $this->getDownloadedVideoFiles($presentation->local);

        FFMpeg::fromDisk('public')
            ->open($presentation->local.'/video/'.$data['files'][0])
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save($presentation->local.'/poster/poster_'.$request->poster.'.png');
        $final = 1;

        $durationInSeconds = $presentation->duration;

        return view('download.index', $presentation, compact('durationInSeconds', 'final'));
    }


    private function checkDownload(Video $video)
    {
        $presentation = Presentation::find($video->id);
        foreach (Storage::disk('public')->directories() as $this->download) {
            $folder = substr($this->download, strrpos($this->download, '/'));
            if( $presentation->local == $folder) {
                return true;
            }
        }
        return false;
    }

    private function getDateAttribute($unix)
    {
        return Carbon::createFromTimestamp($unix)->format('Y-m-d');
    }

    private function getDownloadedVideoFiles($directory)
    {
        $this->directory = $directory.'/video';

        foreach(Storage::disk('public')->files($this->directory) as $this->file) {
            $this->video_name[] = substr($this->file, strrpos($this->file, '/') + 1);
        }

        return $this->video_name;
    }

    private function getDownloadedThumbfile($directory)
    {
        $this->directory = $directory.'/image';
        foreach(Storage::disk('public')->files($this->directory) as $this->file) {
            return $this->video_name[] = substr($this->file, strrpos($this->file, '/') + 1);
        }
        return 0;
    }

    private function setDownloaddir()
    {
        return Carbon::now()->toDateString('Y-m-d') . '_' . rand(1, 999);
    }
}
