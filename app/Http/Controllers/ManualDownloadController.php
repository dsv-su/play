<?php

namespace App\Http\Controllers;

use App\Presentation;
use App\Services\DownloadZip;
use App\Video;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
    protected $download_dir, $store_server;
    private $download;

    public function __construct()
    {
        $this->download_dir = 'download';
        $this->store_server = 'https://play-store.dsv.su.se/presentation/';
        //Storage::disk('public')->makeDirectory($this->download_dir);
    }

    public function step1(Video $video)
    {
        if($this->checkDownload($video)) {
            return redirect('/')->with('status', 'Presentationen har redan laddats ner och finns tillgänglig under "Hantera uppspelning"!');
        } else {
            return view('manual.download_index', $video);
        }

    }

    public function step2(Video $video)
    {
        $path = $this->download_dir.'/'.$video->presentation_id.'/';
        if (Storage::disk('public')->exists($path.$video->presentation_id.'.zip')) {
            return Storage::disk('public')->download($path.$video->presentation_id.'.zip');
        }
        else {
            return redirect('/')->with('status', 'Ett fel har inträffat. Error: File not found!');
        }
    }

    public function download(Video $video)
    {
        //Download directories to use
        $dir_thumb = $this->download_dir.'/'.$video->presentation_id.'/image/';
        $dir_video = $this->download_dir.'/'.$video->presentation_id.'/video/';
        $dir_poster = $this->download_dir.'/'.$video->presentation_id.'/poster/';

        //Download Files

        //Image
        $thumb_url = $this->store_server.$video->presentation_id.'/image/'.$video->thumb;
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
        $file = new DownloadZip($video, $this->download_dir.'/'.$video->presentation_id);
        $file->makezip();

    }

    public function step3(Video $video)
    {
        /* --> */
        // If the environment is local
        if (app()->environment('local')) {
            $data['play_user'] = 'Developer';
            $data['presenter'] = 'rydi5898';
        } else {
            $data['play_user'] = $_SERVER['displayName'];
            $data['presenter'] = $_SERVER['eppn'];
        }
        /* --> */
        //Form input
        $data['presenters'] = $video->presenters();
        $data['courses'] = $video->courses();
        $data['tags'] = $video->tags();

        //Convert unixtimestamp to date
        $data['date'] = $this->getDateAttribute($video->creation);

        //Get downloaded files names
        $data['download_files'] = $this->getDownloadedVideoFiles($video->presentation_id);

        return view('manual.download_edit', $video, $data);
    }

    public function step4(Presentation $presentation)
    {
        // Make remote folders and send all files
        //Send video files
        $directory = $this->download_dir.'/'.$presentation->presentation_id.'/video';
        $remote_dir = $presentation->presentation_id.'/video';
        $contents = Storage::disk('public')->files($directory);
        Storage::disk('sftp')->makeDirectory($remote_dir);
        try {
            foreach($contents as $sendfile) {
                $media = Storage::disk('public')->get($sendfile);
                $response = Storage::disk('sftp')->put($sendfile, $media, 'public');
            }
        } catch (\RunTimeException $e) {
            dd('Error'. $e->getMessage());
        }

        //Send image files
        $directory = $this->download_dir.'/'.$presentation->presentation_id.'/image';
        $remote_dir = $presentation->presentation_id.'/image';
        $contents = Storage::disk('public')->files($directory);
        Storage::disk('sftp')->makeDirectory($remote_dir);
        try {
            foreach($contents as $sendfile) {
                $media = Storage::disk('public')->get($sendfile);
                $response = Storage::disk('sftp')->put($sendfile, $media, 'public');
            }
        } catch (\RunTimeException $e) {
            dd('Error'. $e->getMessage());
        }

        //Send image poster files
        $directory = $this->download_dir.'/'.$presentation->presentation_id.'/poster';
        $remote_dir = $presentation->presentation_id.'/image';
        $contents = Storage::disk('public')->files($directory);
        //Storage::disk('sftp')->makeDirectory($remote_dir);
        try {
            foreach($contents as $sendfile) {
                $media = Storage::disk('public')->get($sendfile);
                $response = Storage::disk('sftp')->put($sendfile, $media, 'public');
            }
        } catch (\RunTimeException $e) {
            dd('Error'. $e->getMessage());
        }
        //Remove temp storage
        Storage::disk('public')->deleteDirectory($this->download_dir.'/'.$presentation->presentation_id);
        //Change manualupdate status
        $presentation->status = 'stored';
        $presentation->save();

        // Send notify
        return redirect()->action([ManualDownloadController::class, 'send'], ['id' => $presentation->id]);
    }


    public function store(Request $request, Video $video)
    {
        //Existing presentation files
        if($request->media == 'existing_media') {

            if($request->isMethod('post')) {
                //First validation
                $this->validate($request, [
                    'title' => 'required',
                    'created' => 'required'
                ]);

                //Get existing files
                $files = [];
                $audio = 0;
                $downloaded_files = $this->getDownloadedVideoFiles($video->presentation_id);
                foreach ($downloaded_files as $file) {
                    $files[$audio]['video'] = '/video/'.$file;
                    $files[$audio]['poster'] = '/image/poster_'.($audio+1).'.png';
                    if($audio == 0){
                        $files[$audio]['playAudio'] = true;
                    } else {
                        $files[$audio]['playAudio'] = false;
                    }
                    $audio++;
                }

                //Store metadata

                //Dirname
                $dirname = $this->download_dir.'/'.$video->presentation_id;

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

                //Determine duration of media
                $media = FFMpeg::fromDisk('public')->open('/'.$dirname.'/video/media1.mp4');
                $duration = $media->getDurationInSeconds();

                //Store in model
                $presentation = new Presentation();
                $presentation->presentation_id = $video->presentation_id;
                $presentation->status = 'update';
                $presentation->local = $dirname;
                $presentation->base = '/data0/incoming/' . $video->presentation_id;
                $presentation->title = $request->title;
                $presentation->presenters = $presenters;
                $presentation->tags = $tags;
                $presentation->courses = $courses;
                $presentation->thumb =  '/image/'.$video->thumb;
                $presentation->created = strtotime($request->created);
                $presentation->duration = $duration;
                $presentation->sources = $files; //json_decode($video->sources, true);
                $presentation->permission = $request->permission;
                $presentation->entitlement = $request->entitlement ?? $default_entitlement;
                $id = $presentation->save();
            }
            //Get downloaded files names
            $data['files'] = $this->getDownloadedVideoFiles($video->presentation_id);
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
                    'filenames.*' => 'required'
                ]);

                //Remove old files
                Storage::disk('public')->deleteDirectory($this->download_dir.'/'.$video->presentation_id);

                //Store uploaded videofiles
                $files = [];
                if($request->hasfile('filenames'))
                {
                    //Dirname
                    $dirname = $this->download_dir.'/'.$video->presentation_id;

                    //Replace Files
                    $audio = 0;
                    foreach($request->file('filenames') as $file)
                    {
                        $name = 'media'.($audio+1).'.'.$file->extension();
                        $file->move(storage_path('/app/public/'.$dirname.'/video/'), $name);
                        $files[$audio]['video'] = '/video/'.$name;
                        $files[$audio]['poster'] = '/image/poster_'.($audio+1).'.png';
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

                //Determine duration of media
                $media = FFMpeg::fromDisk('public')->open('/'.$dirname.'/video/media1.mp4');
                $duration = $media->getDurationInSeconds();

                //Default entitlement
                if($request->permission == 'false') {
                    $default_entitlement = 'urn:mace:swami.se:gmai:dsv-user:staff;urn:mace:swami.se:gmai:dsv-user:student';
                }

                //Store in model
                $presentation = new Presentation();
                $presentation->presentation_id = $video->presentation_id;
                $presentation->status = 'newmedia';
                $presentation->local = $dirname;
                $presentation->base = '/data0/incoming/'.$video->presentation_id;
                $presentation->title = $request->title;
                $presentation->presenters = $presenters;
                $presentation->tags = $tags;
                $presentation->courses = $courses;
                $presentation->thumb = '/image/'.$video->thumb;
                $presentation->created = strtotime($request->created);
                $presentation->duration = $duration;
                $presentation->sources = $files;
                $presentation->permission = $request->permission;
                $presentation->entitlement = $request->entitlement ?? $default_entitlement;
                $id = $presentation->save();
                //Variables for view
                $data['thumb'] = null;
                $data['files'] = $this->getDownloadedVideoFiles($video->presentation_id);
                $data['media'] = $request->media;
                return view('manual.edit_step2', $presentation, $data);
            }
        }

        $data['media'] = $request->media;

        return view('manual.edit_step2', $video, $data);
    }

    public function send($id)
    {
        $video = Presentation::find($id);
        $video
            ->makeHidden('id')
            ->makeHidden('status')
            ->makeHidden('local')
            ->makeHidden('created_at')
            ->makeHidden('updated_at')
            ->makeHidden('permission')
            ->makeHidden('entitlement');

        //Make json wrapper
        $json = Collection::make([
            'status' => 'success',
            'type' => 'update'
        ]);
        $json['package'] = $video;
        $json = $json->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        //Print body (for testing)
        //return $json;
        /******************************************************************************/

        $client = new Client(['base_uri' => $this->uri()]);
        $headers = [
            //'Authorization' => 'Bearer ' . $this->token(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        try {
            $response = $client->request('POST', $this->uri(), [
                'headers' => $headers,
                'body' => $json
            ]);
        } catch (\Exception $e) {
            /**
             * If there is an exception; Client error;
             */
            if ($e->hasResponse()) {
                //return $response = $e->getResponse()->getStatusCode();
                //Change manualupdate status
                $video->status = 'failed';
                $video->save();
                return $response = $e->getResponse()->getBody();
            }
        }

        if($response->getBody() == 'OK') {
            //Change manualupdate status
            $video->status = 'sent';
            $video->save();
            return redirect('/')->with('status', 'Presentationen har redigerats och laddats upp!');
        }
        else {
            //Change manualupdate status
            $video->status = 'failed';
            $video->save();
            return $response->getBody();
        }


    }

    public function gen_thumb_download($id, Request $request)
    {
        if($request->media == 'new_media') {
            $video = Presentation::find($id);
            $data['media'] = 'new_media';
        }
        else {
            $video = Video::find($id);
            $data['media'] = 'existing_media';
        }

        $data['files'] = $this->getDownloadedVideoFiles($video->presentation_id);

        //Create thumb and store in folder
        FFMpeg::fromDisk('public')
            ->open($this->download_dir.'/'.$video->presentation_id.'/video/'.$data['files'][0])
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save($this->download_dir.'/'.$video->presentation_id.'/image/'.$video->thumb);

        //Get downloaded files names

        return view('manual.edit_step2', $video, $data);
    }

    public function gen_poster_download($id, Request $request)
    {
        if($request->media == 'new_media') {
            $video = Presentation::find($id);
            $data['media'] = 'new_media';
        }
        else {
            $video = Video::find($id);
            $data['media'] = 'existing_media';
        }

        $data['files'] = $this->getDownloadedVideoFiles($video->presentation_id);

        FFMpeg::fromDisk('public')
            ->open($this->download_dir.'/'.$video->presentation_id.'/video/'.$data['files'][0])
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save($this->download_dir.'/'.$video->presentation_id.'/poster/poster_'.$request->poster.'.png');

        return view('manual.edit_step2', $video, $data);
    }


    private function checkDownload(Video $video)
    {
        foreach (Storage::disk('public')->directories($this->download_dir) as $this->download) {
            if(substr($this->download, strrpos($this->download, '/') + 1) == $video->presentation_id) {
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
        $this->directory = $this->download_dir.'/'.$directory.'/video';

        foreach(Storage::disk('public')->files($this->directory) as $this->file) {
            $this->video_name[] = substr($this->file, strrpos($this->file, '/') + 1);
        }
        return $this->video_name;
    }

    private function uri()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path().'/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['sftp']['uri'];
    }
}
