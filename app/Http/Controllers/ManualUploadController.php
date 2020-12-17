<?php

namespace App\Http\Controllers;

use App\ManualPresentation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
        return view('manual.index');
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'filenames' => 'required',
            'filenames.*' => 'required'
        ]);

        $files = [];

        if($request->hasfile('filenames'))
        {
            //Make unique directory
            $dirname = Carbon::now()->toDateString('Y-m-d').'_'.rand(1,999);
            Storage::disk('public')->makeDirectory('upload/'. $dirname);
            //Presentators
            foreach($request->presenter as $presenter)
            {
                $presenters[] = $presenter;
            }
            //Courses
            foreach($request->course as $course)
            {
                $courses[] = $course;
            }
            //Tags
            foreach($request->tag as $tag)
            {
                $tags[] = $tag;
            }
            //Files
            $audio = 0;
            foreach($request->file('filenames') as $file)
            {
                $name = 'media'.($audio+1).'.'.$file->extension();
                $file->move(storage_path('/app/public/upload/'.$dirname), $name);
                $files[$audio]['video'] = $name;
                if($audio == 0){
                    $files[$audio]['playAudio'] = true;
                } else {
                    $files[$audio]['playAudio'] = false;
                }
                $audio++;
            }

        }

        //Store in model
        $file = new ManualPresentation();
        $file->base = '/data0/incoming/'.$dirname;
        $file->title = $request->title;
        $file->presenters = $presenters;
        $file->tags = $tags;
        $file->courses = $courses;
        $file->thumb = $request->thumb;
        $file->created = strtotime($request->created);
        $file->duration = 0; //For now
        $file->sources = $files;
        $id = $file->save();

        // Make folder on remote and send all files

        $directory = '/upload/'.$dirname;
        $contents = Storage::disk('public')->files($directory);

        $x=1;
        try {
            foreach($contents as $sendfile) {
                $media = Storage::disk('public')->get($sendfile);

                $response = Storage::disk('sftp')->put($dirname.'/media'.$x.'.mp4', $media);
                $x++;
            }
        } catch (\RunTimeException $e) {
            dd('Error'. $e->getMessage());
        }


        // Send notify
        return redirect()->action([ManualUploadController::class, 'send'], ['id' => $file->id]);

         //return back()->with('success', 'Dina filer har lagts till');

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
        //
    }

    private function uri()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path().'/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['test']['uri'];
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
        $video->makeHidden('created_at')->makeHidden('updated_at');
        //Make json wrapper
        $json = Collection::make([
            'status' => 'success',
            'type' => 'manual'
        ]);
        $json['package'] = $video;
        $json = $json->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);


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
            return $response = $e->getResponse()->getBody();
            }
         }

        return $response->getBody();


    }
}
