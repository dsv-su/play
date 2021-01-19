<?php

namespace App\Services;

use App\Video;
use Illuminate\Database\Eloquent\Model;
use ZanySoft\Zip\Zip;

class DownloadZip extends Model
{
    protected $video, $path, $destination, $public_dir;
    protected $zipFileName, $zip;

    public function __construct(Video $video, $path)
    {
        $this->video = $video;
        $this->path = $path;
    }

    public function makezip()
    {
        //Create zip file of downloaded files and folders
        $this->destination = public_path().'/storage/'.$this->path.'/';
        $this->zipFileName = $this->destination.$this->video->presentation_id.'.zip';
        //Directory of unzipped files
        $this->public_dir = public_path().'/storage/'.$this->path;

        //Creates a zip file of the entire raw folder
        $this->zip = Zip::create( $this->zipFileName);
        $this->zip->add($this->public_dir, true); //Zip only contents of file
        $this->zip->add($this->public_dir . $this->zipFileName);
        $this->zip->close();

        return true;

    }
}
