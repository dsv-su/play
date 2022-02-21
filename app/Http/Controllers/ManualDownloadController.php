<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Presentation;
use App\Services\DownloadZip;
use App\Services\Ffmpeg\DetermineDurationVideo;
use App\Services\Notify\PlayStoreNotify;
use App\Services\Store\DownloadResource;
use App\Services\Store\DownloadStreamResolution;
use App\Services\Store\SftpPlayStore;
use App\Services\TicketHandler\TicketPermissionHandler;
use App\Stream;
use App\StreamResolution;
use App\Video;
use App\VideoStat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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
    protected $download_dir;
    protected $store_server;
    private $download;

    public function __construct()
    {
        $this->store_server = 'https://play-store.dsv.su.se/presentation/';
    }

    public function initDownload(Video $video, $resolution)
    {
        //Check and set download status in coursesetting
        $video = $this->check_download_status($video);

        //Initiates and starts the download/edit process
        //if(!$presentation = Presentation::find($video->id)) {
        if (!Presentation::where('id', $video->id)->where('resolution', $resolution)->first() && ($video->download or $video->download_setting)) {
            if (!$presentation = Presentation::find($video->id)) {
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
            $presentation->thumb = 'image/thumb.jpg';//$video->thumb;
            $presentation->created = $video->creation;
            $presentation->duration = $video->duration;
            $presentation->sources = json_decode($video->sources, true);
            $presentation->save();

            return true;
        } else {
            //Returns false if there already exist a download/edit
            return false;
        }
    }

    public function step1(Video $video, Request $request)
    {
        //dd($video, $request->res);
        //Check if request has been initiated
        if ($this->initDownload($video, $request->res)) {
            if ($this->checkDownload($video)) {
                return redirect()->action([ManualDownloadController::class, 'step2'], ['video' => $video]);
            } else {
                return view('download.download_index', compact('video'));
            }
        } else {
            if ($this->checkDownload($video)) {
                return redirect()->action([ManualDownloadController::class, 'step2'], ['video' => $video]);
            }
            return view('download.download_index', compact('video'));
        }

    }

    public function step2(Video $video)
    {
        $presentation = Presentation::find($video->id);
        $path = $presentation->local . '/';

        if (Storage::disk('public')->exists($path . $video->title . '.zip')) {
            //Register stats
            $stats = VideoStat::firstOrNew(['video_id' => $video->id]);
            $stats->download = $stats->download + 1;
            $stats->save();

            return Storage::disk('public')->download($path . $video->title . '.zip');
        } else {
            return redirect('/')->with(['message' => 'Ett fel har inträffat. Error: File not found!', 'alert' => 'alert-danger']);
        }
    }

    public function download(Video $video)
    {
        $presentation = Presentation::find($video->id);
        //Download directories to use
        //$dir_thumb = $presentation->local . '/image/';
        $dir_video = $presentation->local . '/videos/';
        $dir_poster = $presentation->local . '/posters/';

        //Download Files
        $file = new DownloadResource($video, new TicketPermissionHandler($video));

        //Image is not needed for this download
        /*$thumb_url = $video->thumb;
        $thumb_name = substr($video->thumb, strrpos($video->thumb, '/') + 1);
        // Download thumb
        \Storage::disk('public')->makeDirectory($dir_thumb);
        $file = new DownloadResource($video, new TicketHandler($video));
        $file->getFile($dir_thumb . $thumb_name, $thumb_url);
        */

        //Get video and poster names
        $download = new DownloadStreamResolution($video);
        $video_names = $download->videonames($presentation->resolution);
        $poster_names = $download->posternames();

        //Create local storage directories
        \Storage::disk('public')->makeDirectory($dir_video);
        \Storage::disk('public')->makeDirectory($dir_poster);

        //Download video file
        foreach ($video_names as $video_name) {
            $file->getFile($dir_video . $video_name, $this->base_uri() . '/' . $video->id . '/' . $video_name);
        }

        //Download posters
        foreach ($poster_names as $poster_name) {
            $file->getFile($dir_poster . $poster_name, $this->base_uri() . '/' . $video->id . '/' . $poster_name);
        }

        //Create json package and multiplayer
        $this->package($presentation);

        //Change status
        $presentation->status = 'stored';
        $presentation->save();

        //Make zipfolder of presentation
        $file = new DownloadZip($video, $presentation->local);
        $file->makezip();

        return true;
    }

    public function step3(Video $video)
    {
        /* This method should be refactored or removed */

        dd($video);

        if ($presentation = Presentation::find($video->id)) {

            $final = 0;
            //Form input
            if (count($owners = $video->presenters()) > 0) {

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

            return view('download.index', $presentation, compact('final', 'owners', 'creationdate', 'coursebindings', 'tags', 'permissions', 'durationInSeconds', 'download_files', 'video'));

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
        if ($request->media == 'existing_media') {

            if ($request->isMethod('post')) {
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
                    $files[$audio]['video'] = 'video/' . $file;
                    $files[$audio]['poster'] = 'poster/poster_' . ($audio + 1) . '.png';
                    if ($audio == 0) {
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
                $presentation->thumb = 'image/' . $this->getDownloadedThumbfile($dirname);
                $presentation->created = strtotime($request->created);
                $presentation->duration = $durationInSeconds;
                $presentation->sources = $files; //json_decode($video->sources, true);

                $presentation->save();

            }
            //Get downloaded files names
            $data['files'] = $downloaded_files;

        } //New media
        elseif ($request->media == 'new_media') {
            //New upload
            if ($request->isMethod('post')) {
                //First validation
                $this->validate($request, [
                    'title' => 'required',
                    'created' => 'required',
                    'filenames' => 'required',
                    'filenames.*' => 'required|mimes:mp4,mov,avi,webm,mpg,mpeg,wmv,qt,avchd',
                    'validate' => 'required'
                ]);

                //Remove old files except zip
                Storage::disk('public')->deleteDirectory($presentation->local . '/image');
                Storage::disk('public')->deleteDirectory($presentation->local . '/poster');
                Storage::disk('public')->deleteDirectory($presentation->local . '/video');

                //Store uploaded videofiles
                $files = [];
                if ($request->hasfile('filenames')) {
                    //Dirname
                    $dirname = $presentation->local;

                    //Replace Files
                    $audio = 0;
                    foreach ($request->file('filenames') as $file) {
                        $name = 'media' . ($audio + 1) . '.' . $file->extension();
                        $file->move(storage_path('/app/public/' . $dirname . '/video/'), $name);
                        $files[$audio]['video'] = 'video/' . $name;
                        $files[$audio]['poster'] = 'image/poster_' . ($audio + 1) . '.png';
                        if ($audio == 0) {
                            $files[$audio]['playAudio'] = true;
                        } else {
                            $files[$audio]['playAudio'] = false;
                        }
                        $audio++;
                    }
                }

                //Presenters

                if ($request->presenters) {
                    foreach ($request->presenters as $presenter) {
                        $presenters[] = $presenter;
                    }
                } else {
                    $presenters[] = '';
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
                if (!$media->check()) {
                    return back()->withInput()->with(['error' => 'Mediafilerna har olika längd och skiljer åt mer än +/- 3 sek. Kontrollera och ladda upp på nytt!']);
                }

                //Default entitlement
                if ($request->permission == 'false') {
                    $default_entitlement = 'urn:mace:swami.se:gmai:dsv-user:staff;urn:mace:swami.se:gmai:dsv-user:student';
                }

                //Generate default thumb and posters
                $thumb = $this->gen_default_thumb_posters($presentation, $durationInSeconds / 3);

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

    private function package($presentation)
    {
        $video = Video::find($presentation->id);
        // Construct Presentation json from DB
        $package = array();
        $package['id'] = $video->id;
        $package['title'] = $video->title;
        $package['thumb'] = $presentation->thumb;
        $package['duration'] = $video->duration;

        $streams = Stream::where('video_id', $video->id)->where('hidden', 0)->get();
        foreach ($streams as $key => $stream) {
            $package['sources'][] = [
                'poster' => 'posters/' .$stream->poster,
                'playAudio' => (bool) $stream->audio,
                'name' => $stream->name
            ];
            $resolutions = StreamResolution::where('stream_id', $stream->id)->where('resolution', $presentation->resolution)->get();
            foreach ($resolutions as $resolution) {
                $package['sources'][$key]['video'][$resolution->resolution] = 'videos/'. $resolution->filename;
            }
        }

        //Prepare multiplayer
        $this->prepare_multiplayer($presentation);

        //Make package
        $package = collect($package)->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        Storage::disk('public')->put($presentation->local .'/package.json', $package);

        //Add package
        $this->add_package($presentation);

        //Cleanup folder
        Storage::disk('public')->delete($presentation->local. '/dlplayer.html');
        Storage::disk('public')->delete($presentation->local. '/package.json');

        return true;
    }

    private function add_package($presentation)
    {
        //Read multiplayer DOM
        $multiplayer = \Illuminate\Support\Facades\Storage::disk('public')->get($presentation->local.'/dlplayer.html');
        //Read package json
        $package = Storage::disk('public')->get($presentation->local.'/package.json');

        //Finds %PACKAGE%
        $regex = '/(%)([A-Z]*)([0-9]*)(%)/m';

        preg_match_all($regex, $multiplayer, $matches, PREG_SET_ORDER, 0);

        //Integrate
        $replaced = Str::replace($matches[0][0], $package, $multiplayer);
        //Store
        Storage::disk('public')->put($presentation->local.'/play.html', $replaced);
    }

    private function prepare_multiplayer($presentation)
    {
        Storage::copy('multiplayer/dlplayer.html', 'public/'.$presentation->local.'/dlplayer.html');
    }

    private function gen_default_thumb_posters(Presentation $presentation, $seconds)
    {
        $this->files = $this->getDownloadedVideoFiles($presentation->local);

        //Create posters
        $x = 1;
        foreach ($this->files as $this->file) {
            FFMpeg::fromDisk('public')
                ->open($presentation->local . '/video/' . $this->file)
                ->getFrameFromSeconds($seconds)
                ->export()
                ->toDisk('public')
                ->save($presentation->local . '/poster/poster_' . $x . '.png');
            $x++;
        }
        //Create thumb
        // -> Note this assumes the thumb url is image/....
        FFMpeg::fromDisk('public')
            ->open($presentation->local . '/video/' . $this->files[0])
            ->getFrameFromSeconds($seconds)
            ->export()
            ->toDisk('public')
            ->save($presentation->local . '/' . $presentation->thumb);
        return $presentation->thumb;
    }

    public function gen_thumb_download($id, Request $request)
    {
        $presentation = Presentation::find($id);
        $data['files'] = $this->getDownloadedVideoFiles($presentation->local);

        //Create thumb and store in folder
        FFMpeg::fromDisk('public')
            ->open($presentation->local . '/video/' . $data['files'][0])
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save($presentation->local . '/' . $presentation->thumb);

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
            ->open($presentation->local . '/video/' . $data['files'][0])
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save($presentation->local . '/poster/poster_' . $request->poster . '.png');
        $final = 1;

        $durationInSeconds = $presentation->duration;

        return view('download.index', $presentation, compact('durationInSeconds', 'final'));
    }


    private function checkDownload(Video $video)
    {
        $presentation = Presentation::find($video->id);
        foreach (Storage::disk('public')->directories() as $this->download) {
            $folder = substr($this->download, strrpos($this->download, '/'));
            if ($presentation->local == $folder) {
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
        $this->directory = $directory . '/video';

        foreach (Storage::disk('public')->files($this->directory) as $this->file) {
            $this->video_name[] = substr($this->file, strrpos($this->file, '/') + 1);
        }

        return $this->video_name;
    }

    private function getDownloadedThumbfile($directory)
    {
        $this->directory = $directory . '/image';
        foreach (Storage::disk('public')->files($this->directory) as $this->file) {
            return $this->video_name[] = substr($this->file, strrpos($this->file, '/') + 1);
        }
        return 0;
    }

    private function getMultiPlayerFiles()
    {
        foreach (Storage::disk('local')->files('multiplayer') as $this->file) {
            $this->file_name[] = substr($this->file, strrpos($this->file, '/') + 1);
        }

        return $this->file_name;
    }

    private function setDownloaddir()
    {
        return Carbon::now()->toDateString('Y-m-d') . '_' . rand(1, 999);
    }

    private function check_download_status($video)
    {
        //Checks download flags status for a given object
        if(count($video->courses())>=1) {
            foreach($video->courses() as $course) {
                if($setting = $course->coursesettings->toArray()) {
                    if($setting[0]['downloadable'] == true) {
                        return $video->setAttribute('download_setting', true);
                    }
                }
            }
        }
        return $video;
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
}
