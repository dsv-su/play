<?php

namespace App\Services\Upload;

use App\Jobs\JobUploadFailedNotification;
use App\ManualPresentation;
use Illuminate\Support\Collection;

class Metadata
{
    protected $sourse = [];
    protected $gsubtitles = [];

    public function create(ManualPresentation $presentation)
    {
        $Determine = new PresentationDuration();
        $Thumb = new StreamThumb();

        $finalPath = $this->storage() . '/'. $presentation->local;
        $videoPath = $finalPath . '/video/';
        $subtitlePath = $finalPath . '/subtitle/';
        //Creates the source attribute
        $presentation->sources = [];
        //Adds source and created thumbs
        foreach (\Illuminate\Support\Facades\Storage::disk('play-store')->files($videoPath) as $key => $filename) {

            //Add duration
            if($key ==  0 ) {
                if($presentation->duration = $Determine->duration($filename)) {
                    $presentation->save();
                } else {
                    //Something went wrong - Send email to uploader
                    $job = (new JobUploadFailedNotification($presentation));

                    // Dispatch Job and continue
                    dispatch($job);
                }

            }

            //Set time in sec for thumb generation
            if($presentation->duration < 30 ) {
                $thumbcreated_after = $presentation->duration/3;
            } else {
                //Fallback
                $thumbcreated_after = 30;
            }

            //Create thumb for uploaded video
            $thumburl = $Thumb->create($finalPath, $filename, $thumbcreated_after);

            //Sources

            $thumb_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($filename));
            //Add video source

            foreach(\Illuminate\Support\Facades\Storage::disk('play-store')->files($videoPath) as $stream => $f) {
                /*if($stream == 0) {
                    $this->source['main'] = Collection::make([
                        'video' => 'video/'. basename($filename),
                        'poster' => 'poster/'. $thumb_name . '.png',
                        'playAudio' => true,
                    ]);
                } else {
                    $this->source['camera'.$stream] = Collection::make([
                        'video' => 'video/'. basename($filename),
                        'poster' => 'poster/'. $thumb_name . '.png',
                        'playAudio' => false,
                    ]);
                }*/
                if($stream == 0) {
                    $this->source['main'] = [
                        'video' => 'video/'. basename($filename),
                        'poster' => 'poster/'. $thumb_name . '.png',
                        'playAudio' => true,
                    ];
                } else {
                    $this->source['camera'.$stream] = [
                        'video' => 'video/'. basename($filename),
                        'poster' => 'poster/'. $thumb_name . '.png',
                        'playAudio' => false,
                    ];
                }
            }

            $presentation->sources = $this->source;

        }

        //Subtitle
        if($subtitles = \Illuminate\Support\Facades\Storage::disk('play-store')->files($subtitlePath)) {
            /*$presentation->subtitles = Collection::make([
                'English' => 'subtitle/' . basename($subtitles[0])
            ]);*/
            $presentation->subtitles = [
                'English' => 'subtitle/' . basename($subtitles[0])
            ];
        }

        //Subtitle generation
        $this->gsubtitles['Generated'] = Collection::make([
            'type' => 'whisper',
            'source' => 'main'
        ]);
        $presentation->generate_subtitles = $this->gsubtitles;

        return $presentation->save();
    }

    private function storage()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['nfs']['storage'];
    }
}
