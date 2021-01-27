<?php

namespace App\Http\Controllers;

use App\ManualPresentation;
use App\Video;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use RunTimeException;
use Storage;

class ManualUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('manual.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     */
    public function step1(Request $request)
    {
        if ($request->isMethod('post')) {
            //First validation
            $this->validate($request, [
                'title' => 'required',
                'created' => 'required',
                'filenames' => 'required',
                'filenames.*' => 'required'
            ]);

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
                    $files[$audio]['video'] = '/video/' . $name;
                    $files[$audio]['poster'] = '/image/poster_' . ($audio + 1) . '.png';
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

            //Determine duration of media
            $media = FFMpeg::fromDisk('public')->open('/' . $dirname . '/video/media1.mp4');
            $durationInSeconds = $media->getDurationInSeconds();

            //Default entitlement
            if($request->permission == 'false') {
                $default_entitlement = 'urn:mace:swami.se:gmai:dsv-user:staff;urn:mace:swami.se:gmai:dsv-user:student';
            }

            //Store in model
            $file = new ManualPresentation();
            $file->status = 'pending';
            $file->local = $dirname;
            $file->base = '/data0/incoming/' . $dirname;
            $file->title = $request->title;
            $file->presenters = $presenters;
            $file->tags = $tags;
            $file->courses = $courses;
            $file->thumb = '/image/'.$request->thumb; //TODO
            $file->created = strtotime($request->created);
            $file->duration = $durationInSeconds;
            $file->sources = $files;
            $file->permission = $request->permission;
            $file->entitlement = $request->entitlement ?? $default_entitlement;
            $id = $file->save();
            $file->thumb = $this->gen_thumb_poster($file, $durationInSeconds/3);
            $file->save();

            return view('manual.step1', $file, compact('durationInSeconds'));
        }

        return redirect()->route('manual_upload');
    }

    public function gen_thumb($id, Request $request)
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
        $presentation->thumb = '/image/primary_thumb' . $id . '.png';
        $presentation->save();
        $durationInSeconds = $presentation->duration;
    /*
        //Create posters
        $poster = 1;
        foreach ($presentation->sources as $source) {
            FFMpeg::fromDisk('public')
                ->open('/' . $presentation->local . '/video/media' . $poster . '.mp4')
                ->getFrameFromSeconds($request->seconds)
                ->export()
                ->toDisk('public')
                ->save('/' . $presentation->local . '/image/poster_' . $poster . '.png');
            $poster++;
        }
    */

        return view('manual.step1', $presentation, compact('durationInSeconds'));
    }

    public function gen_poster($id, Request $request)
    {
        $presentation = ManualPresentation::find($id);
        $durationInSeconds = $presentation->duration;

        FFMpeg::fromDisk('public')
            ->open('/' . $presentation->local . '/video/media' . $request->poster . '.mp4')
            ->getFrameFromSeconds($request->seconds)
            ->export()
            ->toDisk('public')
            ->save('/' . $presentation->local . '/image/poster_' . $request->poster . '.png');

        return view('manual.step1', $presentation, compact('durationInSeconds'));
    }

    public function step3($id)
    {
        $presentation = ManualPresentation::find($id);

        // Make remote folders and send all files
        //Send video files
        $directory = '/' . $presentation->local . '/video';
        $remote_dir = $presentation->local . '/video';
        $contents = Storage::disk('public')->files($directory);
        Storage::disk('sftp')->makeDirectory($remote_dir);
        try {
            foreach ($contents as $sendfile) {
                $media = Storage::disk('public')->get($sendfile);
                $response = Storage::disk('sftp')->put($sendfile, $media, 'public');
            }
        } catch (RunTimeException $e) {
            dd('Error' . $e->getMessage());
        }

        //Send image files
        $directory = '/' . $presentation->local . '/image';
        $remote_dir = $presentation->local . '/image';
        $contents = Storage::disk('public')->files($directory);
        Storage::disk('sftp')->makeDirectory($remote_dir);
        try {
            foreach ($contents as $sendfile) {
                $media = Storage::disk('public')->get($sendfile);
                $response = Storage::disk('sftp')->put($sendfile, $media, 'public');
            }
        } catch (RunTimeException $e) {
            dd('Error' . $e->getMessage());
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
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */


    private function uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['sftp']['uri'];
    }

    private function token()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
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
        return $json;
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
        } catch (Exception $e) {
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

        if ($response->getBody() == 'OK') {
            //Change manualupdate status
            $video->status = 'sent';
            $video->save();
            return redirect('/')->with('status', 'Presentationen har laddats upp!');
        } else {
            //Change manualupdate status
            $video->status = 'failed';
            $video->save();
            return $response->getBody();
        }
    }

    private function gen_thumb_poster(ManualPresentation $manualPresentation, $seconds)
    {
        //Create thumb and store in folder
        FFMpeg::fromDisk('public')
            ->open('/' . $manualPresentation->local . '/video/media1.mp4')
            ->getFrameFromSeconds($seconds)
            ->export()
            ->toDisk('public')
            ->save('/' . $manualPresentation->local . '/image/primary_thumb' . $manualPresentation->id . '.png');

        //Create posters
        $poster = 1;
        foreach ($manualPresentation->sources as $source) {
            FFMpeg::fromDisk('public')
                ->open('/' . $manualPresentation->local . '/video/media' . $poster . '.mp4')
                ->getFrameFromSeconds($seconds)
                ->export()
                ->toDisk('public')
                ->save('/' . $manualPresentation->local . '/image/poster_' . $poster . '.png');
            $poster++;
        }

        return '/image/primary_thumb' . $manualPresentation->id . '.png';
    }
}
