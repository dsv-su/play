<?php

namespace App\Services\Upload;

use App\ManualPresentation;

class Metadata
{
    protected $sourse = [];

    public function create(ManualPresentation $presentation)
    {
        $Determine = new PresentationDuration();
        $Thumb = new StreamThumb();

        $finalPath = $this->storage() . '/'. $presentation->local;
        $videoPath = $finalPath . '/video/';
        //Creates the source attribute
        $presentation->sources = [];
        foreach (\Illuminate\Support\Facades\Storage::disk('play-store')->files($videoPath) as $key => $filename) {

            //Add duration
            if($key ==  0 ) {
                $presentation->duration = $Determine->duration($filename);
                $presentation->save();
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

            //Add video source
            $this->source[$key]['video'] = 'video/'. basename($filename);

            //Add poster source
            $thumb_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($filename));
            $this->source[$key]['poster'] = 'poster/'. $thumb_name . '.png';

            //Add playAudio default setting
            if($key > 0 ) {
                $this->source[$key]['playAudio'] = false;
            } else {
                $this->source[$key]['playAudio'] = true;
            }

            $presentation->sources = $this->source;

        }
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
