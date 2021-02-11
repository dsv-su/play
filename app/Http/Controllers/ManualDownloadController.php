<?php

namespace App\Http\Controllers;

use App\Presentation;
use App\Services\DownloadZip;
use App\Services\Ffmpeg\DetermineDurationVideo;
use App\Services\Notify\PlayStoreNotify;
use App\Services\Store\SftpPlayStore;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Storage;


class ManualDownloadController extends Controller
{
    /**
     * Downloads media from storage server.
     *
     * Step1: Check if the video already has been downloaded
     * Step2: Download the video and all files to staging area
     * Step3: Edit video metadata possibility to upload new files, generate new thumb and posters to staging area
     * Step4: Upload modified video to play-store server from staging area
     * Step5: Send notification to play-store
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
    public function initDownload(Video $video)
    {
        if(!$presentation = Presentation::find($video->id)) {
                $download_dir = $this->setDownloaddir();
                $presentation = new Presentation();
                $presentation->id = $video->id;
                $presentation->status = 'request download';
                $presentation->local = $download_dir;
                $presentation->base = '/data0/incoming/' . $download_dir;
                $presentation->title = $video->title;
                $presentation->presenters = '[]';
                $presentation->tags = '[]';
                $presentation->courses = '[]';
                $presentation->thumb = $video->thumb;
                $presentation->created = $video->creation;
                $presentation->duration = $video->duration;
                $presentation->sources = json_decode($video->sources, true);;
                $presentation->permission = $video->permission;
                $presentation->entitlement = $video->entitlement;
                $presentation->save();

                return true;
            }
        else {
                return false;
            }
    }

    public function step1(Video $video)
    {
        if($this->initDownload($video)) {
            if ($this->checkDownload()) {
                return redirect('/')->with(['message' => 'Presentationen har redan laddats ner och finns tillgänglig under "Hantera uppspelning"!', 'alert' => 'alert-success']);
            } else {
                return view('manual.download_index', $video);
            }
        }
        else {
            return redirect('/')->with(['message' => 'Det existerar en reviderad Presentation i Administratorgränssnittet - under utveckling!']);
        }

    }

    public function step2(Video $video)
    {
        $presentation = Presentation::latest()->first();
        $path = $presentation->local.'/';

        if (Storage::disk('public')->exists($path.$video->id.'.zip')) {
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
        $dir_thumb = $presentation->local.'/';
        $dir_video = $presentation->local.'/video/';
        $dir_poster = $presentation->local.'/poster/';

        //Download Files

        //Image
        $thumb_url = $this->store_server.$video->id.'/'.$video->thumb;
        $download_thumb = file_get_contents($thumb_url);
        Storage::disk('public')->put($dir_thumb.$video->thumb, $download_thumb);

        //Video and poster files
        foreach (json_decode($video->sources, true) as $source) {
            $video_name = substr($source['video'], strrpos($source['video'], '/') + 1);
            $poster_name = substr($source['poster'], strrpos($source['poster'], '/') + 1);
            $download_video = file_get_contents($source['video']);
            $download_poster = file_get_contents($source['poster']);
            Storage::disk('public')->put($dir_video.$video_name, $download_video);
            Storage::disk('public')->put($dir_poster.$poster_name, $download_poster);

        }

        //Make zipfolder of presentation
        $file = new DownloadZip($video, $presentation->local);
        $file->makezip();

    }

    public function step3(Video $video)
    {
        $presentation = Presentation::find($video->id);

        //Form input
        $data['presenters'] = $video->presenters();
        $data['courses'] = $video->courses();
        $data['tags'] = $video->tags();

        //Convert unixtimestamp to date
        $data['date'] = $this->getDateAttribute($video->creation);

        //Get downloaded files names
        $data['download_files'] = $this->getDownloadedVideoFiles($presentation->local);

        return view('manual.download_edit', $video, $data);
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

                //Default entitlement
                if ($request->permission == 'false') {
                    $default_entitlement = 'urn:mace:swami.se:gmai:dsv-user:staff;urn:mace:swami.se:gmai:dsv-user:student';
                }

                //Determine duration of primary media
                $primary_video_name = substr($files[0]['video'], strrpos($files[0]['video'], '/') + 1);
                $media = new DetermineDurationVideo($dirname);
                $duration = $media->duration($primary_video_name);

                //Update Presentation
                $presentation->status = 'update';
                $presentation->title = $request->title;
                $presentation->presenters = $presenters;
                $presentation->tags = $tags;
                $presentation->courses = $courses;
                $presentation->created = strtotime($request->created);
                $presentation->duration = $duration;
                $presentation->sources = $files; //json_decode($video->sources, true);
                $presentation->permission = $request->permission;
                $presentation->entitlement = $request->entitlement ?? $default_entitlement;
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
                $duration = $media->duration($primary_video_name);

                //Check media diffs (+- 3 sec)
                if(!$media->check()) {
                    return back()->withInput()->with(['error' => 'Mediafilerna har olika längd och skiljer åt mer än +/- 3 sek. Kontrollera och ladda upp på nytt!']);
                }

                //Default entitlement
                if($request->permission == 'false') {
                    $default_entitlement = 'urn:mace:swami.se:gmai:dsv-user:staff;urn:mace:swami.se:gmai:dsv-user:student';
                }

                //Generate default thumb and posters
                $thumb = $this->gen_default_thumb_posters($presentation, $duration/3);

                //Update Presentation
                $presentation->status = 'newmedia';
                $presentation->presenters = $presenters;
                $presentation->tags = $tags;
                $presentation->courses = $courses;
                $presentation->thumb = $thumb;
                $presentation->created = strtotime($request->created);
                $presentation->duration = $duration;
                $presentation->sources = $files;
                $presentation->permission = $request->permission;
                $presentation->entitlement = $request->entitlement ?? $default_entitlement;
                $presentation->save();

                //New media
                //Variables for view
                $data['files'] = $files;
                $data['media'] = $request->media;

                return view('manual.edit_step2', $presentation, $data);
            }
        }
        //Existing media
        $data['media'] = $request->media;

        return view('manual.edit_step2', $presentation, $data);
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

        $data['media'] = $request->media;
        $data['pid'] = $presentation->id;
        $data['files'] = $this->getDownloadedVideoFiles($presentation->local);

        //Create thumb and store in folder
        FFMpeg::fromDisk('public')
            ->open($presentation->local.'/video/'.$data['files'][0])
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save($presentation->local.'/'.$presentation->thumb);

        //Get downloaded files names

        return view('manual.edit_step2', $presentation, $data);
    }

    public function gen_poster_download($id, Request $request)
    {
        $presentation = Presentation::find($id);

        $data['media'] = $request->media;
        $data['pid'] = $presentation->id;
        $data['files'] = $this->getDownloadedVideoFiles($presentation->local);

        FFMpeg::fromDisk('public')
            ->open($presentation->local.'/video/'.$data['files'][0])
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save($presentation->local.'/poster/poster_'.$request->poster.'.png');

        return view('manual.edit_step2', $presentation, $data);
    }


    private function checkDownload()
    {
        foreach (Storage::disk('public')->directories() as $this->download) {
            $folder = substr($this->download, strrpos($this->download, '/'));
            if( Presentation::where('local', $folder)->first()) {
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

    private function setDownloaddir()
    {
        return Carbon::now()->toDateString('Y-m-d') . '_' . rand(1, 999);
    }
}
