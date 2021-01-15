<?php

namespace App\Http\Controllers;

use App\ManualPresentation;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Storage;
use GuzzleHttp\Client;

class ManualUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // If the environment is local
        if (app()->environment('local')) {
            $data['play_user'] = 'Developer';
            $data['presenter'] = 'rydi5898';
        } else {
            $data['play_user'] = $_SERVER['displayName'];
            $data['presenter'] = $_SERVER['eppn'];
        }

        return view('manual.index', $data);
    }

    public function admin()
    {
        $data['presentations'] = ManualPresentation::all();
        $data['videos'] = Video::all();
        return view('manual.admin', $data);
    }

    public function admin_erase($id)
    {
        $manual = ManualPresentation::find($id);
        Storage::disk('public')->deleteDirectory($manual->local);
        ManualPresentation::destroy($id);
        return back()->withInput();
    }

    public function admin_notify($id)
    {
        $video = ManualPresentation::find($id);
        $video->makeHidden('status')
                ->makeHidden('local')
                ->makeHidden('base')
                ->makeHidden('title')
                ->makeHidden('presenters')
                ->makeHidden('created')
                ->makeHidden('duration')
                ->makeHidden('courses')
                ->makeHidden('tags')
                ->makeHidden('thumbs')
                ->makeHidden('sources')
                ->makeHidden('created_at')->makeHidden('updated_at');
        //Make json wrapper
        $json = Collection::make([
            'status' => 'failure',
            'type' => 'manual'
        ]);
        $json['package'] = Collection::make([
            'message' => $video->status,
            'base' => $video->base
            ]);

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
            $video->status = 'notified';
            $video->save();
            return back()->withInput();
        }
        else {
            //Change manualupdate status
            $video->status = 'failed';
            $video->save();
            return $response->getBody();
        }

        return back()->withInput();
    }

    public function admin_unregister($id)
    {
        ManualPresentation::destroy($id);
        return back()->withInput();
    }

    public function admin_permission($id)
    {
        $video = Video::find($id);
        return view('manual.permission', $video);
    }
    public function admin_permission_store($id, Request $request)
    {
        $video = Video::find($id);
        $video->permission = $request->permission;
        $video->entitlement = $request->entitlement;
        $video->save();
        return redirect()->route('manual_admin');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function step1(Request $request)
    {
        if($request->isMethod('post')) {
            //First validation
            $this->validate($request, [
                'title' => 'required',
                'created' => 'required',
                'filenames' => 'required',
                'filenames.*' => 'required'
            ]);

            //Store uploaded videofiles
            $files = [];
            if($request->hasfile('filenames'))
            {
                //Make unique directory
                $dirname = Carbon::now()->toDateString('Y-m-d').'_'.rand(1,999);
                Storage::disk('public')->makeDirectory( $dirname.'/video');
                //Files
                $audio = 0;
                foreach($request->file('filenames') as $file)
                {
                    $name = 'media'.($audio+1).'.'.$file->extension();
                    $file->move(storage_path('/app/public/'.$dirname.'/video'), $name);
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
            $durationInSeconds = $media->getDurationInSeconds();

            //Store in model
            $file = new ManualPresentation();
            $file->status = 'pending';
            $file->local = $dirname;
            $file->base = '/data0/incoming/'.$dirname;
            $file->title = $request->title;
            $file->presenters = $presenters;
            $file->tags = $tags;
            $file->courses = $courses;
            $file->thumb = $request->thumb; //TODO
            $file->created = strtotime($request->created);
            $file->duration = $durationInSeconds;
            $file->sources = $files;
            $file->permission = $request->permission;
            $file->entitlement = $request->entitlement;
            $id = $file->save();



            return view('manual.step1', $file, compact('durationInSeconds'));
        }

        return redirect()->route('manual_upload');
    }

    public function gen_thumb($id, Request $request)
    {
        $presentation = ManualPresentation::find($id);

        //Create thumb and store in folder
        FFMpeg::fromDisk('public')
            ->open('/'.$presentation->local.'/video/media1.mp4')
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save('/'.$presentation->local.'/image/primary_thumb'.$id.'.png');
        //Store thumb in model
        $presentation->thumb = 'primary_thumb'.$id.'.png';
        $presentation->save();
        $durationInSeconds = $presentation->duration;

        //Create posters
        $poster = 1;
        foreach ($presentation->sources as $source)
        {
            FFMpeg::fromDisk('public')
                ->open('/'.$presentation->local.'/video/media'.$poster.'.mp4')
                ->getFrameFromSeconds($request->seconds)
                ->export()
                ->toDisk('public')
                ->save('/'.$presentation->local.'/image/poster_'.$poster.'.png');
            $poster++;
        }


        return view('manual.step1', $presentation, compact('durationInSeconds'));
    }

    public function gen_poster($id, Request $request)
    {
        $presentation = ManualPresentation::find($id);
        $durationInSeconds = $presentation->duration;

        FFMpeg::fromDisk('public')
            ->open('/'.$presentation->local.'/video/media'.$request->poster.'.mp4')
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save('/'.$presentation->local.'/image/poster_'.$request->poster.'.png');

        return view('manual.step1', $presentation, compact('durationInSeconds'));
    }

    public function step3($id)
    {
        $presentation = ManualPresentation::find($id);

        // Make remote folders and send all files
        //Send video files
        $directory = '/'.$presentation->local.'/video';
        $remote_dir = $presentation->local.'/video';
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
        $directory = '/'.$presentation->local.'/image';
        $remote_dir = $presentation->local.'/image';
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

        //Remove temp storage
        Storage::disk('public')->deleteDirectory($presentation->local);
        //Change manualupdate status
        $presentation->status = 'stored';
        $presentation->save();

        // Send notify
        return redirect()->action([ManualUploadController::class, 'send'], ['id' => $presentation->id]);
    }

    public function store(Request $request)
    {
        //
    }

            /**
             * Display the specified resource.
             *
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /************************
         * Dev testing
         * ->to be removed
         */
        //Remove temp storage in dev
        Storage::disk('public')->deleteDirectory($id);
        $data['presentations'] = ManualPresentation::all();
        return view('manual.admin', $data);
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

    private function token()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path().'/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['test']['token'];
    }

    public function send($id)
    {
        $video = ManualPresentation::find($id);
        $video
            ->makeHidden('status')
            ->makeHidden('local')
            ->makeHidden('created_at')
            ->makeHidden('updated_at')
            ->makeHidden('permission')
            ->makeHidden('entitlement');
        //Make json wrapper
        $json = Collection::make([
            'status' => 'success',
            'type' => 'manual'
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
            return redirect('/')->with('status', 'Presentationen har laddats upp!');
        }
        else {
            //Change manualupdate status
            $video->status = 'failed';
            $video->save();
            return $response->getBody();
        }


    }
}
