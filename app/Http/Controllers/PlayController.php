<?php

namespace App\Http\Controllers;

use App\UploadHandler;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class PlayController extends Controller
{
    public function index()
    {
        // If the environment is local
        if(app()->environment('local'))
        {
            $data['play_user'] = 'Förnamn Efternamn';
        }
        else {

            $data['play_user'] = $_SERVER['displayName'];
        }

       $data['search'] = 0;
       $data['latest']= Video::with('category', 'course')->latest('id')->take(8)->get();

       return view('home.index', $data);
    }

    public function player(Video $video)
    {

        $playlist = Video::where('course_id', $video->course->id)->get();
        //dd($playlist);
        return view('player.index', ['video' => $video, 'playlist' => $playlist]);

    }


    public function upload()
    {
         $data['upload'] = 0;
        return view('video.test', $data);
    }

    public function store(Request $request)
    {
        if($request->hasFile('file'))
        {
            $path = Storage::putFileAs('public', $request->file('file'), 'upload.txt');
            if($request->file('file')->extension() == 'txt')
            {
                //Multiple streams
                $streams = new UploadHandler();
                $streams = $streams->getUpload($path);
                $x = 1;
                foreach($streams as $stream)
                {
                    //Storage::putFileAs('public', new File($stream), 'myvideo'.$x.'.mp4');
                    //
                    //$list[] =  Storage::url('myvideo'.$x.'.mp4');
                    $list[] = $stream;
                    $x++;
                }
                $data['upload'] = 1;
                $data['url'] = $list;
                return view('video.test', $data);
            }
            elseif ($request->file('file')->extension() == 'mp4') {
                //Singel stream

                //Store uploaded file in folder
                Storage::putFileAs('public', new File($request->file('file')), 'myvideo.mp4');
                $url = Storage::url('myvideo.mp4');
                $data['upload'] = 1;
                //$data['url'] = $url;
                $list[] =  $url;
                $data['url'] = $list;
                return view('video.test', $data);
            }
        }

    }
}
