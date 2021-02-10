<?php

namespace App\Services\Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
//use Storage;

class SftpPlayStore extends Model
{
    protected $public_path;
    protected $video_directory, $image_directory, $poster_directory;
    protected $video_remote_dir, $image_remote_dir;
    protected $presentation, $response, $contents, $sendfile, $media, $name;

    public function __construct(Model $model)
    {
        $this->presentation = $model;

        //Settings
        $this->settings();

        //Make remote directory
        $this->makeRemoteFolder($this->video_remote_dir);
        $this->makeRemoteFolder($this->image_remote_dir);
        $this->makeRemoteFolder($this->poster_remote_dir);
    }

    private function settings()
    {
        //Local public path
        $this->public_path = public_path().'/storage/';

        //Temporary directories
        $this->video_directory =  $this->presentation->local . '/video';
        $this->image_directory = $this->presentation->local . '/image';
        $this->poster_directory =  $this->presentation->local . '/poster';

        //Remote directories
        $this->video_remote_dir = $this->presentation->local . '/video';
        $this->image_remote_dir = $this->presentation->local . '/image';
        $this->poster_remote_dir = $this->presentation->local . '/poster';
    }

    private function makeRemoteFolder($folder)
    {
        Storage::disk('sftp')->makeDirectory($folder);
    }

    public function sftpVideo()
    {
        //Send video files
        $this->contents = Storage::disk('public')->files($this->video_directory);

        try {
            foreach ($this->contents as $this->sendfile) {
                $this->name = substr($this->sendfile, strrpos($this->sendfile, '/') + 1);
                //Automatic Streaming
                $this->response = Storage::disk('sftp')->putFileAs($this->video_remote_dir, new File($this->public_path.$this->sendfile), $this->name);
            }
        } catch (RunTimeException $e) {
            $this->presentation->status = 'failed';
            $this->presentation->save();
            dd('Error' . $e->getMessage());
        }
    }

    public function sftpImage()
    {
        //Send image files
        $this->contents = Storage::disk('public')->files($this->image_directory);

        try {
            foreach ($this->contents as $this->sendfile) {
                $this->name = substr($this->sendfile, strrpos($this->sendfile, '/') + 1);
                //Automatic Streaming
                $this->response = Storage::disk('sftp')->putFileAs($this->image_remote_dir, new File($this->public_path.$this->sendfile), $this->name);
            }
        } catch (RunTimeException $e) {
            dd('Error' . $e->getMessage());
        }
    }

    public function sftpPoster()
    {
        //Send poster files
        $this->contents = Storage::disk('public')->files($this->poster_directory);

        try {
            foreach ($this->contents as $this->sendfile) {
                $this->name = substr($this->sendfile, strrpos($this->sendfile, '/') + 1);
                //Automatic Streaming
                $this->response = Storage::disk('sftp')->putFileAs($this->poster_remote_dir, new File($this->public_path.$this->sendfile), $this->name);
            }
        } catch (RunTimeException $e) {
            dd('Error' . $e->getMessage());
        }
    }
}
