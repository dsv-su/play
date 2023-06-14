<?php

namespace App\Http\Controllers;

use App\Presentation;
use App\Services\DownloadZip;
use App\Services\Store\DownloadResource;
use App\Services\Store\DownloadStreamResolution;
use App\Services\TicketHandler\TicketPermissionHandler;
use App\Stream;
use App\StreamResolution;
use App\Video;
use App\VideoStat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
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


    public function initDownload(Video $video, $resolution)
    {
        //Check and set download status in coursesetting
        $video = $this->check_download_status($video);

        //Initiates and starts the download/edit process
        if (!Presentation::where('id', $video->id)->where('resolution', $resolution)->first() && ($video->download or $video->download_setting)) {
            if (!$presentation = Presentation::find($video->id)) {
                $presentation = new Presentation();
            }
            $download_dir = $this->setDownloaddir($presentation->id);
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

    public function start(Video $video, Request $request)
    {
        if ($this->initDownload($video, $request->res)) {
            if ($this->checkDownload($video)) {
                return true;
            } else {
                $this->download($video);
                return true;
            }
        } else {
            if ($this->checkDownload($video)) {
                return true;
            }
            //Failed
            return false;
        }
    }

    public function browserDownloadZip(Video $video)
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
            if (App::isLocale('swe')) {
                $message = 'Ett fel har inträffat.';
            } else {
                $message = 'Error: File not found!';
            }
            return redirect('/')->with(['message' => $message, 'alert' => 'alert-danger']);
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

    public function subtitle(Video $video, Request $request)
    {
        //Create local storage directory
        \Storage::disk('public')->makeDirectory('subtitles/'.$video->id);
        //Create token
        $file = new DownloadResource($video, new TicketPermissionHandler($video));

        foreach(json_decode($video->subtitles, true) as $lang => $sub) {
            if($lang == $request['lang']) {
                $path = 'subtitles/'.$video->id.'/'. $sub;
                $file->getFile($path, $this->base_uri() . '/' . $video->id . '/' . $sub);
            }

        }
        return \Illuminate\Support\Facades\Storage::disk('public')->download($path);
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

    private function getMultiPlayerFiles()
    {
        foreach (Storage::disk('local')->files('multiplayer') as $this->file) {
            $this->file_name[] = substr($this->file, strrpos($this->file, '/') + 1);
        }

        return $this->file_name;
    }

    private function setDownloaddir($id)
    {
        return Carbon::now()->toDateString('Y-m-d') . '_' . rand(1, 999). $id;
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
